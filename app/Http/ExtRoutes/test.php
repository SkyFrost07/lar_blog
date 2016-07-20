<?php

Route::group(['prefix' => 'test'], function(){
    Route::get('/editor', ['uses' => 'TestController@editor']);
});

