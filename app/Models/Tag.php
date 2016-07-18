<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'taxs';
    
    protected $fillable = ['type', 'order', 'count', 'status'];
    
    public function status(){
        switch ($this->status){
            case 0:
                return 'Disable';
            case 1:
                return 'Active';
        }
    }
}
