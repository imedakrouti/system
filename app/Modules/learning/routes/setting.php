<?php
// Subjects
Route::resource('subjects','SubjectController')->except('show','destroy');
Route::post('subjects/destroy','SubjectController@destroy')->name('subjects.destroy');
Route::put('subjects/get/filter','SubjectController@filter')->name('subjects.filter');

// teacher subjects
Route::get('teacher-subjects/index','TeacherSubjectController@index')->name('teacher-subjects.index');
Route::get('teacher-subjects/create','TeacherSubjectController@create')->name('teacher-subjects.create');
Route::post('teacher-subjects/store','TeacherSubjectController@store')->name('teacher-subjects.store');
Route::post('teacher-subjects/destroy','TeacherSubjectController@destroy')->name('teacher-subjects.destroy');