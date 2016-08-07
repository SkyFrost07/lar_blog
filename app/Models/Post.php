<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Post extends Model {

    protected $table = 'posts';
    public $dates = ['trashed_at'];
    protected $fillable = ['thumb_id', 'thumb_ids', 'author_id', 'status', 'comment_status', 'comment_count', 'post_type', 'views', 'template', 'trased_at', 'created_at', 'updated_at'];

    public function joinLang($lang = null) {
        $locale = ($lang) ? $lang : current_locale();
        return $this->join('post_desc as pd', 'posts.id', '=', 'pd.post_id')
                        ->join('langs as lg', function($join) use ($locale) {
                            $join->on('pd.lang_id', '=', 'lg.id')
                            ->where('lg.code', '=', $locale);
                        });
    }

    public function joinCats($ids = []) {
        $this->joinLang()
                ->join('post_tax as pt', function($join) use ($ids) {
                    $join->on('posts.id', '=', 'pt.post_id')
                    ->whereIn('tax_id', $ids);
                });
    }

    public function cats($lang=null) {
        $lang = $lang ? $lang : current_locale();
        return $this->belongsToMany('\App\Models\Cat', 'post_tax', 'post_id', 'tax_id')
                        ->join('tax_desc as td', 'taxs.id', '=', 'td.tax_id')
                        ->join('langs as lg', function($join) use ($lang){
                            $join->on('td.lang_id', '=', 'lg.id')
                            ->where('lg.code', '=', $lang);
                        })
                        ->select(['taxs.id', 'td.slug', 'td.name', 'taxs.parent_id'])
                        ->where('taxs.type', 'cat');
    }

    public function tags($lang = null) {
        $lang = $lang ? $lang : current_locale();
        return $this->belongsToMany('\App\Models\Tag', 'post_tax', 'post_id', 'tax_id')
                ->join('tax_desc as td', 'taxs.id', '=', 'td.tax_id')
                        ->join('langs as lg', function($join) use ($lang){
                            $join->on('td.lang_id', '=', 'lg.id')
                            ->where('lg.code', '=', $lang);
                        })
                        ->select(['taxs.id', 'td.slug', 'td.name', 'taxs.parent_id'])
                        ->where('taxs.type', 'tag');
    }

    public function author() {
        return $this->belongsTo('\App\User', 'author_id', 'id')
                        ->select('id', 'name');
    }

    public function langs() {
        return $this->belongsToMany('\App\Models\Lang', 'post_desc', 'post_id', 'lang_id')
                        ->where('post_type', 'post');
    }

    public function getCats($fields = ['taxs.id', 'td.slug', 'td.name'], $locale = null) {
        $locale = ($locale) ? $locale : current_locale();
        return $this->join('post_tax as pt', 'posts.id', '=', 'pt.post_id')
                        ->join('taxs', 'pt.tax_id', '=', 'taxs.id')
                        ->join('tax_desc as td', 'pt.tax_id', '=', 'td.tax_id')
                        ->join('langs as lg', function($join) use ($locale) {
                            $join->on('td.lang_id', '=', 'lg.id')
                            ->where('lg.code', '=', $locale);
                        })
                        ->where('posts.id', '=', $this->id)
                        ->where('taxs.type', '=', 'cat')
                        ->get($fields);
    }

    public function image() {
        return $this->belongsTo('\App\Models\File', 'thumb_id', 'id');
    }

    public function getImage($size = 'full') {
        return getImageSrc($this->thumb_id, $size);
    }

    public function str_status() {
        if ($this->status == 0) {
            return 'Trash';
        }
        return 'Active';
    }

}
