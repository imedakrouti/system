<?php
Route::group(['middleware'=>['user'],'namespace'=>'ParentStudent\Student'],function(){
    // view subjects
    Route::get('student/subjects','SubjectController@subjects')->name('student.subjects');
    // view playlists
    Route::get('student/playlists/{employee_id}','SubjectController@playlists')->name('student.playlists');
    // show lessons
    Route::get('student/show-lessons/{playlist_id}','SubjectController@showLessons')->name('student.show-lessons');
    // view lesson
    Route::get('student/view-lesson/{id}/{playlist_id}','SubjectController@viewLesson')->name('student.view-lesson');        
});