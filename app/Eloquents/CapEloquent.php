<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;

use Illuminate\Validation\ValidationException;

class CapEloquent extends BaseEloquent{
    protected $model;
    
    public function __construct(\App\Models\Cap $model) {
        $this->model = $model;
    }
    
    public function rules($id=null){
        $id = ($id) ? ','.$id : '';
        return [
            'name' => 'required|alpha_dash|unique:caps,name'.$id
        ];
    }
    
    public function all($args=[]){
        $opts = [
            'field' => ['*'],
            'orderby' => 'name',
            'order' => 'asc',
            'per_page' => 20,
            'exclude' => [],
            'key' => '',
            'page' => 1
        ];
        
        $opts = array_merge($opts, $args);
        
        return $this->model->whereNotIn('id', $opts['exclude'])->search($opts['key'])->orderby($opts['orderby'], $opts['order'])->paginate($opts['per_page']);
    }
    
    function findByName($name, $fields=['*']){
        return $this->model->where('name', $name)->select($fields)->first();
    }
    
    public function insert($data){
        if($this->validator($data, $this->rules())){
            $item = new $this->model();
            return $item->create($data);
        }else{
            throw new ValidationException($this->getError());
        }
    }
    
    public function update($id, $data){
        if($this->validator($data, $this->rules($id))){
            $item = $this->model->find($id);
            if(isset($data['label'])){
                $item->label = $data['label'];
            }
            $item->name = $data['name'];
            if(isset($data['higher'])){
                $item->higher = $data['higher'];
            }
            return $item->save();
        }else{
            throw new ValidationException($this->getError());
        }
    }
}

