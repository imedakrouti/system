<?php
// Subjects
Route::resource('subjects','SubjectController')->except('show','destroy');
Route::post('subjects/destroy','SubjectController@destroy')->name('subjects.destroy');
Route::put('subjects/get/filter','SubjectController@filter')->name('subjects.filter');

// teacher subjects
Route::get('teacher-subjects/index','EmployeeSubjectController@index')->name('teacher-subjects.index');
Route::get('teacher-subjects/create','EmployeeSubjectController@create')->name('teacher-subjects.create');
Route::post('teacher-subjects/store','EmployeeSubjectController@store')->name('teacher-subjects.store');
Route::post('teacher-subjects/destroy','EmployeeSubjectController@destroy')->name('teacher-subjects.destroy');

// teacher classes
Route::get('teacher-classes/index','EmployeeClassroomController@index')->name('teacher-classes.index');
Route::get('teacher-classes/create','EmployeeClassroomController@create')->name('teacher-classes.create');
Route::post('teacher-classes/store','EmployeeClassroomController@store')->name('teacher-classes.store');
Route::post('teacher-classes/destroy','EmployeeClassroomController@destroy')->name('teacher-classes.destroy');

// student subjects
Route::get('student-subjects/index','StudentSubjectController@index')->name('student-subjects.index');
Route::get('student-subjects/create','StudentSubjectController@create')->name('student-subjects.create');
Route::post('student-subjects/store','StudentSubjectController@store')->name('student-subjects.store');
Route::post('student-subjects/destroy','StudentSubjectController@destroy')->name('student-subjects.destroy');