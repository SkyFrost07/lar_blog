<?php

Route::group(['prefix' => 'test'], function(){
    Route::get('/editor', ['uses' => 'TestController@editor']);
    Route::get('/get-content', ['uses' => 'TestController@getContent']);
    Route::get('/files', function(){
       return json_encode([
           ['title' => 'File 1', 'url' => 'url 1'],
           ['title' => 'File 2', 'url' => 'url 2'],
           ['title' => 'File 3', 'url' => 'url 3'],
           ['title' => 'File 4', 'url' => 'url 4'],
       ]); 
    });
});

