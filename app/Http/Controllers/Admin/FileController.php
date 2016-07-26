<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquents\FileEloquent;
use Illuminate\Validation\ValidationException;
use DB;
use App\Eloquents\UserEloquent;

class FileController extends Controller {

    protected $file;
    protected $user;

    public function __construct(FileEloquent $file, UserEloquent $user) {

        $this->file = $file;
        $this->user = $user;
    }

    public function index(Request $request) {
        $files = $this->file->all($request->all());
        return view('manage.file.index', ['items' => $files]);
    }

    public function create() {
        return view('manage.file.create');
    }

    public function store(Request $request) {
        if (!$request->hasFile('files')) {
            return redirect()->back()->withInput()->withErrors(['file' => trans('validation.required', ['attribute' => 'file'])]);
        }

        $files = $request->file('files');

        foreach ($files as $file) {
            try {
                $this->file->insert($file);
            } catch (ValidationException $ex) {
                return redirect()->back()->withInput()->withErrors($ex->validator);
            }
        }
        return redirect()->back()->with('succ_mess', trans('manage.store_success'));
    }

    public function edit($id) {
        $item = $this->file->find($id);
        $users = null;
        if(cando('manage_files')){
            $users = $this->user->all()->lists('name', 'id')->toArray();
        }
        return view('manage.file.edit', compact('item', 'users'));
    }

    public function update($id, Request $request) {
        try {
            $this->file->update($id, $request->all());
            return redirect()->back()->with('succ_mess', trans('manage.update_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }

    public function destroy($id) {
        if (!$this->file->destroy($id)) {
            return redirect()->back()->with('error_mess', trans('manage.no_item'));
        }
        return redirect()->back()->with('succ_mess', trans('manage.destroy_success'));
    }

    public function multiAction(Request $request) {
        return $result = $this->file->actions($request);
    }

}
