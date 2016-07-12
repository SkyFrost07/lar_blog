<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Eloquents\UserEloquent;
use App\Eloquents\RoleEloquent;

use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected $user;
    protected $role;

    public function __construct(UserEloquent $user, RoleEloquent $role) {
        $this->user = $user;
        $this->role = $role;
    }
    
    public function index(Request $request){
        $users = $this->user->all($request->all());
        return view('manage.user.index', ['items' => $users]);
    }
    
    public function create(){
        canAccess('publish_users');
        
        $roles = $this->role->all(['orderby' => 'id', 'order' => 'asc'])->lists('label', 'id'); 
        $roles->prepend(trans('manage.selection'), 0);
        return view('manage.user.create', ['roles' => $roles]);
    }
    
    public function store(Request $request){
        canAccess('publish_users');
        
        try{
            $this->user->insert($request->all());
            return redirect()->back()->with('succ_mess', trans('manage.store_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }
    
    public function edit($id){
        canAccess('edit_my_user', $id);
        
        $item = $this->user->find($id);
        $roles = $this->role->all(['orderby' => 'id', 'order' => 'asc'])->lists('label', 'id');
        $roles->prepend(trans('manage.selection'), 0);
        return view('manage.user.edit', ['item' => $item, 'roles' => $roles]);
    }
    
    public function update($id, Request $request){
        try{
            $this->user->update($id, $request->all());
            return redirect()->back()->with('succ_mess', trans('manage.update_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withInput()->withErrors($ex->validator);
        }
    }
    
    public function destroy($id){
        if(!$this->user->destroy($id)){
            return redirect()->back()->with('error_mess', trans('manage.no_item'));
        }
        return redirect()->back()->with('succ_mess', trans('manage.destroy_success'));
    }
    
    public function multiAction(Request $request){
        return $result = $this->user->actions($request);
    }
}
