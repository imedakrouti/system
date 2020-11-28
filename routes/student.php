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

    
    
    // view subjects
    Route::get('student/subjects','UserStudentController@subjects')->name('student.subjects');
    
    // view playlists
    Route::get('student/playlists/{employee_id}','UserStudentController@playlists')->name('student.playlists');
    // show lessons
    Route::get('student/show-lessons/{playlist_id}','UserStudentController@showLessons')->name('student.show-lessons');
    // view lesson
    Route::get('student/view-lesson/{id}/{playlist_id}','UserStudentController@viewLesson')->name('student.view-lesson');      

    // exams
    Route::get('student/upcoming-exams','UserStudentController@upcomingExams')->name('student.upcoming-exams');      
    Route::get('student/my-exams','UserStudentController@exams')->name('student.exams');      
    // start exam
    Route::get('student/pre-start-exams/{exam_id}','UserStudentController@preStartExam')->name('student.pre-start-exam');      
    Route::get('student/start-exam/{exam_id}','UserStudentController@startExam')->name('student.start-exam');      
    
    Route::post('student/end-exam','UserStudentController@submitExam')->name('student.submit-exam');
    Route::get('student/exam/feedback/{exam_id}','UserStudentController@examFeedback')->name('student.feedback-exam');      


    

});