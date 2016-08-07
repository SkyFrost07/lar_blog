<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Eloquents\TagEloquent;
use App\Eloquents\PostEloquent;

class TagController extends Controller
{
    protected $tag;
    protected $post;

    public function __construct(TagEloquent $tag, PostEloquent $post) {
        $this->tag = $tag;
        $this->post = $post;
    }
    
    public function view($id, $slug=null){
        $tag = $this->tag->findByLang($id);
        $posts = $this->post->all([
            'field' => ['posts.*', 'pd.*'],
            'tags' => [$id]
        ]);
        return view('front.tag', compact('tag', 'posts'));
    }
}
