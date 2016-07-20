<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $fillable = ['group_id', 'parent_id', 'menu_type', 'type_id', 'icon', 'open_type', 'order', 'status'];
    
    public function group(){
        return $this->belongsTo('App\Models\MenuCat', 'group_id', 'id')
                ->select('id');
    }
    
    public function group_name(){
        if($this->group_id){
            $group = current_lang()->menucats()->find($this->group_id, ['id']);
            if($group){
                return $group->pivot->name;
            }
        }
        return null;
    }
    
    public function status(){
        if($this->status == 1){
            return 'Active';
        }
        return 'Disable';
    }
    
    public function str_open_type(){
        if($this->open_type){
            return 'New tab';
        }
        return 'Current tab';
    }
}
