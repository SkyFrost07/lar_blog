<?php

Route::get('switch-languages/{code}', ['as' => 'switch_lang', 'uses' => 'HomeController@switchLang']);

Route::group(['namespace' => 'Auth'], function() {
    Route::group(['middleware' => 'throw'], function() {
//    Register
        Route::get('/register', ['as' => 'get_register', 'uses' => 'AuthController@getRegister']);
        Route::post('/register', ['as' => 'post_register', 'uses' => 'AuthController@postRegister']);
//    Login
        Route::get('/login', ['as' => 'get_login', 'uses' => 'AuthController@getLogin']);
        Route::post('/login', ['as' => 'post_login', 'uses' => 'AuthController@postLogin']);
//    Forget password
        Route::get('/forget_password', ['as' => 'get_forget_pass', 'uses' => 'AuthController@getForgetPass']);
        Route::post('/forget_password', ['as' => 'post_forget_pass', 'uses' => 'AuthController@postForgetPass']);
        Route::get('/reset_password', ['as' => 'get_reset_pass', 'uses' => 'AuthController@getResetPass']);
        Route::post('/reset_password', ['as' => 'post_reset_pass', 'uses' => 'AuthController@postResetPass']);
    });
    //    Logout
    Route::get('/logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
});

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

$manage = config('app.manage_prefix', 'manage');
//
Route::group(['prefix' => $manage, 'middleware' => 'auth', 'namespace' => 'Admin'], function() {
    Route::get('/', ['as' => 'dashboard', 'uses' => 'AdminController@index']);
//    Roles
    Route::post('/role/multi-actions', ['as' => 'role.m_action', 'uses' => 'RoleController@multiAction']);
    Route::resource('role', 'RoleController', rsNames('role'));
//    Caps
    Route::post('/cap/multi-actions', ['as' => 'cap.m_action', 'uses' => 'CapController@multiAction']);
    Route::resource('cap', 'CapController', rsNames('cap'));
//    Users
    Route::post('/user/multi-actions', ['as' => 'user.m_action', 'uses' => 'UserController@multiAction']);
    Route::resource('user', 'UserController', rsNames('user'));
//    Languages
    Route::resource('lang', 'LangController', rsNames('lang'));
    Route::post('/lang/multi-actions', ['as' => 'lang.m_action', 'uses' => 'LangController@multiAction']);
//    Categories
    Route::resource('cat', 'CatController', rsNames('cat'));
    Route::post('/cat/multi-actions', ['as' => 'cat.m_action', 'uses' => 'CatController@multiAction']);
//    Tags
    Route::resource('tag', 'TagController', rsNames('tag'));
    Route::post('/tag/multi-actions', ['as' => 'tag.m_action', 'uses' => 'TagController@multiAction']);
});

//});

function rsNames($name) {
    return [
        'names' => [
            'index' => $name . ".index",
            'create' => $name . ".create",
            'store' => $name . ".store",
            'show' => $name . ".show",
            'edit' => $name . ".edit",
            'update' => $name . ".update",
            'destroy' => $name . ".destroy"
        ]
    ];
}
