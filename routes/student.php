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

    
    Route::get('student/preview-exam/{id}','UserStudentController@preview')->name('student.preview-exam');
    
    // view subjects
    Route::get('student/subjects','UserStudentController@subjects')->name('student.subjects');
    
    // view playlists
    Route::get('student/playlists/{employee_id}','UserStudentController@playlists')->name('student.playlists');
    // show lessons
    Route::get('student/show-lessons/{playlist_id}','UserStudentController@showLessons')->name('student.show-lessons');
    // view lesson
    Route::get('student/view-lesson/{id}/{playlist_id}','UserStudentController@viewLesson')->name('student.view-lesson');      
    

});