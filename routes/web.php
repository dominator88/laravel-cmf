<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('', function () {
    return 'Hello word!';
});
/*Route::group( ['prefix'=>'auth','namespace'=>'Auth'] , function() {
    Route::get('signin', 'LoginController@index');
    Route::get('signup', 'index/auth/signup');
    Route::get('signout', 'index/auth/signout');
    Route::get('sendcaptcha', 'index/auth/sendCaptcha');
});*/

Route::get('backend/index/index' ,  'Backend\Index@index');



//系统功能
Route::group(['prefix'=>'backend/sysfunc','namespace'=>'Backend'],function(){

    Route::get('index' , 'SysFunc@index');

    Route::get('read' ,   'SysFunc@read');

    Route::post('update_privilege/{funcId}' ,   'SysFunc@update_privilege');

    Route::post('update/{id}' ,   'SysFunc@update');

    Route::post('insert' ,   'SysFunc@insert');

    Route::post('destroy' ,   'SysFunc@destroy');

});

//系统角色
Route::group(['prefix'=>'backend/sysrole','namespace'=>'Backend'],function(){

    Route::get('index' , 'SysRole@index');

    Route::get('read' , 'SysRole@read');

    Route::post('get_permission' , 'SysRole@get_permission');

    Route::post('get_privilegedata' , 'SysRole@get_privilegeData');

    Route::post('update_permission' , 'SysRole@update_permission');

    Route::post('update/{id}' ,   'SysRole@update');

    Route::post('insert' ,   'SysRole@insert');

    Route::post('destroy' ,   'SysRole@destroy');

});

//系统用户
Route::group(['prefix'=>'backend/sysuser','namespace'=>'Backend'],function(){

    Route::get('index' , 'SysUser@index');

    Route::get('read' , 'SysUser@read');

    Route::post('get_permission' , 'SysUser@get_permission');

    Route::post('get_privilegedata' , 'SysUser@get_privilegeData');

    Route::post('update_permission' , 'SysUser@update_permission');

    Route::post('update/{id}' ,   'SysUser@update');

    Route::post('insert' ,   'SysUser@insert');

    Route::post('destroy' ,   'SysUser@destroy');

});

//区域管理
Route::group(['prefix'=>'backend/sysarea','namespace'=>'Backend'],function(){

    Route::get('index' , 'SysArea@index');

    Route::get('read' , 'SysArea@read');

    Route::post('get_permission' , 'SysArea@get_permission');

    Route::post('get_privilegedata' , 'SysArea@get_privilegeData');

    Route::post('update_permission' , 'SysArea@update_permission');

    Route::post('update/{id}' ,   'SysArea@update');

    Route::post('insert' ,   'SysArea@insert');

    Route::post('destroy' ,   'SysArea@destroy');

});


//商品分类
Route::group(['prefix'=>'backend/mergoodscatalog','namespace'=>'Backend'],function(){

    Route::get('index' , 'MerGoodsCatalog@index');

    Route::get('read' , 'MerGoodsCatalog@read');

    Route::post('get_permission' , 'MerGoodsCatalog@get_permission');

    Route::post('get_privilegedata' , 'MerGoodsCatalog@get_privilegeData');

    Route::post('update_permission' , 'MerGoodsCatalog@update_permission');

    Route::post('update/{id}' ,   'MerGoodsCatalog@update');

    Route::post('insert' ,   'MerGoodsCatalog@insert');

    Route::post('destroy' ,   'MerGoodsCatalog@destroy');

});

//机构管理
Route::group(['prefix'=>'backend/sysmerchant','namespace'=>'Backend'],function(){

    Route::get('index' , 'SysMerchant@index');

    Route::get('read' , 'SysMerchant@read');



    Route::get('read_detail/{id}' , 'SysMerchant@read_detail');

    Route::get('read_area/{pid}' , 'SysMerchant@read_area');

    Route::post('update/{id}' ,   'SysMerchant@update');

    Route::post('insert' ,   'SysMerchant@insert');

    Route::post('destroy' ,   'SysMerchant@destroy');

});

//系统用户
Route::group(['prefix'=>'backend/mersysuser','namespace'=>'Backend'],function(){

    Route::get('index/{merId?}' , 'MerSysUser@index');

    Route::get('read' , 'MerSysUser@read');

    Route::post('update/{id}' ,   'MerSysUser@update');

    Route::post('insert/{merId}' ,   'MerSysUser@insert');

    Route::post('destroy/{merId}' ,   'MerSysUser@destroy');

    Route::get('reset_pwd/{id}' ,   'MerSysUser@reset_pwd');

});

Route::group(['prefix'=>'backend/meruser','namespace'=>'Backend'],function(){

    Route::get('index' , 'MerUser@index');

    Route::get('read' , 'MerUser@read');

    Route::post('get_permission' , 'MerUser@get_permission');

    Route::post('get_privilegedata' , 'MerUser@get_privilegeData');

    Route::post('update_permission' , 'MerUser@update_permission');

    Route::post('update/{id}' ,   'MerUser@update');

    Route::post('insert' ,   'MerUser@insert');

    Route::post('destroy' ,   'MerUser@destroy');

    Route::get('reset_pwd/{id}' , 'MerUser@reset_pwd');

});

//接口模拟器
Route::group(['prefix'=>'backend/simulator','namespace'=>'Backend'],function(){

    Route::get('index' , 'Simulator@index');

    Route::get('read_api' , 'Simulator@read_api');

    Route::get('read_params' , 'Simulator@read_params');

});
Route::group(['prefix' => 'backend'] , function(){
    Auth::routes();
});


Route::get('/home', 'HomeController@index')->name('home');

