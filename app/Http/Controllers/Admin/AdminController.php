<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct() {
        canAccess('accept_manage');
    }
    public function index(){
        return view('manage.dashboard');
    }
}
