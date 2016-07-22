<?php

Route::get('/files/dialog', function(){
   return view('files.dialog'); 
});

use Illuminate\Http\Request;
use App\Eloquents\FileEloquent;
use Illuminate\Validation\ValidationException;
use DB;

Route::group(['prefix' => 'test'], function(){
    Route::get('/editor', function(){
       return view('test.editor'); 
    });
    Route::get('/upload', function(){
        return view('test.upload');
    });
    Route::post('/upload', function(Request $request, FileEloquent $elFile){
        if($request->hasFile('files')){
            $files = $request->file('files');
            DB::beginTransaction();
            foreach ($files as $file){
                try{
                    $elFile->insert($file);
                    DB::commit();
                    return 'uploaded';
                }catch(ValidationException $ex){
                    DB::rollBack();
                    return redirect()->back()->withInput()->withErrors($ex->validator);
                }
            }
        }else{
            return redirect()->back();
            
        }
    });
});
