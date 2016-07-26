<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'taxs';
    
    protected $fillable = ['type', 'order', 'count', 'status'];
    
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
                        ->where('type', 'tag');
    }
    
    public function getName($lang=null){
        $item = $this->joinLang($lang)
                ->find($this->id, ['td.name']);
        if($item){
            return $item->name;
        }
        return null;
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
