<?php
Route::group(['middleware'=>['user'],'namespace'=>'ParentStudent\Student'],function(){
    // dashboard
    // student dashboard
    Route::get('/parent-dashboard', 'UserParentController@dashboard')->name('parent.dashboard');
    
    Route::get('/student-dashboard', 'DashboardController@dashboard')->name('student.dashboard');
    // student comment
    Route::post('student/comment','DashboardController@storeComment')->name('student-store.comment');
    Route::get('student/comment/get','DashboardController@comments')->name('student.comments');
});