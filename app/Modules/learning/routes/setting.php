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

// grade subjects
Route::get('grade-subjects/index','GradeSubjectController@index')->name('grade-subjects.index');
Route::get('grade-subjects/create','GradeSubjectController@create')->name('grade-subjects.create');
Route::post('grade-subjects/store','GradeSubjectController@store')->name('grade-subjects.store');
Route::post('grade-subjects/destroy','GradeSubjectController@destroy')->name('grade-subjects.destroy');

// division subjects
Route::get('division-subjects/index','DivisionSubjectController@index')->name('division-subjects.index');
Route::get('division-subjects/create','DivisionSubjectController@create')->name('division-subjects.create');
Route::post('division-subjects/store','DivisionSubjectController@store')->name('division-subjects.store');
Route::post('division-subjects/destroy','DivisionSubjectController@destroy')->name('division-subjects.destroy');