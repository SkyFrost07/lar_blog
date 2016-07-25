<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;
use Illuminate\Validation\ValidationException;

class PageEloquent extends BaseEloquent {

    protected $model;

    public function __construct(\App\Models\Page $model) {
        $this->model = $model;
    }

}
