<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Eloquents\PageEloquent;
use Illuminate\Validation\ValidationException;
use App\Exceptions\DbException;

class PageController extends Controller
{
    protected $page;

    public function __construct(PageEloquent $page) {
        $this->page = $page;
    }

    public function index(Request $request) {
        $items = $this->page->all($request->all());
        return view('manage.page.index', ['items' => $items]);
    }

    public function create() {
        canAccess('publish_posts');

        return view('manage.page.create');
    }

    public function store(Request $request) {
        canAccess('publish_posts');

        try {
            $this->page->insert($request->all());
            return redirect()->back()->with('succ_mess', trans('manage.store_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        } catch (DbException $ex) {
            return redirect()->back()->withInput()->with('error_mess', $ex->getError());
        }
    }

    public function edit($id) {
        canAccess('edit_my_post', $this->page->get_author_id($id));

        $item = $this->page->findByLang($id);
        return view('manage.page.edit', compact('item'));
    }

    public function update($id, Request $request) {
        try {
            $this->page->update($id, $request->all());
            return redirect()->back()->with('succ_mess', trans('manage.update_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }

    public function destroy($id) {
        if (!$this->page->changeStatus($id, 0)) {
            return redirect()->back()->with('error_mess', trans('manage.no_item'));
        }
        return redirect()->back()->with('succ_mess', trans('manage.destroy_success'));
    }

    public function multiAction(Request $request) {
        return $result = $this->page->actions($request);
    }
}
