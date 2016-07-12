<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['label', 'name', 'default'];
    
    public function caps(){
        return $this->belongsToMany('\App\Models\Cap', 'role_cap', 'cap_id', 'role_id');
    }
    
    public function scopeSearch($query, $key){
        return $query->where('name', 'like', "%$key%");
    }
    
    public function str_default(){
        if($this->default == 0){
            return 'No';
        }
        return 'Yes';
    }
}
