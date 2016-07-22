<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Eloquents\FileEloquent;

class FileController extends Controller
{
    protected $file;
    
    public function __construct(FileEloquent $file) {
        
        $this->file = $file;
    }
    
    public function index(Request $request){
        $files = $this->file->all($request->all());
        return view('manage.file.index', ['items' => $files]);
    }
    
    public function create(){
        return view('manage.file.create');
    }
    
    public function store(Request $request){
        try{
            $this->file->insert($request->all());
            return redirect()->back()->with('succ_mess', trans('manage.store_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }
    
    public function edit($id){
        $item = $this->file->find($id);
        return view('manage.file.edit', ['item' => $item]);
    }
    
    public function update($id, Request $request){
        try{
            $this->file->update($id, $request->all());
            return redirect()->back()->with('succ_mess', trans('manage.update_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }
    
    public function destroy($id){
        if(!$this->file->destroy($id)){
            return redirect()->back()->with('error_mess', trans('manage.no_item'));
        }
        return redirect()->back()->with('succ_mess', trans('manage.destroy_success'));
    }
    
    public function multiAction(Request $request){
        return $result = $this->file->actions($request);
    }
}
