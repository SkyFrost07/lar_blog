<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lang extends Model {

    protected $table = 'langs';
    protected $fillable = ['name', 'code', 'icon', 'folder', 'unit', 'ratio_currency', 'order', 'status', 'default'];

    public function switch_url() {
        $request = request();
        $locale = $this->code;
        if (!hasLang($locale)) {
            $locale = config('app.fallback_locale');
        }
        app()->setLocale($locale);
        $segments = $request->segments(); 
        $segments[0] = $locale;
        return $request->getHost.'/'.implode('/', $segments);
    }

    public function scopeSearch($query, $key) {
        return $query->where('name', 'like', "%$key%");
    }

    public function icon() {
        if ($this->icon) {
            $src = '/images/flags/' . $this->icon;
            return '<img width="30" src="' . $src . '">';
        }
        return null;
    }

    public function status() {
        switch ($this->status) {
            case 1:
                return 'Active';
            case -1:
                return 'Disable';
        }
    }

    public function is_default() {
        if ($this->default == 1) {
            return 'Yes';
        }
        return 'No';
    }

    public function cats() {
        return $this->belongsToMany('\App\Models\Cat', 'tax_desc', 'lang_id', 'tax_id')
                        ->withPivot('name', 'slug', 'description', 'meta_desc', 'meta_keyword')
                        ->where('type', 'cat');
    }
    
    public function cat_pivot($cat_id){
        $item = $this->cats()->find($cat_id, ['id']);
        if($item){
            return $item->pivot;
        }
        return null;
    }
    
    public function tags(){
        return $this->belongsToMany('\App\Models\Tag', 'tax_desc', 'lang_id', 'tax_id')
                ->withPivot('name', 'slug', 'description', 'meta_keyword', 'meta_desc')
                ->where('type', 'tag');
    }
    
    public function tag_pivot($tag_id){
        $item = $this->tags()->find($tag_id, ['id']);
        if($item){
            return $item->pivot;
        }
        return null;
    }

}
