<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;

class MenuCatEloquent extends BaseEloquent {

    protected $model;

    public function __construct(\App\Models\MenuCat $model) {
        $this->model = $model;
    }
    
    public function rules() {
        $code = app()->getLocale();
        $rules = [];
        $rules[$code . '.name'] = 'required';
        return $rules;
    }

    public function all($args = []) {
        $opts = [
            'fields' => ['*'],
            'orderby' => 'pivot_name',
            'order' => 'asc',
            'per_page' => 20,
            'exclude' => [],
            'key' => '',
        ];

        $opts = array_merge($opts, $args);

        $result = current_lang()->menucats()
                ->where('name', 'like', '%' . $opts['key'] . '%')
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
        $this->validator($data, $this->rules());

        $fillable = $this->model->getFillable();
        $data['type'] = 'menucat';
        $fill_data = array_only($data, $fillable);
        $item = $this->model->create($fill_data);

        foreach (get_langs() as $lang) {
            $lang_data = $data[$lang->code];
            $name = $lang_data['name'];
            $slug = $lang_data['slug'];
            $lang_data['slug'] = (trim($slug) == '') ? str_slug($name) : str_slug($slug);
            
            if($name){
                $lang->menucats()->attach($item->id, $lang_data);
            }
        }
    }

    public function update($id, $data) {
        $this->validator($data, $this->rules());

        $fillable = $this->model->getFillable();
        $fill_data = array_only($data, $fillable);
        $this->model->where('id', $id)->update($fill_data);

        foreach (get_langs() as $lang) {
            $lang_data = $data[$lang->code];
            $name = $lang_data['name'];
            $slug = $lang_data['slug'];
            $lang_data['slug'] = (trim($slug) == '') ? str_slug($name) : str_slug($slug);
                
            $lang->menucats()->sync([$id =>$lang_data], false);
        }
    }

    public function destroy($ids) {
        foreach (get_langs() as $lang) {
            $lang->menucats()->detach($ids);
        }
        return parent::destroy($ids);
    }

}
