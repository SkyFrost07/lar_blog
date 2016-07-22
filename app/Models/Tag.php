<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'taxs';
    
    protected $fillable = ['type', 'order', 'count', 'status'];
    
    public function langs($locale=null){
        if(is_null($locale)){
            $locale = current_locale();
        }
        return $this->belongsToMany('\App\Models\Lang', 'tax_desc', 'tax_id', 'lang_id')
                ->withPivot('name')
                ->where('code', $locale)->first([]);
    }
    
    public function current_locale(){
        return current_lang()->tags()->find($this->id, [])->pivot;
    }
    
    public function status(){
        switch ($this->status){
            case 0:
                return 'Disable';
            case 1:
                return 'Active';
        }
    }
}
