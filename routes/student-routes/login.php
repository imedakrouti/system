<?php
// login
Route::get('/login', 'ParentStudent\AuthController@login')->name('login');
Route::post('/login', 'ParentStudent\AuthController@setLogin')->name('user.login');

// logout
Route::group(['middleware'=>['user'],'namespace'=>'ParentStudent'],function(){
    Route::get('user/logout-login', 'AuthController@logout')->name('user.logout');
});