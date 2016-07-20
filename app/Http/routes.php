<?php

include 'ExtRoutes/test.php';

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
    Route::post('/roles/multi-actions', ['as' => 'role.m_action', 'uses' => 'RoleController@multiAction']);
    Route::resource('roles', 'RoleController', rsNames('role'));
//    Caps
    Route::post('/capabilities/multi-actions', ['as' => 'cap.m_action', 'uses' => 'CapController@multiAction']);
    Route::resource('capabilities', 'CapController', rsNames('cap'));
//    Users
    Route::post('/users/multi-actions', ['as' => 'user.m_action', 'uses' => 'UserController@multiAction']);
    Route::resource('users', 'UserController', rsNames('user'));
//    Languages
    Route::resource('languages', 'LangController', rsNames('lang'));
    Route::post('/languages/multi-actions', ['as' => 'lang.m_action', 'uses' => 'LangController@multiAction']);
//    Categories
    Route::resource('categories', 'CatController', rsNames('cat'));
    Route::post('/categories/multi-actions', ['as' => 'cat.m_action', 'uses' => 'CatController@multiAction']);
//    Tags
    Route::resource('tags', 'TagController', rsNames('tag'));
    Route::post('/tags/multi-actions', ['as' => 'tag.m_action', 'uses' => 'TagController@multiAction']);
//    Menu cats
    Route::resource('menu-groups', 'MenuCatController', rsNames('menucat'));
    Route::post('/menu-groups/multi-actions', ['as' => 'menucat.m_action', 'uses' => 'MenuCatController@multiAction']);
//    Menu
    Route::resource('menus', 'MenuController', rsNames('menu'));
    Route::post('/menus/multi-actions', ['as' => 'menu.m_action', 'uses' => 'MenuController@multiAction']);
//    Post
    Route::resource('posts', 'PostController', rsNames('post'));
    Route::post('/posts/multi-actions', ['as' => 'post.m_action', 'uses' => 'PostController@multiAction']);
//    Page
    Route::resource('pages', 'PageController', rsNames('page'));
    Route::post('/pages/multi-actions', ['as' => 'page.m_action', 'uses' => 'PageController@multiAction']);
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
