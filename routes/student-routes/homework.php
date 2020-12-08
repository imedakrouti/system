<?php
Route::group(['middleware'=>['user'],'namespace'=>'ParentStudent\Student'],function(){
    // homework
    Route::get('student/my-homeworks','HomeworkController@homeworks')->name('student.homeworks');      
    Route::get('student/my-homeworks/deliver/{homework_id}','HomeworkController@deliverHomework')->name('student.deliver-homeworks');      
    Route::post('student/my-homeworks/store','HomeworkController@storeHomework')->name('student.store-homework');         
    Route::get('student/homework/get-questions-page/{homework_id}','HomeworkController@questionsPage')->name('questions.page');
    Route::post('student/homework/store-answers','HomeworkController@storeQuestionsAnswers')->name('homework.store-answers');
    Route::get('student/homework/results','HomeworkController@homeworkResults')->name('homework.results');
    Route::get('student/homework/answers/{homework_id}','HomeworkController@homeworkAnswers')->name('homework.answers');    
});