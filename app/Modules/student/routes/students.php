<?php
 Route::group(['namespace'=>'ParentsAndStudents'],function(){            
     Route::get('/applicants','StudentController@applicants')->name('applicants.index');
     Route::resource('/students','StudentController')->except('create','destroy');
     Route::get('/applicants/{id}','StudentController@create')->name('applicant.create');
     Route::post('/students/destroy','StudentController@destroy')->name('students.destroy');
});