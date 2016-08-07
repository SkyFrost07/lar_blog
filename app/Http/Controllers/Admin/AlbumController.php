<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Eloquents\AlbumEloquent;

class AlbumController extends Controller
{
    protected $album;

    public function __construct(AlbumEloquent $album) {
        canAccess('manage_cats');

        $this->album = $album;
    }

    public function index(Request $request) {
        $data = $request->all();
        $albums = $this->album->all($data);
        return view('manage.album.index', ['items' => $albums]);
    }

    public function create() {
        return view('manage.album.create');
    }

    public function store(Request $request) {
        try {
            $this->album->insert($request->all());
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
        $item = $this->album->findByLang($id, ['taxs.*', 'td.*'], $lang);
        return view('manage.album.edit', compact('item', 'lang'));
    }

    public function update($id, Request $request) {
        try {
            $this->album->update($id, $request->all());
            return redirect()->back()->with('succ_mess', trans('manage.update_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }

    public function destroy($id) {
        if (!$this->album->destroy($id)) {
            return redirect()->back()->with('error_mess', trans('manage.no_item'));
        }
        return redirect()->back()->with('succ_mess', trans('manage.destroy_success'));
    }

    public function multiAction(Request $request) {
        return response()->json($this->album->actions($request));
    }
}
