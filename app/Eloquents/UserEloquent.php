<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;
use App\Eloquents\RoleEloquent;

use Illuminate\Validation\ValidationException;

class UserEloquent extends BaseEloquent {

    protected $model;
    protected $elRole;

    public function __construct(\App\User $model, RoleEloquent $elRole) {
        $this->model = $model;
        $this->elRole = $elRole;
    }

    public function rules($id = null) {
        if (!$id) {
            return [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed'
            ];
        }
        return [
            'email' => 'email|unique:users,email,' . $id,
            'password' => 'min:6'
        ];
    }

    public function all($args = []) {
        $opts = [
            'field' => ['*'],
            'orderby' => 'id',
            'order' => 'asc',
            'per_page' => 20,
            'exclude' => [],
            'key' => '',
            'page' => 1
        ];

        $opts = array_merge($opts, $args);

        return $this->model->whereNotIn('id', $opts['exclude'])->search($opts['key'])->orderby($opts['orderby'], $opts['order'])->paginate($opts['per_page']);
    }

    public function insert($data) {
        if ($this->validator($data, $this->rules())) {
            $item = new $this->model();
            $data['password'] = bcrypt($data['password']);
            if(!isset($data['role_id']) || $data['role_id'] != 0){
                $data['role_id'] = $this->elRole->getDefaultId();
            }
            return $item->create($data);
        } else {
            throw new ValidationException($this->getError());
        }
    }
    
    public function update($id, $data) {
        if ($this->validator($data, $this->rules($id))) {
            $item = $this->model->find($id);
            if (isset($data['name'])) {
                $item->name = $data['name'];
            }
            if (isset($data['email']) && $data['email']) {
                $item->email = $data['email'];
            }
            if (isset($data['password']) && $data['password']) {
                $item->password = bcrypt($data['password']);
            }
            if (isset($data['role_id']) && $data['role_id'] != 0) {
                $item->role_id = $data['role_id'];
            }else{
                $item->role_id = $this->elRole->getDefaultId();
            }
            if (isset($data['status'])) {
                $item->status = $data['status'];
            }
            return $item->save();
        } else {
            throw new ValidationException($this->getError());
        }
    }

}
