<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;
use Form;

class MenuCatEloquent extends BaseEloquent {

    protected $model;

    public function __construct(\App\Models\MenuCat $model) {
        $this->model = $model;
    }

    public function rules($update = false) {
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

        $data['type'] = 'menucat';
        $item = $this->model->create($data);

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
        if ($item) {
            return $item;
        }
        return $this->model->find($id);
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
    }

    public function toNested($items, $parent = 0) {
        $results = [];
        foreach ($items as $item) {
            if ($item->parent_id == $parent) {
                $nitem = $item;
                $childs = $this->toNested($items, $item->id);
                $nitem['childs'] = $childs;
                $results[] = $nitem;
            }
        }
        return $results;
    }

    public function nestedMenus($lists, $parent) {
        $output = '';
        foreach ($lists as $key => $item) {
            if ($item->parent_id == $parent) {
                $output .= '<li data-id="' . $item->id . '" class="dd-item dd3-item">';
                $output.= '<div class="dd-handle dd3-handle"></div>';
                $output.= '<div class="dd3-content">'
                        . '<span class="title">' . $item->title . '</span>'
                        . '<span class="actions">'
                        . '<a href="#menu-edit-' . $item->id . '" data-toggle="collapse" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>'
                        . '</span>'
                        . '</div>'
                        . '<div id="menu-edit-' . $item->id . '" class="mi-content collapse">'
                        . '<div class="form-group"><label>' . trans('manage.title') . '</label>'
                        . Form::text('menus[' . $item->id . '][locale][title]', $item->title, ['class' => 'form-control'])
                        . '</div>'
                        . '<div class="form-group"><label>' . trans('manage.open_type') . '</label>'
                        . Form::select('menus[' . $item->id . '][open_type]', ['' => trans('manage.current_tab'), '_blank' => trans('manage.new_tab')], $item->open_type, ['class' => 'form-control'])
                        . '</div>'
                        . '<div class="form-group"><label>' . trans('manage.icon') . '</label>'
                        . Form::text('menus[' . $item->id . '][icon]', $item->icon, ['class' => 'form-control'])
                        . '</div>'
                        . '</div>';
                $output2 = $this->nestedMenus($lists, $item->id);
                if ($output2 != '') {
                    $output .= '<ol class="childs dd-list">' . $output2 . '</ol>';
                }
                $output .= '</li>';
            }
        }
        return $output;
    }

}
