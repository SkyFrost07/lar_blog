<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;
use DB;

class PostEloquent extends BaseEloquent {

    protected $model;
    protected $tag;

    public function __construct(\App\Models\Post $model, \App\Models\Tag $tag) {
        $this->model = $model;
        $this->tag = $tag;
    }

    public function rules($update = false) {
        if (!$update) {
            $code = current_locale();
            return [
                $code . '.title' => 'required'
            ];
        }
        return [
            'locale.title' => 'required',
            'lang' => 'required'
        ];
    }

    public function all($args = []) {
        $opts = [
            'fields' => ['posts.*', 'pd.*'],
            'status' => 1,
            'orderby' => 'posts.created_at',
            'order' => 'desc',
            'per_page' => 20,
            'exclude' => [],
            'key' => '',
            'cats' => [],
            'tags' => [],
            'with_cats' => false,
            'with_tags' => false
        ];

        $opts = array_merge($opts, $args);

        $result = $this->model->joinLang();

        if ($opts['cats']) {
            $cat_ids = DB::table('tax_relations')
                    ->whereIn('parent_id', $opts['cats'])
                    ->select('tax_id')
                    ->lists('tax_id');
            $cat_ids = array_merge($opts['cats'], $cat_ids);

            $result = $result->join('post_tax as pt', function($join) use ($cat_ids) {
                $join->on('posts.id', '=', 'pt.post_id')
                        ->whereIn('tax_id', $cat_ids);
            });
        }
        if ($opts['tags']) {
            $tag_ids = $opts['tags'];
            $result = $result->join('post_tax as pt', function($join) use ($tag_ids) {
                $join->on('posts.id', '=', 'pt.post_id')
                        ->whereIn('tax_id', $tag_ids);
            });
        }

        $result = $result->where('post_type', 'post')
                ->where('posts.status', $opts['status'])
                ->where('pd.title', 'like', '%' . $opts['key'] . '%')
                ->whereNotIn('posts.id', $opts['exclude'])
                ->select($opts['fields'])
                ->groupBy('posts.id')
                ->orderBy($opts['orderby'], $opts['order']);

        if ($opts['with_cats']) {
            $result->with('cats');
        }
        if ($opts['with_tags']) {
            $result->with('tags');
        }

        if ($opts['per_page'] == -1) {
            $result = $result->get();
        } else {
            $result = $result->paginate($opts['per_page']);
        }
        return $result;
    }

    public function insert($data) {
        $this->validator($data, $this->rules());

        $data['author_id'] = auth()->id();
        if (isset($data['time'])) {
            $time = $data['time'];
            $data['created_at'] = date('Y-m-d H:i:s', strtotime($time['year'] . '-' . $time['month'] . '-' . $time['day'] . ' ' . date('H:i:s')));
        }
        if (isset($data['thumb_id'])) {
            $data['thumb_id'] = cutImgPath($data['thumb_id']);
        }
        $item = $this->model->create($data);

        $langs = get_langs(['fields' => ['id', 'code']]);

        if (isset($data['cat_ids'])) {
            $item->cats()->attach($data['cat_ids']);
            $item->cats()->increment('count');
        }

        if (isset($data['new_tags'])) {
            foreach ($data['new_tags'] as $tag) {
                $newtag = $this->tag->create(['type' => 'tag', 'count' => 1]);
                foreach ($langs as $lang) {
                    $tag_desc = [
                        'name' => $tag,
                        'slug' => str_slug($tag)
                    ];
                    $newtag->langs()->attach($lang->id, $tag_desc);
                }
                $item->tags()->attach($newtag->id);
            }
        }

        if (isset($data['tag_ids'])) {
            $item->tags()->attach($data['tag_ids']);
        }

        foreach ($langs as $lang) {
            $lang_data = $data[$lang->code];
            $title = $lang_data['title'];
            $slug = $lang_data['slug'];

            $lang_data['slug'] = ($slug) ? str_slug($slug) : str_slug($title);

            $item->langs()->attach($lang->id, $lang_data);
        }

        return $item;
    }

    public function findByLang($id, $fields = ['posts.*', 'pd.*'], $lang = null) {
        $item = $this->model->joinLang($lang)
                ->find($id, $fields);
        if ($item) {
            return $item;
        }
        $item = $this->model->find($id);
        return $item;
    }

    public function update($id, $data) {
        $this->validator($data, $this->rules(true));

        if ($data['thumb_id']) {
            $data['thumb_id'] = cutImgPath($data['thumb_id']);
        }
        $fillable = $this->model->getFillable();
        $fill_data = array_only($data, $fillable);
        $item = $this->model->find($id);
        $item->update($fill_data);

        $old_tags = $item->tags()->lists('id')->toArray();
        $old_cats = $item->cats()->lists('id')->toArray();

        $item->cats()->detach();

        if (isset($data['tag_ids'])) {
            $item->tags()->decrement('count');
            $item->tags()->attach($data['tag_ids']);
            $item->tags()->increment('count');
        } else {
            $item->tags()->attach($old_tags);
        }

        if (isset($data['cat_ids'])) {
            $item->cats()->decrement('count');
            $item->cats()->attach($data['cat_ids']);
            $item->cats()->increment('count');
        } else {
            $item->cats()->attach($old_cats);
        }

        $langs = get_langs(['fields' => ['id', 'code']]);
        if (isset($data['new_tags'])) {
            foreach ($data['new_tags'] as $tag) {
                $newtag = $this->tag->create(['type' => 'tag', 'count' => 1]);
                foreach ($langs as $lang) {
                    $tag_desc = [
                        'name' => $tag,
                        'slug' => str_slug($tag)
                    ];
                    $newtag->langs()->attach($lang->id, $tag_desc);
                }
                $item->tags()->attach($newtag->id);
            }
        }

        $lang_id = get_lang_id($data['lang']);

        $lang_data = $data['locale'];
        $name = $lang_data['title'];
        $slug = $lang_data['slug'];
        $lang_data['slug'] = (trim($slug) == '') ? str_slug($name) : str_slug($slug);

        $item->langs()->sync([$lang_id => $lang_data], false);
    }

    public function destroy($ids) {
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        if ($ids) {
            foreach ($ids as $id) {
                $item = $this->model->find($id);
                if ($item) {
                    $item->tags()->decrement('count')->detach();
                    $item->cats()->decrement('count')->detach();
                    $item->langs()->detach();
                    $item->delete();
                }
            }
            return true;
        }
        return false;
    }

}
