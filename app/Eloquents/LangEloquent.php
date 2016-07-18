<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;
use Illuminate\Validation\ValidationException;

class LangEloquent extends BaseEloquent {

    protected $model;

    public function __construct(\App\Models\Lang $model) {
        $this->model = $model;
    }

    public function rules($id = null) {
        if (!$id) {
            return [
                'name' => 'required',
                'code' => 'required|unique:langs,code',
                'icon' => 'required',
                'folder' => 'required',
                'unit' => 'required',
                'ratio_currency' => 'required|numeric'
            ];
        } else {
            return [
                'code' => 'required|unique:langs,code,'.$id
            ];
        }
    }

    public function all($args = []) {
        $opts = [
            'status' => 1,
            'field' => ['*'],
            'orderby' => 'order',
            'order' => 'asc',
            'per_page' => 20,
            'exclude' => [],
            'key' => '',
            'page' => 1
        ];

        $opts = array_merge($opts, $args);

        return $this->model
                ->where('status', $opts['status'])
                ->whereNotIn('id', $opts['exclude'])
                ->search($opts['key'])
                ->orderby($opts['orderby'], $opts['order'])
                ->select($opts['field'])
                ->paginate($opts['per_page']);
    }

    function findByName($name, $fields = ['*']) {
        return $this->model->where('name', $name)->select($fields)->first();
    }
    
    public function findByCode($code, $fields=['*']){
        return $this->model->where('code', $code)->first($fields);
    }
    
    public function currentLang($fields=['*']){
        $current_locale = app()->getLocale();
        $lang = $this->model->where('code', $current_locale)->first($fields);
        if($lang){
            return $lang;
        }
        return $this->model->first($fields);
    }

}
