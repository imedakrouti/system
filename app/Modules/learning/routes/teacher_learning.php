<?php
    Route::group(['namespace'=>'Learning'],function(){
      // playlist
      Route::get('teacher/playlists','PlaylistController@playlists')->name('teacher.playlists');      
      Route::post('teacher/playlists/store','PlaylistController@storePlaylist')->name('teacher.store-playlists');      
      Route::get('teacher/playlists/edit/{id}','PlaylistController@editPlaylist')->name('teacher.edit-playlists');      
      Route::post('teacher/playlists/update/{id}','PlaylistController@updatePlaylist')->name('teacher.update-playlists');      
      Route::post('teacher/playlists/destroy','PlaylistController@destroyPlaylist')->name('teacher.destroy-playlists');      
      Route::post('teacher/playlists/set-classes','PlaylistController@setClasses')->name('set-playlist-classes');      
      Route::get('teacher/show-lessons/{id}','PlaylistController@showLessons')->name('teacher.show-lessons');      

      // lessons
      Route::get('teacher/new-lesson/{id}','LessonController@newLesson')->name('teacher.new-lessons');      
      Route::post('teacher/new-lesson/store-lesson','LessonController@storeLesson')->name('teacher.store-lessons');      
      Route::get('teacher/view-lesson/{id}/{playlist_id}','LessonController@viewLesson')->name('teacher.view-lesson');      
      Route::get('teacher/edit-lesson/{id}','LessonController@editLesson')->name('teacher.edit-lessons');      
      Route::post('teacher/edit-lesson/update/{id}','LessonController@updateLesson')->name('teacher.update-lessons');  
      Route::get('teacher/view-lessons','LessonController@viewLessons')->name('teacher.view-lessons');
      Route::post('teacher/attachment','LessonController@attachment')->name('teacher.attachment');
      Route::post('teacher/attachment/destroy','LessonController@attachmentDestroy')->name('teacher-attachment.destroy');
      Route::post('teacher/approval','LessonController@approval')->name('teacher.approval');
      Route::get('teacher/students-views/{id}','LessonController@studentViews')->name('teacher.students-views');
      
      // exams
      Route::get('teacher/view-exams','ExamController@viewExams')->name('teacher.view-exams');
      Route::get('teacher/new-exams','ExamController@newExam')->name('teacher.new-exam');
      Route::post('teacher/store-exams','ExamController@storeExam')->name('teacher.store-exam');
      Route::get('teacher/show-exams/{id}','ExamController@showExam')->name('teacher.show-exam');
      Route::get('teacher/edit-exam/{id}','ExamController@editExam')->name('teacher.edit-exam');
      Route::post('teacher/update-exam/{id}','ExamController@updateExam')->name('teacher.update-exam');
      Route::get('teacher/preview-exam/{id}','ExamController@preview')->name('teacher.preview-exam');
      Route::post('teacher/exam/set-classes','ExamController@setExamClasses')->name('set-exam-classes');      
      Route::get('teacher/exam/applicants/{id}','ExamController@applicants')->name('teacher.applicants');      
      Route::get('teacher/exam/show-answers/{id}','ExamController@showAnswers')->name('teacher.show-answers');      
      Route::post('teacher/exam/correct-answers','ExamController@correct')->name('teacher.correct-answers');      
      Route::post('teacher/exam/destroy/answers','ExamController@destroyAnswers')->name('teacher.destroy-answers');      
      Route::put('teacher/exam/get/answer','ExamController@getAnswer')->name('teacher.get-answer');      
      Route::put('teacher/exam/get/report','ExamController@getReport')->name('teacher.get-report');      
      Route::post('teacher/exam/report','ExamController@examReport')->name('teacher.exam-report');      

      // questions
      Route::post('teacher/store-question','ExamController@storeQuestion')->name('teacher.store-question');
      Route::get('teacher/edit-question/{id}','ExamController@editQuestion')->name('teacher.edit-question');
      Route::post('teacher/update-question/{id}','ExamController@updateQuestion')->name('teacher.update-question');

      // homework
      Route::resource('homeworks','HomeworkController')->except('destroy','index');
      Route::get('teacher/homeworks','HomeworkController@teacherHomeworks')->name('teacher.homeworks');
      Route::post('teacher/homeworks/destroy','HomeworkController@destroy')->name('homeworks.destroy');
      Route::get('homework/question/{id}','HomeworkController@questionPage')->name('homework-question');
      Route::post('homework/store-question','HomeworkController@storeQuestion')->name('homework.store-question');
      Route::get('homework/solve-homework-page/{id}','HomeworkController@solveHomeworkPage')->name('homework.solve-question');
      Route::post('homework/share-homework','HomeworkController@share')->name('homework.share');
      Route::get('teacher/homework/applicants/{id}','HomeworkController@homeworkApplicants')->name('teacher.homework-applicants');      
      Route::post('teacher/homework/destroy/answers','HomeworkController@destroyAnswers')->name('homework.destroy-answers');      
      Route::get('teacher/homework/show-answers/{id}','HomeworkController@showAnswers')->name('homework.show-answers');      
      Route::post('teacher/homework/set-mark/answers','HomeworkController@setHomeworkMark')->name('set-homework-mark');      
      // virtual classrooms
      // zoom accounts
      Route::get('virtual-classrooms/zoom/account','ZoomAccountController@zoomAccount')->name('zoom.account');
      Route::post('virtual-classrooms/zoom/account','ZoomAccountController@storeZoomAccount')->name('zoom.store-account');

      // zoom schedules
      Route::resource('zoom-schedules','ZoomScheduleController')->except('destroy','show');
      Route::get('zoom-schedules/view/zoom-schedule','ZoomScheduleController@viewZoomSchedule')->name('zoom-schedules.view');
      Route::post('zoom-schedules/destroy','ZoomScheduleController@destroy')->name('zoom-schedules.destroy');
      Route::get('zoom-schedules/live/{id}','ZoomScheduleController@zoomLive')->name('zoom.live');
      Route::get('zoom-schedules/attendances/{id}','ZoomScheduleController@attendances')->name('zoom.attendances');
      Route::put('zoom-schedules/attendances/join-time','ZoomScheduleController@joinTime')->name('zoom.join-time');

      // classrooms name list
      Route::get('students/name-list/{classroom_id}','TeacherController@nameList')->name('students.name-list');
      Route::get('teacher/name-list/student-data','TeacherController@studentData')->name('teacher.student-data');
      Route::get('teacher/name-list/homework','TeacherController@homework')->name('teacher.homework');
      Route::get('teacher/name-list/exams','TeacherController@exams')->name('teacher.exams');


      // behaviour
      Route::resource('/behaviour','BehaviourController')->except('destroy');
      Route::post('/behaviour/destroy','BehaviourController@destroy')->name('behaviour.destroy');
      // Absences
      Route::resource('/absences','AbsencesController');
    
    });  