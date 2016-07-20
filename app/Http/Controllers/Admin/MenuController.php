<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Eloquents\MenuEloquent;
use App\Eloquents\MenuCatEloquent;

class MenuController extends Controller
{
    protected $menu;
    protected $menucat;

    public function __construct(MenuEloquent $menu, MenuCatEloquent $menucat) {
        canAccess('manage_menus');

        $this->menu = $menu;
        $this->menucat = $menucat;
    }

    public function index(Request $request) {
        $data = $request->all();
        $menus = $this->menu->all($data);
        return view('manage.menu.index', ['items' => $menus]);
    }

    public function create() {
        $parents = $this->menu->all(['orderby' => 'pivot_title']);
        $groups = $this->menucat->all(['orderby' => 'pivot_name', 'fields' => 'id']);
        return view('manage.menu.create', ['parents' => $parents, 'groups' => $groups]);
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
