<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;
use Illuminate\Validation\ValidationException;

class PostEloquent extends BaseEloquent {

    protected $model;

    public function __construct(\App\Models\Post $model) {
        $this->model = $model;
    }

}
