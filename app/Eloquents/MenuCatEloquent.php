<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;

class MenuCatEloquent extends BaseEloquent {

    protected $model;

    public function __construct(\App\Models\MenuCat $model) {
        $this->model = $model;
    }
    
    public function rules($update) {
        $code = current_locale();
        if (!$update) {
            return [
                $code . '.name' => 'required'
            ];
        } else {
            return [
                'locale.name' => 'required',
                'lang' => 'required'
            ];
        }
    }

    public function all($args = []) {
        $opts = [
            'fields' => ['taxs.*', 'td.*'],
            'orderby' => 'td.name',
            'order' => 'asc',
            'per_page' => 20,
            'exclude' => [],
            'key' => '',
        ];
        $opts = array_merge($opts, $args);

        $result = $this->model->joinLang()
                ->where('type', 'menucat')
                ->whereNotNull('td.name')
                ->where('td.name', 'like', '%' . $opts['key'] . '%')
                ->whereNotIn('taxs.id', $opts['exclude'])
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

        $fillable = $this->model->getFillable();
        $data['type'] = 'menucat';
        $fill_data = array_only($data, $fillable);
        $item = $this->model->create($fill_data);

        foreach (get_langs(['fields' => ['id', 'code']]) as $lang) {
            $lang_data = $data[$lang->code];
            $name = $lang_data['name'];
            $slug = $lang_data['slug'];
            $lang_data['slug'] = (trim($slug) == '') ? str_slug($name) : str_slug($slug);

            $item->langs()->attach($lang->id, $lang_data);
        }
    }
    
    public function findByLang($id, $fields = ['taxs.*', 'td.*'], $lang = null) {
        $item = $this->model->joinLang($lang)
                ->find($id, $fields);
        return $item;
    }

    public function update($id, $data) {
        $this->validator($data, $this->rules(true));

        $fillable = $this->model->getFillable();
        $fill_data = array_only($data, $fillable);
        $item = $this->model->findOrFail($id);
        $item->update($fill_data);

        $lang_id = get_lang_id($data['lang']);

        $lang_data = $data['locale'];
        $name = $lang_data['name'];
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
                $item->langs()->detach();
            }
        }

        return parent::destroy($ids);
    }

}
