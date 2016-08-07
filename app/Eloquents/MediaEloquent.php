<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;
use Illuminate\Validation\ValidationException;

class MediaEloquent extends BaseEloquent {

    protected $model;

    public function __construct(\App\Models\Media $model) {
        $this->model = $model;
    }
    
    public function rules($update = false) {
        if (!$update) {
            $code = current_locale();
            return [
                $code . '.name' => 'required',
                'thumb_url' => 'required'
            ];
        }
        return [
            'locale.name' => 'required',
            'thumb_url' => 'required',
            'lang' => 'required'
        ];
    }

    public function all($args = []) {
        $opts = [
            'fields' => ['images.*', 'id.*'],
            'status' => 1,
            'orderby' => 'images.created_at',
            'order' => 'desc',
            'per_page' => 20,
            'exclude' => [],
            'key' => '',
            'albums' => []
        ];

        $opts = array_merge($opts, $args);

        $result = $this->model->joinLang();
        
        if($opts['albums']){
            $album_ids = $opts['albums'];
            $result = $result->join('image_tax as it', function($join) use($album_ids){
                $join->on('it.image_id', '=', 'images.id')
                        ->whereIn('tax_id', $album_ids);
            });
        }
        
        $result = $result->where('images.status', $opts['status'])
                ->where('id.name', 'like', '%' . $opts['key'] . '%')
                ->whereNotIn('images.id', $opts['exclude'])
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
        if (isset($data['time'])) {
            $time = $data['time'];
            $data['created_at'] = date('Y-m-d H:i:s', strtotime($time['year'] . '-' . $time['month'] . '-' . $time['day'] . ' ' . date('H:i:s')));
        }
        if(isset($data['thumb_url'])){
            $data['thumb_url'] = cutImgPath($data['thumb_url']);
        }
        $item = $this->model->create($data);

        $langs = get_langs(['fields' => ['id', 'code']]);

        if (isset($data['cat_ids'])) {
            $item->albums()->attach($data['cat_ids']);
            $item->albums()->increment('count');
        }

        foreach ($langs as $lang) {
            $lang_data = $data[$lang->code];
            $title = $lang_data['name'];
            $slug = $lang_data['slug'];

            $lang_data['slug'] = ($slug) ? str_slug($slug) : str_slug($title);

            $item->langs()->attach($lang->code, $lang_data);
        }

        return $item;
    }

    public function findByLang($id, $fields = ['images.*', 'id.*'], $lang = null) {
        $item = $this->model->joinLang($lang)
                ->find($id, $fields);
        if (!$item) {
            $item = $this->model->find($id);
        }
        return $item;
    }

    public function update($id, $data) {
        $this->validator($data, $this->rules(true));

        if($data['thumb_url']){
            $data['thumb_url'] = cutImgPath($data['thumb_url']);
        }
        $fillable = $this->model->getFillable();
        $fill_data = array_only($data, $fillable);
        $item = $this->model->find($id);
        $item->update($fill_data);
        
        if (isset($data['cat_ids'])) {
            $item->albums()->decrement('count');
            $item->albums()->detach();
            $item->albums()->attach($data['cat_ids']);
            $item->albums()->increment('count');
        }
        
        $lang_data = $data['locale'];
        $name = $lang_data['name'];
        $slug = $lang_data['slug'];
        $lang_data['slug'] = (trim($slug) == '') ? str_slug($name) : str_slug($slug);

        $item->langs()->sync([$data['lang'] => $lang_data], false);
    }

    public function destroy($ids) {
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        if ($ids) {
            foreach ($ids as $id) {
                $item = $this->model->find($id);
                if ($item) {
                    $item->albums()->decrement('count');
                    $item->albums()->detach();
                    $item->langs()->detach();
                    $item->delete();
                }
            }
            return true;
        }
        return false;
    }

}
