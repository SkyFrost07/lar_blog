<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;

class PageEloquent extends BaseEloquent {

    protected $model;

    public function __construct(\App\Models\Page $model) {
        $this->model = $model;
    }

    public function rules($update = false) {
        if (!$update) {
            $code = current_locale();
            return [
                $code . '.title' => 'required'
            ];
        }
        return [
            'locale.title' => 'required',
            'lang' => 'required'
        ];
    }

    public function all($args = []) {
        $opts = [
            'fields' => ['posts.*', 'pd.*'],
            'status' => 1,
            'orderby' => 'posts.created_at',
            'order' => 'desc',
            'per_page' => 20,
            'exclude' => [],
            'key' => ''
        ];

        $opts = array_merge($opts, $args);

        $result = $this->model->joinLang()
                ->where('post_type', 'page')
                ->where('posts.status', $opts['status'])
                ->where('pd.title', 'like', '%' . $opts['key'] . '%')
                ->whereNotIn('posts.id', $opts['exclude'])
                ->select($opts['fields'])
                ->orderBy($opts['orderby'], $opts['order']);

        if ($opts['per_page'] == -1) {
            $result = $result->get();
        } else {
            $result = $result->paginate($opts['per_page']);
        }
        return $result;
    }

    public function insert($data) {
        $this->validator($data, $this->rules());

        $data['author_id'] = auth()->id();
        $data['post_type'] = 'page';
        if (isset($data['time'])) {
            $time = $data['time'];
            $data['created_at'] = date('Y-m-d H:i:s', strtotime($time['year'] . '-' . $time['month'] . '-' . $time['day'] . ' ' . date('H:i:s')));
        }
        if($data['thumb_id']){
            $data['thumb_id'] = cutImgPath($data['thumb_id']);
        }
        $item = $this->model->create($data);

        $langs = get_langs(['fields' => ['id', 'code']]);

        foreach ($langs as $lang) {
            $lang_data = $data[$lang->code];
            $title = $lang_data['title'];
            $slug = $lang_data['slug'];

            $lang_data['slug'] = ($slug) ? str_slug($slug) : str_slug($title);

            $item->langs()->attach($lang->id, $lang_data);
        }

        return $item;
    }
    
    public function findByLang($id, $fields = ['posts.*', 'pd.*'], $lang = null) {
        $item = $this->model->joinLang($lang)
                ->find($id, $fields);
        if($item){
            return $item;
        }
        return $this->model->find($id);
    }

    public function update($id, $data) {
        $this->validator($data, $this->rules(true));

        if (isset($data['time'])) {
            $time = $data['time'];
            $data['created_at'] = date('Y-m-d H:i:s', strtotime($time['year'] . '-' . $time['month'] . '-' . $time['day'] . ' ' . date('H:i:s')));
        }
        if($data['thumb_id']){
            $data['thumb_id'] = cutImgPath($data['thumb_id']);
        }
        $fillable = $this->model->getFillable();
        $fill_data = array_only($data, $fillable);
        $item = $this->model->find($id);
        $item->update($fill_data);

        $lang_id = get_lang_id($data['lang']);
        
        $lang_data = $data['locale'];
        $name = $lang_data['title'];
        $slug = $lang_data['slug'];
        $lang_data['slug'] = (trim($slug) == '') ? str_slug($name) : str_slug($slug);

        $item->langs()->sync([$lang_id => $lang_data], false);
    }

    public function destroy($ids) {
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        if ($ids) {
            foreach ($ids as $id) {
                $item = $this->model->find($id);
                if ($item) {
                    $item->langs()->detach();
                    $item->delete();
                }
            }
            return true;
        }
        return false;
    }

}
