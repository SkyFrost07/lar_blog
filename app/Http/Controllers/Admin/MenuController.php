<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Eloquents\MenuEloquent;
use App\Eloquents\MenuCatEloquent;
use App\Eloquents\CatEloquent;
use App\Eloquents\TagEloquent;
use App\Eloquents\PostEloquent;
use App\Eloquents\PageEloquent;

class MenuController extends Controller {

    protected $menu;
    protected $menucat;
    protected $cat;
    protected $tag;
    protected $post;
    protected $page;

    public function __construct(MenuEloquent $menu, MenuCatEloquent $menucat, CatEloquent $cat, TagEloquent $tag, PostEloquent $post, PageEloquent $page) {
        canAccess('manage_menus');

        $this->menu = $menu;
        $this->menucat = $menucat;

        $this->cat = $cat;
        $this->tag = $tag;
        $this->post = $post;
        $this->page = $page;
    }

    public function index(Request $request) {
        $data = $request->all();
        $menus = $this->menu->all($data);
        return view('manage.menu.index', ['items' => $menus]);
    }

    public function create() {
        $parents = $this->menu->all(['orderby' => 'pivot_title']);
        $groups = $this->menucat->all(['orderby' => 'pivot_name', 'fields' => ['id']]);

        $cats = $this->cat->all(['orderby' => 'pivot_name', 'fields' => ['id']]);
        $tags = $this->tag->all(['orderby' => 'pivot_name', 'fields' => ['id']]);
        $posts = $this->post->all(['orderby' => 'pivot_title', 'fields' => ['id']]);
        $pages = $this->page->all(['orderby' => 'pivot_title', 'fields' => ['id']]);
        return view('manage.menu.create', [
            'parents' => $parents, 
            'groups' => $groups,
            'cats' => $cats,
            'tags' => $tags,
            'posts' => $posts,
            'pages' => $pages
        ]);
    }

    public function store(Request $request) {
        try {
            $this->menu->insert($request->all());
            return redirect()->back()->with('succ_mess', trans('manage.store_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        } catch (DbException $ex) {
            return redirect()->back()->withInput()->with('error_mess', $ex->getMess());
        }
    }

    public function edit($id) {
        $item = $this->menu->find($id);
        return view('manage.menu.edit', ['item' => $item]);
    }

    public function update($id, Request $request) {
        try {
            $this->menu->update($id, $request->all());
            return redirect()->back()->with('succ_mess', trans('manage.update_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }

    public function destroy($id) {
        if (!$this->menu->destroy($id)) {
            return redirect()->back()->with('error_mess', trans('manage.no_item'));
        }
        return redirect()->back()->with('succ_mess', trans('manage.destroy_success'));
    }

    public function multiAction(Request $request) {
        return response()->json($result = $this->menu->actions($request));
    }

}
