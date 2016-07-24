<?php

namespace App\Exceptions;

use Exception;

class DbException extends Exception{
    protected $error;
    
    public function __construct($errors=null, $code=0, $previous=null) {
        if(!$errors){
            $errors = trans('manage.fails_database');
        }
        $this->error = $errors;
        parent::__construct($errors, $code, $previous);
    }
    public function getError(){
        return $this->error;
    }
    public function getMess(){
        return $this->error;
    }
}
