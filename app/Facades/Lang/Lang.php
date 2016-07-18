<?php

namespace App\Facades\Lang;

use App\Eloquents\LangEloquent;

class Lang{
    protected $lang;
    
    public function __construct(LangEloquent $lang) {
        $this->lang = $lang;
    }
    
    public function all(){
        return $this->lang->all(['field' => ['id', 'name', 'code', 'icon']]);
    }
    
    public function current(){
        return $this->lang->currentLang(['id', 'name', 'code', 'icon']);
    }
    
    public function code(){
        return $this->lang->currentLang(['code'])->code;
    }
    
    public function hasLang($code){
        $item = $this->lang->findByCode($code, ['id']);
        if($item){
            return true;
        }
        return false;
    }
}

