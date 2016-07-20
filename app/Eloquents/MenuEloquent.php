<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;

class MenuEloquent extends BaseEloquent {

    protected $model;

    public function __construct(\App\Models\Menu $model) {
        $this->model = $model;
    }

    public function rules() {
        return [];
    }

    public function all($args = []) {
        $opts = [
            'fields' => ['*'],
            'orderby' => 'pivot_title',
            'order' => 'asc',
            'per_page' => 20,
            'exclude' => [],
            'key' => '',
        ];

        $opts = array_merge($opts, $args);

        $result = current_lang()->menus()
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
        $this->validator($data, $this->rules());
        
        $item = $this->model->create($data);
        
        $menu_type = $data['menu_type'];

        foreach (get_langs() as $lang) {
            $lang_data = $data[$lang->code];

            $lang->menus()->attach($item->id, $lang_data);
        }
    }

    public function update($id, $data) {
        $this->validator($data, $this->rules());

        $fillable = $this->model->getFillable();
        $fill_data = array_only($data, $fillable);
        if(isset($data['title'])){
            $fill_data['slug'] = str_slug($data['title']);
        }
        $this->model->where('id', $id)->update($fill_data);

        foreach (get_langs() as $lang) {
            $lang_data = $data[$lang->code];

            $lang->menus()->sync([$id => $lang_data], false);
        }
    }

    public function switch_type($type) {
        
    }

    public function destroy($ids) {
        foreach (get_langs() as $lang) {
            $lang->menus()->detach($ids);
        }
        return parent::destroy($ids);
    }

}
