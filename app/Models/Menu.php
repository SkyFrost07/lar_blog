<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $fillable = ['group_id', 'parent_id', 'menu_type', 'type_id', 'icon', 'open_type', 'order', 'status'];
    
    public function joinLang($lang=null) {
        $lang = ($lang) ? $lang : current_locale();
        return self::join('menu_desc as md', 'menus.id', '=', 'md.menu_id')
                        ->join('langs as lg', function($join) use($lang){
                            $join->on('md.lang_id', '=', 'lg.id')
                            ->where('lg.code', '=', $lang);
                        });
    }
    
    public function langs() {
        return $this->belongsToMany('\App\Models\Lang', 'menu_desc', 'menu_id', 'lang_id');
    }
    
    public function group(){
        return $this->belongsTo('App\Models\MenuCat', 'group_id', 'id');
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
