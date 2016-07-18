<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HomeController extends Controller
{   
    public function index(){
        return view('front.index');
    }
    
    public function switchLang($code, Request $request){
        $current_url = $request->get('current_url');
        if(hasLang($code)){
            app()->setLocale($code);
        }
        $segments = $request->segments();
        $segments[0] = $code;
        return redirect()->to($current_url);
    }
}
