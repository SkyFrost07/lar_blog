<?php

Route::get('/files/dialog', function() {
    return view('files.dialog');
});

use Illuminate\Http\Request;
use App\Eloquents\FileEloquent;
use Illuminate\Validation\ValidationException;
use Illuminate\Session\TokenMismatchException;
use App\Models\File;
use App\Models\Cat;
use App\Models\Lang;
use App\Eloquents\LangEloquent;

Route::group(['prefix' => 'test'], function() {
    Route::get('/editor', function() {
        return view('test.editor');
    });
    Route::get('/upload', function() {
        return view('test.upload');
    });
    Route::post('/upload', function(Request $request, FileEloquent $elFile) {
        if ($request->hasFile('files')) {
            $files = $request->file('files');

            DB::beginTransaction();
            try {
                foreach ($files as $file) {
                    $elFile->insert($file);
                }
                DB::commit();
                return 'uploaded';
            } catch (ValidationException $ex) {
                DB::rollBack();
                return redirect()->back()->withErrors($ex->validator);
            }
        } else {
            return redirect()->back();
        }
    });
    Route::get('/files', function() {
        $files = File::all();
        foreach ($files as $file) {
            echo '<p>' . $file->getImage('thumbnail') . ' <a href="' . url('vi/test/files/delete/' . $file->id) . '">Del</a></p>';
        }
    });

    Route::get('/files/delete/{id}', function($id, FileEloquent $elFile) {
        $elFile->destroy($id);
        return 'ok';
    });

    Route::get('/perform', function(LangEloquent $lang) {
        $start = microtime(true);
        for($i=0; $i<500; $i++){
//            $result = Lang::where('code', 'vi')->first(['id'])->id;
//        $result = DB::table('tax_desc as td')
//                        ->select(['td.name', 'td.slug', 'td.description', 'td.meta_keyword', 'td.meta_desc', 't.*'])
//                        ->join('taxs as t', function($join){
//                            $join->on('td.tax_id', '=', 't.id')
//                                    ->where('t.type', '=', 'cat');
//                        })
//                        ->join('langs as l', function($join) {
//                            $join->on('td.lang_id', '=', 'l.id')
//                            ->where('l.code', '=', 'vi');
//                        })->paginate(10);
//        $result = Cat::where('type', 'cat')
//                ->select(['td.name', 'td.slug', 'td.description', 'td.meta_keyword', 'td.meta_desc', 'taxs.*'])
//                ->join('tax_desc as td', function($join) {
//                    $join->on('td.tax_id', '=', 'taxs.id');
//                })->join('langs as l', function($join) {
//                    $join->on('td.lang_id', '=', 'l.id')
//                            ->where('l.code', '=', 'vi');
//                })->get();
//            $result = Lang::where('code', 'vi')->first()->cats->count();
//        foreach ($result as $item){
//            echo $item->status().'<br />';
//        }
//            $result = get_langs(['fields' => ['id', 'name', 'code', 'icon']]);
//            $result = $lang->all(['fields' => ['id', 'name', 'code', 'icon']]);
        }
        $finish = microtime(true);
        echo $finish - $start;
        dd($result);
    });
});
