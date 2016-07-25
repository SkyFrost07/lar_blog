<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuCat extends Model {

    protected $table = 'taxs';
    protected $fillable = ['type'];
    
     public function joinLang($lang=null) {
        $lang = ($lang) ? $lang : current_locale();
        return self::join('tax_desc as td', 'taxs.id', '=', 'td.tax_id')
                        ->join('langs as lg', function($join) use($lang){
                            $join->on('td.lang_id', '=', 'lg.id')
                            ->where('lg.code', '=', $lang);
                        });
    }

    public function langs() {
        return $this->belongsToMany('\App\Models\Lang', 'tax_desc', 'tax_id', 'lang_id')
                        ->where('type', 'menucat');
    }
    
    public function getName(){
        return $this->joinLang()
                ->select(['tax_desc.name'])
                ->find($this->id, ['id'])
                ->name;
    }

}
