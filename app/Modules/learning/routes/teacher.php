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
      Route::get('teacher/students-views/{id}','TeacherController@studentViews')->name('teacher.students-views');
      
      // exams
      Route::get('teacher/view-exams','TeacherController@viewExams')->name('teacher.view-exams');
      Route::get('teacher/new-exams','TeacherController@newExam')->name('teacher.new-exam');
      Route::post('teacher/store-exams','TeacherController@storeExam')->name('teacher.store-exam');
      Route::get('teacher/show-exams/{id}','TeacherController@showExam')->name('teacher.show-exam');
      Route::get('teacher/edit-exam/{id}','TeacherController@editExam')->name('teacher.edit-exam');
      Route::post('teacher/update-exam/{id}','TeacherController@updateExam')->name('teacher.update-exam');
      Route::get('teacher/preview-exam/{id}','TeacherController@preview')->name('teacher.preview-exam');
      Route::post('teacher/exam/set-classes','TeacherController@setExamClasses')->name('set-exam-classes');      
      Route::get('teacher/exam/applicants/{id}','TeacherController@applicants')->name('teacher.applicants');      
      Route::get('teacher/exam/show-answers/{id}','TeacherController@showAnswers')->name('teacher.show-answers');      
      Route::post('teacher/exam/correct-answers','TeacherController@correct')->name('teacher.correct-answers');      
      Route::post('teacher/exam/destroy/answers','TeacherController@destroyAnswers')->name('teacher.destroy-answers');      
      Route::put('teacher/exam/get/answer','TeacherController@getAnswer')->name('teacher.get-answer');      
      Route::put('teacher/exam/get/report','TeacherController@getReport')->name('teacher.get-report');      
      Route::post('teacher/exam/report','TeacherController@examReport')->name('teacher.exam-report');      

      // questions
      Route::post('teacher/store-question','TeacherController@storeQuestion')->name('teacher.store-question');
      Route::get('teacher/edit-question/{id}','TeacherController@editQuestion')->name('teacher.edit-question');
      Route::post('teacher/update-question/{id}','TeacherController@updateQuestion')->name('teacher.update-question');

      // show classrooms
      Route::get('teacher/show-classrooms','TeacherController@classrooms')->name('teacher.classrooms');

      // homework
      Route::resource('homeworks','HomeworkController')->except('destroy');
      Route::get('teacher/homeworks','HomeworkController@teacherHomeworks')->name('teacher.homeworks');
      Route::post('teacher/homeworks/destroy','HomeworkController@destroy')->name('homeworks.destroy');
      Route::get('homework/question/{id}','HomeworkController@questionPage')->name('homework-question');
      Route::post('homework/store-question','HomeworkController@storeQuestion')->name('homework.store-question');
      Route::get('homework/solve-homework-page/{id}','HomeworkController@solveHomeworkPage')->name('homework.solve-question');
      Route::post('homework/share-homework','HomeworkController@share')->name('homework.share');
  
      // virtual classrooms
      // zoom accounts
      Route::get('virtual-classrooms/zoom/account','ZoomAccountController@zoomAccount')->name('zoom.account');
      Route::post('virtual-classrooms/zoom/account','ZoomAccountController@storeZoomAccount')->name('zoom.store-account');

      // zoom schedules
      Route::resource('zoom-schedules','ZoomScheduleController')->except('destroy','show');
      Route::get('zoom-schedules/view/zoom-schedule','ZoomScheduleController@viewZoomSchedule')->name('zoom-schedules.view');
      Route::post('zoom-schedules/destroy','ZoomScheduleController@destroy')->name('zoom-schedules.destroy');
      Route::get('zoom/live','ZoomScheduleController@zoomLive')->name('zoom.live');
    
    });  