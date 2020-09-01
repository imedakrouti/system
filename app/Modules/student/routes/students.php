<?php
 Route::group(['namespace'=>'ParentsAndStudents'],function(){            
     Route::get('/students','StudentController@index')->name('students.index');
     Route::resource('/students','StudentController')->except('create','destroy');
     Route::get('/student/create/{id}','StudentController@create')->name('student.create');
     Route::post('/students/destroy','StudentController@destroy')->name('students.destroy');     
     
});