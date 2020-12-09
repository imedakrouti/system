<?php
    Route::group(['namespace'=>'Learning'],function(){
        

        // playlists
        Route::resource('playlists','PlaylistController')->only('index','show');
        Route::post('playlists/destroy','PlaylistController@destroy')->name('playlists.destroy');
        Route::get('playlists/employee/{id}','PlaylistController@employee')->name('playlists.employee');

        // lessons
        Route::resource('lessons','LessonController')->only('index','show');
        Route::post('lessons/destroy','LessonController@destroy')->name('lessons.destroy');
        Route::post('lessons/attachment','LessonController@attachment')->name('lessons.attachment');
        Route::post('lessons/attachment/destroy','LessonController@attachmentDestroy')->name('lesson-attachment.destroy');
        Route::post('lessons/approval','LessonController@approval')->name('lessons.approval');
        Route::post('lessons/exams','LessonController@lessonExamsRelated')->name('lessons.exams');
        
        // exams
        Route::resource('exams','ExamController')->except('destroy');
        Route::post('exams/destroy','ExamController@destroy')->name('exams.destroy');
        Route::get('exams/employee/{id}','ExamController@employee')->name('exams.employee');
        Route::get('exams/preview/{id}','ExamController@preview')->name('exams.preview');

        // questions
        Route::resource('questions','QuestionController')->except('destroy');        
        Route::post('questions/destroy','QuestionController@destroy')->name('questions.destroy');
    
    });  