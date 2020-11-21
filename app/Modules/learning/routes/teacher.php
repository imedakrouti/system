<?php
    Route::group(['namespace'=>'Learning'],function(){
      // playlist
      Route::get('teacher/playlists','TeacherController@playlists')->name('teacher.playlists');      
      Route::post('teacher/playlists/store','TeacherController@storePlaylist')->name('teacher.store-playlists');      
      Route::get('teacher/playlists/edit/{id}','TeacherController@editPlaylist')->name('teacher.edit-playlists');      
      Route::post('teacher/playlists/update/{id}','TeacherController@updatePlaylist')->name('teacher.update-playlists');      
      Route::post('teacher/playlists/destroy','TeacherController@destroyPlaylist')->name('teacher.destroy-playlists');      
      Route::post('teacher/playlists/set-classes','TeacherController@setClasses')->name('set-playlist-classes');      

      // lessons
      Route::get('teacher/show-lessons/{id}','TeacherController@showLessons')->name('teacher.show-lessons');      
      Route::get('teacher/new-lesson/{id}','TeacherController@newLesson')->name('teacher.new-lessons');      
      Route::post('teacher/new-lesson/store-lesson','TeacherController@storeLesson')->name('teacher.store-lessons');      
      Route::get('teacher/view-lesson/{id}/{playlist_id}','TeacherController@viewLesson')->name('teacher.view-lesson');      
      Route::get('teacher/edit-lesson/{id}','TeacherController@editLesson')->name('teacher.edit-lessons');      
      Route::post('teacher/edit-lesson/update/{id}','TeacherController@updateLesson')->name('teacher.update-lessons');  

      Route::get('teacher/view-lessons','TeacherController@viewLessons')->name('teacher.view-lessons');
      
      Route::post('teacher/attachment','TeacherController@attachment')->name('teacher.attachment');
      Route::post('teacher/attachment/destroy','TeacherController@attachmentDestroy')->name('teacher-attachment.destroy');
      Route::post('teacher/approval','TeacherController@approval')->name('teacher.approval');
      
      // exams
      Route::get('teacher/view-exams','TeacherController@viewExams')->name('teacher.view-exams');
      Route::get('teacher/new-exams','TeacherController@newExam')->name('teacher.new-exam');
      Route::post('teacher/store-exams','TeacherController@storeExam')->name('teacher.store-exam');
      Route::get('teacher/show-exams/{id}','TeacherController@showExam')->name('teacher.show-exam');
      Route::get('teacher/edit-exam/{id}','TeacherController@editExam')->name('teacher.edit-exam');
      Route::post('teacher/update-exam/{id}','TeacherController@updateExam')->name('teacher.update-exam');

      // questions
      Route::get('teacher/edit-question/{id}','TeacherController@editQuestion')->name('teacher.edit-question');
      Route::post('teacher/update-question/{id}','TeacherController@updateQuestion')->name('teacher.update-question');


  
    
    });  