<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Eloquents\CatEloquent;
use App\Eloquents\PostEloquent;

class CatController extends Controller
{
    protected $cat;
    protected $post;
    
    public function __construct(CatEloquent $cat, PostEloquent $post) {
        $this->cat = $cat;
        $this->post = $post;
    }
    
    public function view($id, $slug=null){
        $cat = $this->cat->findByLang($id, ['td.name', 'td.slug', 'taxs.id']);
        $posts = $this->post->all([
            'field' => ['posts.*', 'pd.*'],
            'orderby' => 'created_at',
            'order' => 'desc',
            'cats' => [$id]
        ]);
        return view('front.category', compact('cat', 'posts'));
    }
}
