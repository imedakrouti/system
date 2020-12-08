<?php
Route::group(['middleware'=>['user'],'namespace'=>'ParentStudent\Student'],function(){
    // exams
    Route::get('student/upcoming-exams','ExamController@upcomingExams')->name('student.upcoming-exams');      
    Route::get('student/my-exams','ExamController@exams')->name('student.exams');      
    Route::get('student/results','ExamController@results')->name('student.results');      
    Route::get('student/answers/{exam_id}','ExamController@answers')->name('student.answers');      
    Route::get('student/pre-start-exams/{exam_id}','ExamController@preStartExam')->name('student.pre-start-exam');      
    Route::get('student/start-exam/{exam_id}','ExamController@startExam')->name('student.start-exam');      
    Route::post('student/end-exam','ExamController@submitExam')->name('student.submit-exam');
    Route::get('student/exam/feedback/{exam_id}','ExamController@examFeedback')->name('student.feedback-exam');      
    Route::put('student/exam/get/report','ExamController@getReport')->name('student.get-report');      
});