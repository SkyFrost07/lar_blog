<?php

namespace App\Eloquents;

use Validator;
use Illuminate\Validation\ValidationException;
use Session;

abstract class BaseEloquent {

    protected $error;
    protected $locale;

    public function __construct() {
        $this->locale = app()->getLocale();
    }

    public function validator(array $attrs, array $rule = [], array $message = []) {
        $valid = Validator::make($attrs, ($rule) ? $rule : $this->rules(), $message);
        if ($valid->fails()) {
            $this->error = $valid->messages();
            throw new ValidationException($this->error);
        }
        return true;
    }

    public function getError() {
        return $this->error;
    }

    public function getLangs($fields = ['id', 'code', 'name']) {
        return $this->lang->all($fields);
    }

    public function find($id) {
        return $this->model->find($id);
    }

    public function get_author_id($id, $author_field = 'author_id') {
        $item = $this->model->find($id, [$author_field]);
        if ($item) {
            return $item->$author_field;
        }
        return 0;
    }

    public function insert($data) {
        if ($this->validator($data, $this->rules())) {
            $item = new $this->model();
            return $item->create($data);
        }
    }

    public function update($id, $data) {
        $this->validator($data, $this->rules($id));
        
        if(isset($data['time'])){
            $time = $data['time'];
            $date = date('Y-m-d', strtotime($time['year'].'-'.$time['month'].'-'.$time['day']));
            $data['created_at'] = $date;
        }
        $fillable = $this->model->getFillable();
        $data = array_only($data, $fillable);
        return $this->model->where('id', $id)->update($data);
    }

    public function changeStatus($ids, $status) {
        if (is_array($ids)) {
            return $this->model->whereIn('id', $ids)->update(['status' => $status]);
        } else {
            return $this->model->where('id', $ids)->update(['status' => $status]);
        }
    }

    public function destroy($ids) {
        return $this->model->destroy($ids);
    }

    public function actions($request) {
        if (!cando('manage_users')) {
            return false;
        }

        if (!$request->has('action')) {
            Session::flash('error_mess', trans('manage.na_error'));
            return false;
        }
        if (!$request->has('item_ids')) {
            Session::flash('error_mess', trans('manage.no_item'));
            return false;
        }

        $item_ids = $request->input('item_ids');
        $action = $request->input('action');
        switch ($action) {
            case 'restore':
                $this->changeStatus($item_ids, 1);
                break;
            case 'trash':
            case 'ban':
                $this->changeStatus($item_ids, 0);
                break;
            case 'disable':
                $this->changeStatus($item_ids, -1);
                break;
            case 'remove':
                $this->destroy($item_ids);
                break;
        }
        Session::flash('succ_mess', trans('manage.do_success'));
        return true;
    }

}
