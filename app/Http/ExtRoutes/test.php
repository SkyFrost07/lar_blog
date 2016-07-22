<?php

Route::get('/files/dialog', function() {
    return view('files.dialog');
});

use Illuminate\Http\Request;
use App\Eloquents\FileEloquent;
use Illuminate\Validation\ValidationException;
use Illuminate\Session\TokenMismatchException;
use App\Models\File;

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
});
