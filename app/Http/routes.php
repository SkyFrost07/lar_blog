<?php

//Frontend

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get('/category/{id}/{slug?}', ['as' => 'cat.view', 'uses' => 'CatController@view']);
Route::get('/posts', ['as' => 'post.lists', 'uses' => 'PostController@lists']);
Route::get('/post/{id}/{slug?}', ['as' => 'post.view', 'uses' => 'PostController@view']);
Route::get('/pages', ['as' => 'page.lists', 'uses' => 'PageController@lists']);
Route::get('/page/{id}/{slug?}', ['as' => 'page.view', 'uses' => 'PageController@view']);
Route::get('/tag/{id}/{slug?}', ['as' => 'tag.view', 'uses' => 'TagController@view']);
Route::post('/contact/send', ['as' => 'contact.send', 'uses' => 'HomeController@sendContact']);

include 'ExtRoutes/test.php';
$manage = config('app.manage_prefix', 'manage');

Route::group(['namespace' => 'Auth'], function() use($manage){
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
    
    Route::group(['middleware' => 'auth', 'prefix' => $manage. '/account'], function(){
        //    Account
        Route::get('/profile', ['as' => 'mn.profile', 'uses' => 'AuthController@getProfile']);
        Route::post('/update-profile', ['as' => 'mn.update_profile', 'uses' => 'AuthController@updateProfile']);
        Route::get('/change-password', ['as' => 'mn.change_pass', 'uses' => 'AuthController@getChangePass']);
        Route::post('/update-password', ['as' => 'mn.update_pass', 'uses' => 'AuthController@updatePassword']);
    });
    
    //    Logout
    Route::get('/logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
});

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
//    Albums
    Route::resource('albums', 'AlbumController', rsNames('album'));
    Route::post('/albums/multi-actions', ['as' => 'album.m_action', 'uses' => 'AlbumController@multiAction']);
//    Menu cats
    Route::get('/menu-groups/to-nested', ['as' => 'menucat.to_nested', 'uses' => 'MenuCatController@getNestedMenus']);
    Route::post('/menu-groups/store-items', ['as' => 'menucat.store_items', 'uses' => 'MenuCatController@storeItems']);
    Route::post('/menu-groups/update-order-items', ['as' => 'menucat.update_order_items', 'uses' => 'MenuCatController@updateOrderItems']);
    Route::resource('menu-groups', 'MenuCatController', rsNames('menucat'));
    Route::post('/menu-groups/multi-actions', ['as' => 'menucat.m_action', 'uses' => 'MenuCatController@multiAction']);
//    Menu
    Route::delete('/menus/asyn-destroy', ['as' => 'menu.asyn_destroy', 'uses' => 'MenuController@asynDestroy']);
    Route::get('/menus/get-menu-type', ['as' => 'menu.get_type', 'uses' => 'MenuController@getType']);
    Route::resource('menus', 'MenuController', rsNames('menu'));
    Route::post('/menus/multi-actions', ['as' => 'menu.m_action', 'uses' => 'MenuController@multiAction']);
//    Post
    Route::resource('posts', 'PostController', rsNames('post'));
    Route::post('/posts/multi-actions', ['as' => 'post.m_action', 'uses' => 'PostController@multiAction']);
//    Page
    Route::resource('pages', 'PageController', rsNames('page'));
    Route::post('/pages/multi-actions', ['as' => 'page.m_action', 'uses' => 'PageController@multiAction']);
//    Files
    Route::get('/files/manage', ['as' => 'file.manage', 'uses' => 'FileController@manage']);
    Route::get('/files/dialog', ['as' => 'file.dialog', 'uses' => 'FileController@dialog']);
    Route::resource('files', 'FileController', rsNames('file'));
    Route::post('/files/multi-actions', ['as' => 'file.m_action', 'uses' => 'FileController@multiAction']);
//    Medias
    Route::resource('medias', 'MediaController', rsNames('media'));
    Route::post('/medias/multi-actions', ['as' => 'media.m_action', 'uses' => 'MediaController@multiAction']);
//    Options
    Route::get('/options/{key}/delete', ['as' => 'option.delete', 'uses' => 'OptionController@destroy']);
    Route::post('/options/update-all', ['as' => 'option.update_all', 'uses' => 'OptionController@updateAll']);
    Route::resource('/options', 'OptionController', rsNames('option'));
    Route::post('/options/multi-actions', ['as' => 'option.m_action', 'uses' => 'OptionController@multiAction']);
//    API
    Route::controller('/api', 'Api\ApiController');
});



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

include 'ExtRoutes/api.php';
