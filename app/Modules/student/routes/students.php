<?php
 Route::group(['namespace'=>'ParentsAndStudents'],function(){   
    //  admissions    
     Route::resource('/students','StudentController')->except('create','destroy');
     Route::get('/student/create/{id}','StudentController@create')->name('student.create');
     Route::post('/students/destroy','StudentController@destroy')->name('students.destroy');       
    //  advanced search
    Route::get('advanced-search/students','StudentController@advancedSearchPage')->name('advanced.search');
    Route::put('advanced-search/students/ajax','StudentController@search')->name('advancedSearch');
    
     
});