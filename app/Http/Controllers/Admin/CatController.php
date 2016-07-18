<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Eloquents\CatEloquent;
use Illuminate\Validation\ValidationException;
use App\Exceptions\DbException;

class CatController extends Controller {

    protected $cat;

    public function __construct(CatEloquent $cat) {
        canAccess('manage_cats');

        $this->cat = $cat;
    }

    public function index(Request $request) {
        $data = $request->all();
        $cats = $this->cat->all($data);
        $tableCats = $this->cat->tableCats($cats, 0);
        return view('manage.cat.index', ['items' => $cats, 'tableCats' => $tableCats]);
    }

    public function create() {
        $parents = $this->cat->all([
            'fields' => ['id', 'parent_id'],
            'per_page' => -1,
            'orderby' => 'pivot_name'
        ]);
        return view('manage.cat.create', ['parents' => $parents]);
    }

    public function store(Request $request) {
        try {
            $this->cat->insert($request->all());
            return redirect()->back()->with('succ_mess', trans('manage.store_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        } catch (DbException $ex) {
            return redirect()->back()->withInput()->with('error_mess', $ex->getMess());
        }
    }

    public function edit($id) {
        $item = $this->cat->find($id);
        $parents = $this->cat->all([
            'fields' => ['id', 'parent_id'],
            'exclude' => [$id],
            'per_page' => -1,
            'orderby' => 'pivot_name'
        ]);
        return view('manage.cat.edit', ['item' => $item, 'parents' => $parents]);
    }

    public function update($id, Request $request) {
        try {
            $this->cat->update($id, $request->all());
            return redirect()->back()->with('succ_mess', trans('manage.update_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }

    public function destroy($id) {
        if (!$this->cat->destroy($id)) {
            return redirect()->back()->with('error_mess', trans('manage.no_item'));
        }
        return redirect()->back()->with('succ_mess', trans('manage.destroy_success'));
    }

    public function multiAction(Request $request) {
        return response()->json($result = $this->cat->actions($request));
    }

}
