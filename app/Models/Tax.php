<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $table = 'taxs';
    protected $fillable = ['image_id', 'type', 'parent_id', 'order', 'cout', 'count', 'status'];

    public function joinLang($lang=null) {
        $lang = ($lang) ? $lang : current_locale();
        return $this->join('tax_desc as td', 'taxs.id', '=', 'td.tax_id')
                        ->join('langs as lg', function($join) use($lang){
                            $join->on('td.lang_id', '=', 'lg.id')
                            ->where('lg.code', '=', $lang);
                        });
    }
    
    public function getName($lang=null){
        $item = $this->joinLang($lang)
                ->find($this->id, ['td.name']);
        if($item){
            return $item->name;
        }
        return null;
    }

    public function status() {
        switch ($this->status) {
            case 0:
                return trans('manage.disable');
            case 1:
                return trans('manage.enable');
        }
    }
}
