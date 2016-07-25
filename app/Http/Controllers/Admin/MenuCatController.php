<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquents\MenuCatEloquent;
use Illuminate\Validation\ValidationException;

class MenuCatController extends Controller {

    protected $menucat;

    public function __construct(MenuCatEloquent $menucat) {
        canAccess('manage_menus');

        $this->menucat = $menucat;
    }

    public function index(Request $request) {
        $data = $request->all();
        $menucats = $this->menucat->all($data);
        return view('manage.menucat.index', ['items' => $menucats]);
    }

    public function create() {
        return view('manage.menucat.create');
    }

    public function store(Request $request) {
        try {
            $this->menucat->insert($request->all());
            return redirect()->back()->with('succ_mess', trans('manage.store_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        } catch (DbException $ex) {
            return redirect()->back()->withInput()->with('error_mess', $ex->getMess());
        }
    }

    public function edit($id, Request $request) {
         $lang = current_locale();
        if($request->has('lang')){
            $lang = $request->get('lang');
        }
        $item = $this->menucat->findByLang($id, ['taxs.id', 'td.slug', 'td.name'], $lang);
        return view('manage.menucat.edit', compact('item', 'lang'));
    }

    public function update($id, Request $request) {
        try {
            $this->menucat->update($id, $request->all());
            return redirect()->back()->with('succ_mess', trans('manage.update_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }

    public function destroy($id) {
        if (!$this->menucat->destroy($id)) {
            return redirect()->back()->with('error_mess', trans('manage.no_item'));
        }
        return redirect()->back()->with('succ_mess', trans('manage.destroy_success'));
    }

    public function multiAction(Request $request) {
        return response()->json($result = $this->menucat->actions($request));
    }

}
