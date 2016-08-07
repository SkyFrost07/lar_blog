<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Eloquents\PostEloquent;

class PostController extends Controller
{
    protected $post;
    
    public function __construct(PostEloquent $post) {
        $this->post = $post;
    }
    
    public function lists(Request $request){
        $posts = $this->post->all($request->all());
        return view('front.post_lists', compact('posts'));
    }
    
    public function view($id, $slug=null){
        $post = $this->post->findByLang($id, ['posts.*', 'pd.*']);
        return view('front.post_detail', compact('post'));
    }
}
