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
    Route::get('student/results','UserStudentController@results')->name('student.results');      
    Route::get('student/answers/{exam_id}','UserStudentController@answers')->name('student.answers');      
    Route::get('student/pre-start-exams/{exam_id}','UserStudentController@preStartExam')->name('student.pre-start-exam');      
    Route::get('student/start-exam/{exam_id}','UserStudentController@startExam')->name('student.start-exam');      
    Route::post('student/end-exam','UserStudentController@submitExam')->name('student.submit-exam');
    Route::get('student/exam/feedback/{exam_id}','UserStudentController@examFeedback')->name('student.feedback-exam');      
    Route::put('student/exam/get/report','UserStudentController@getReport')->name('student.get-report');      

    // virtual classroom
    Route::get('student/view-schedule','UserStudentController@viewSchedule')->name('student.view-schedule');      
    Route::get('student/join-classroom','UserStudentController@joinClassroom')->name('student.join-classroom');      
    Route::get('student/live-classroom/{employee_id}/{zoom_schedule_id}','UserStudentController@liveClassroom')->name('student.live-classroom');      

    // homework
    Route::get('student/my-homeworks','UserStudentController@homeworks')->name('student.homeworks');      
    Route::get('student/my-homeworks/deliver/{homework_id}','UserStudentController@deliverHomework')->name('student.deliver-homeworks');      
    Route::post('student/my-homeworks/store','UserStudentController@storeHomework')->name('student.store-homework');      
    

});