<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model {

    protected $table = 'images';
    protected $fillable = ['thumb_url', 'thumb_type', 'author_id'];

    public function joinLang($lang = null) {
        $locale = ($lang) ? $lang : current_locale();
        return $this->join('image_desc as id', function($join) use ($locale) {
                    $join->on('images.id', '=', 'id.image_id')
                            ->where('id.lang_code', '=', $locale);
                });
    }
    
    public function langs() {
        return $this->belongsToMany('\App\Models\Lang', 'image_desc', 'image_id', 'lang_code');
    }
    
    public function author() {
        return $this->belongsTo('\App\User', 'author_id', 'id')
                        ->select('id', 'name');
    }
    
    public function albums(){
        return $this->belongsToMany('\App\Models\Album', 'image_tax', 'image_id', 'tax_id')
                        ->where('taxs.type', 'album');
    }
    
    public function str_status(){
        if($this->status == 1){
            return trans('manage.enable');
        }
        return trans('manage.disable');
    }

}
