<?php
// login
Route::get('/login', 'ParentStudent\AuthController@login')->name('login');
Route::post('/login', 'ParentStudent\AuthController@setLogin')->name('user.login');

Route::group(['middleware'=>['user'],'namespace'=>'ParentStudent'],function(){
    
    Route::get('user/logout-login', 'AuthController@logout')->name('user.logout');
    
    // dashboard
    // student dashboard
    Route::get('/student-dashboard', 'UserStudentController@dashboard')->name('student.dashboard');
    Route::get('/parent-dashboard', 'UserParentController@dashboard')->name('parent.dashboard');

    // student comment
    Route::post('student/comment','UserStudentController@storeComment')->name('student-store.comment');
    Route::get('student/comment/get','UserStudentController@comments')->name('student.comments');

});