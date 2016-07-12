<?php

namespace App\Eloquents;

use Validator;
use Session;

abstract class BaseEloquent {

    protected $error;

    public function validator(array $attrs, array $rule = [], array $message = []) {
        $valid = Validator::make($attrs, ($rule) ? $rule : static::$rules, $message);
        if ($valid->fails()) {
            $this->error = $valid->messages();
            return false;
        }
        return true;
    }

    public function getError() {
        return $this->error;
    }

    public function find($id) {
        return $this->model->find($id);
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
                $this->changeStatus($item_ids, 0);
                break;
            case 'remove':
                $this->destroy($item_ids);
                break;
        }
        Session::flash('succ_mess', trans('manage.do_success'));
        return true;
    }

}
