<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;
use App\Exceptions\DbException;
use DB;
use Form;

class CatEloquent extends BaseEloquent {

    protected $model;

    public function __construct(\App\Models\Cat $model) {
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
            'orderby' => 'id',
            'order' => 'asc',
            'per_page' => 20,
            'exclude' => [],
            'key' => '',
        ];

        $opts = array_merge($opts, $args);

        $result = current_lang()->cats()
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

    public function findByName($name, $fields = ['*']) {
        return $this->model->where('name', $name)->select($fields)->first();
    }

    public function show($id, $args) {
        
    }

    public function insert($data) {
        $this->validator($data, $this->rules());

        $fillable = $this->model->getFillable();
        $fill_data = array_only($data, $fillable);
        $item = $this->model->create($fill_data);
        
        if(isset($fill_data['parent_id']) && $fill_data['parent_id']){
            $item->relations()->attach($fill_data['parent_id']);
        }

        foreach (get_langs() as $lang) {
            $lang_data = $data[$lang->code];
            $name = $lang_data['name'];
            $slug = $lang_data['slug'];
            $lang_data['slug'] = (trim($slug) == '') ? str_slug($name) : str_slug($slug);

            $lang->cats()->attach($item->id, $lang_data);
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
                
            $lang->cats()->updateExistingPivot($id, $lang_data);
        }
    }

    public function destroy($ids) {
        foreach (get_langs() as $lang) {
            $lang->cats()->detach($ids);
        }
        parent::destroy($ids);
    }

    public function tableCats($items, $parent = 0, $depth=0) {
        $html = '';
        $indent = str_repeat("-- ", $depth);
        foreach ($items as $item) {
            if ($item->parent_id == $parent) {
                $html .= '<tr>';
                $html .= '<td><input type="checkbox" name="checked[]" class="checkitem" value="' . $item->id . '" /></td>
                <td>' . $item->id . '</td>
                <td>' . $indent.' '.$item->pivot->name . '</td>
                <td>' . $item->pivot->slug . '</td>
                <td>' . $item->parent_name() . '</td>
                <td>' . $item->order . '</td>
                <td>' . $item->count . '</td>
                <td>' . $item->status() . '</td>
                <td>
                    <a href="' . route('cat.edit', ['id' => $item->id]) . '" class="btn btn-sm btn-info" title="' . trans('manage.edit') . '"><i class="fa fa-edit"></i></a>
                    
                    ' . Form::open(['method' => 'delete', 'route' => ['cat.destroy', $item->id], 'class' => 'form-inline remove-btn', 'title' => trans('manage.destroy')]) . '
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    ' . Form::close() . '
                </td>';
                $html .= '</tr>';
                $html .= $this->tableCats($items, $item->id, $depth+1);
            }
        }
        return $html;
    }

}
