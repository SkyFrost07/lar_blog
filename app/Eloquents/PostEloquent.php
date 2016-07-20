<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;

class PostEloquent extends BaseEloquent {

    protected $model;

    public function __construct(\App\Models\Post $model) {
        $this->model = $model;
    }

    public function rules() {
        $code = app()->getLocale();
        return [
            $code . '.title' => 'required'
        ];
    }

    public function all($args = []) {
        $opts = [
            'fields' => ['*'],
            'status' => 1,
            'orderby' => 'created_at',
            'order' => 'desc',
            'per_page' => 20,
            'exclude' => [],
            'key' => '',
        ];

        $opts = array_merge($opts, $args);

        $result = current_lang()->posts()
                ->where('status', $opts['status'])
                ->where('title', 'like', '%' . $opts['key'] . '%')
                ->whereNotIn('id', $opts['exclude'])
                ->select($opts['fields'])
                ->orderby($opts['orderby'], $opts['order']);
        if ($opts['per_page'] == -1) {
            $result = $result->get();
        } else {
            $result = $result->paginate($opts['per_page']);
        }
        return $result;
    }

    public function insert($data) {
        if ($this->validator($data)) {

            $data['author_id'] = auth()->id();
            $item = $this->model->create($data);

            if (isset($data['cat_ids'])) {
                $cats = $item->cats();
                $cats->attach($data['cat_ids']);
            }

            foreach (get_langs() as $lang) {
                $lang_data = $data[$lang->code];
                $title = $lang_data['title'];
                $slug = $lang_data['slug'];

                $lang_data['slug'] = ($slug) ? str_slug($slug) : str_slug($title);

                if ($title) {
                    $lang->posts()->attach($item->id, $lang_data);
                }
            }
        }
    }

    public function update($id, $data) {
        if ($this->validator($data)) {
            $fillable = $this->model->getFillable();
            $fill_data = array_only($data, $fillable);
            $item = $this->model->find($id);
            $item->update($fill_data);
            
            $item->cats()->detach();
            if(isset($data['cat_ids'])){
                $item->cats()->attach($data['cat_ids']);
            }
            
            if(isset($data['tag_ids'])){
                $item->tags()->attach($data['tag_ids']);
            }

            foreach (get_langs() as $lang) {
                $lang_data = $data[$lang->code];
                $name = $lang_data['title'];
                $slug = $lang_data['slug'];
                $lang_data['slug'] = (trim($slug) == '') ? str_slug($name) : str_slug($slug);

                $lang->posts()->sync([$id => $lang_data], false);
            }
        }
    }
    
    public function destroy($ids) {
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        if ($ids) {
            foreach ($ids as $id) {
                $item = $this->model->find($id);
                if($item){
                    $item->tags()->detach();
                    $item->cats()->detach();
                    $item->langs()->detach();
                    $item->delete();
                }
            }
            return true;
        }
        return false;
    }

}
