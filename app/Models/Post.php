<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    
    public $dates = ['trashed_at'];
    
    protected $fillable = ['thumb_id', 'thumb_ids', 'author_id', 'status', 'comment_status', 'comment_count', 'post_type', 'views', 'template', 'trased_at'];
    
    public function cats(){
        return $this->belongsToMany('\App\Models\Cat', 'post_tax', 'post_id', 'tax_id')
                ->where('type', 'cat');
    }
    
    public function tags(){
        return $this->belongsToMany('\App\Models\Tag', 'post_tax', 'post_id', 'tax_id')
                ->where('type', 'tag');
    }
    
    public function author(){
        return $this->belongsTo('\App\User', 'author_id', 'id')
                ->select('id', 'name');
    }
    
    public function langs(){
        return $this->belongsToMany('\App\Models\Lang', 'post_desc', 'post_id', 'lang_id');
    }
    
    public function str_status(){
        if($this->status == 0){
            return 'Trash';
        }
        return 'Active';
    }
}
