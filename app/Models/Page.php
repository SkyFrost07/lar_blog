<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'posts';
    public $dates = ['trashed_at'];
    protected $fillable = ['thumb_id', 'thumb_ids', 'author_id', 'status', 'comment_status', 'comment_count', 'post_type', 'views', 'template', 'trased_at', 'created_at', 'updated_at'];

    public function joinLang($lang = null) {
        $locale = $lang ? $lang : current_locale();
        return self::join('post_desc as pd', 'posts.id', '=', 'pd.post_id')
                        ->join('langs as lg', function($join) use ($locale) {
                            $join->on('pd.lang_id', '=', 'lg.id')
                            ->where('lg.code', '=', $locale);
                        });
    }
    
    public function langs() {
        return $this->belongsToMany('\App\Models\Lang', 'post_desc', 'post_id', 'lang_id')
                ->where('post_type', 'page');
    }
}
