<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Eloquents\PostEloquent;
use App\Eloquents\CatEloquent;
use App\Eloquents\TagEloquent;
use App\Eloquents\UserEloquent;
use App\Exceptions\DbException;
use Illuminate\Validation\ValidationException;

class PostController extends Controller {

    protected $post;
    protected $cat;
    protected $tag;
    protected $user;

    public function __construct(PostEloquent $post, CatEloquent $cat, TagEloquent $tag, UserEloquent $user) {
        $this->post = $post;
        $this->cat = $cat;
        $this->tag = $tag;
        $this->user = $user;
    }

    public function index(Request $request) {
        $items = $this->post->all($request->all());
        return view('manage.post.index', ['items' => $items]);
    }

    public function create() {
        canAccess('publish_posts');

        $cats = $this->cat->all(['orderby' => 'name', 'order' => 'asc', 'per_page' => -1, 'fields' => ['id', 'parent_id']]);
        $tags = $this->tag->all(['orderby' => 'name', 'order' => 'asc', 'per_page' => -1, 'fields' => ['id']]);
        $users = null;
        if (cando('manage_posts')) {
            $users = $this->user->all(['orderby' => 'name', 'order' => 'asc', 'pre_page' => -1, 'fields' => ['id', 'name']]);
        }
        return view('manage.post.create', ['cats' => $cats, 'tags' => $tags, 'users' => $users]);
    }

    public function store(Request $request) {
        canAccess('publish_posts');

        try {
            $this->post->insert($request->all());
            return redirect()->back()->with('succ_mess', trans('manage.store_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        } catch (DbException $ex) {
            return redirect()->back()->withInput()->with('error_mess', $ex->getError());
        }
    }

    public function edit($id) {
        canAccess('edit_my_post', $this->post->get_author_id($id));

        $cats = $this->cat->all(['orderby' => 'name', 'order' => 'asc', 'per_page' => -1, 'fields' => ['id', 'parent_id']]);
        $tags = $this->tag->all(['orderby' => 'name', 'order' => 'asc', 'per_page' => -1, 'fields' => ['id']]);
        $users = null;
        if (cando('manage_posts')) {
            $users = $this->user->all(['orderby' => 'name', 'order' => 'asc', 'per_page' => 20, 'fields' => ['name', 'id']]);
        }
        $item = $this->post->find($id);
        $curr_cats = $item->cats->lists('id')->toArray();
        $curr_tags = $item->tags->lists('id')->toArray();
        return view('manage.post.edit', [
            'item' => $item, 
            'cats' => $cats, 
            'tags' => $tags, 
            'users' => $users,
            'curr_cats' => $curr_cats,
            'curr_tags' => $curr_tags
        ]);
    }

    public function update($id, Request $request) {
        try {
            $this->post->update($id, $request->all());
            return redirect()->back()->with('succ_mess', trans('manage.update_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }

    public function destroy($id) {
        if (!$this->post->changeStatus($id, 0)) {
            return redirect()->back()->with('error_mess', trans('manage.no_item'));
        }
        return redirect()->back()->with('succ_mess', trans('manage.destroy_success'));
    }

    public function multiAction(Request $request) {
        return $result = $this->post->actions($request);
    }

}
