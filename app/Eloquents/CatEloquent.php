<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;
use App\Exceptions\DbException;
use DB;
use Form;

class CatEloquent extends BaseEloquent {

    protected $model;

    public function __construct(\App\Models\Cat $model) {
        parent::__construct();

        $this->model = $model;
    }

    public function rules($update = null) {
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
                ->where('type', 'cat')
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
        $fill_data = array_only($data, $fillable);
        $item = $this->model->create($fill_data);

        if (isset($fill_data['parent_id']) && $fill_data['parent_id']) {
            $parent_id = $fill_data['parent_id'];
            $parent_ids = DB::table('tax_relations')->distinct()->where('tax_id', $parent_id)->lists('parent_id');
            array_push($parent_ids, $parent_id);
            $item->relations()->attach($parent_ids);
        }

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
        if($item){
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
        
        if (isset($fill_data['parent_id']) && $fill_data['parent_id']) {
            $parent_id = $fill_data['parent_id'];
            $parent_ids = DB::table('tax_relations')->distinct()->where('tax_id', $parent_id)->lists('parent_id');
            array_push($parent_ids, $parent_id);
            $item->relations()->sync($parent_ids);
        }

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

    public function tableCats($items, $parent = 0, $depth = 0) {
        $html = '';
        $indent = str_repeat("-- ", $depth);
        foreach ($items as $item) {
            if ($item->parent_id == $parent && $item->name) {
                $html .= '<tr>';
                $html .= '<td><input type="checkbox" name="checked[]" class="checkitem" value="' . $item->id . '" /></td>
                <td>' . $item->id . '</td>
                <td>' . $indent . ' ' . $item->name . '</td>
                <td>' . $item->slug . '</td>
                <td>' . $item->parent_name() . '</td>
                <td>' . $item->order . '</td>
                <td><a href="'.route('post.index', ['cats' => [$item->id], 'status' => 1]).'">' . $item->count . '</a></td>
                <td>
                    <a href="' . route('cat.edit', ['id' => $item->id]) . '" class="btn btn-sm btn-info" title="' . trans('manage.edit') . '"><i class="fa fa-edit"></i></a>
                    
                    ' . Form::open(['method' => 'delete', 'route' => ['cat.destroy', $item->id], 'class' => 'form-inline remove-btn', 'title' => trans('manage.remove')]) . '
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    ' . Form::close() . '
                </td>';
                $html .= '</tr>';
                $html .= $this->tableCats($items, $item->id, $depth + 1);
            }
        }
        return $html;
    }

}
