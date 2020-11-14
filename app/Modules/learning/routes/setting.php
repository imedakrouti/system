<?php
// Subjects
Route::resource('subjects','SubjectController')->except('show','destroy');
Route::post('subjects/destroy','SubjectController@destroy')->name('subjects.destroy');
Route::put('subjects/get/filter','SubjectController@filter')->name('subjects.filter');
