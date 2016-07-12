<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'birth', 'gender', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function role(){
        return $this->hasOne('\App\Models\Role', 'id', 'role_id');
    }
    
    public function caps(){
        return $this->role->caps;
    }
    
    public function scopeSearch($query, $key){
        return $query->where('email', 'like', "%$key%");
    }
    
    public function status(){
        switch ($this->status){
            case 0:
                return 'Disabled';
            case 1:
                return 'Baned';
            case 2:
                return 'Active';
            default:
                return 'Disabled';
        }
    }
}
