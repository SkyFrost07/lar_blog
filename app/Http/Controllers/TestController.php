<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TestController extends Controller
{
    public function editor(){
        return view('test.editor');
    }
    
    public function getContent(){
        $data_content = file_get_contents('https://dev-s-api.slorn.jp/v1.0.0/getVisitedCustomerByShopId?shop_id=6');
        $data = json_decode($data_content)->data; 
        foreach ($data as $item){
            echo $item->name.'<br />';
        }
//        return view('test.get_content');
    }
}
