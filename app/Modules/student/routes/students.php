<?php
 Route::group(['namespace'=>'ParentsAndStudents'],function(){   
    //  admissions    
     Route::resource('/students','StudentController')->except('create','destroy');
     Route::get('/student/create/{id}','StudentController@create')->name('student.create');
     Route::post('/students/destroy','StudentController@destroy')->name('students.destroy');       
     Route::get('/students/print/{id}','StudentController@printApplicationReport')->name('students.print');       
     Route::put('/students/all/filter','StudentController@filter')->name('students.filter');       
    //  advanced search
    Route::get('advanced-search/students','StudentController@advancedSearchPage')->name('advanced.search');
    Route::put('advanced-search/students/ajax','StudentController@search')->name('advancedSearch');
    
    Route::put('students/grades/data','StudentController@getGradesData')->name('students.getGradesData');

    // proof_enrollment
    Route::get('students/report/proof_enrollment/{id}','StudentController@proofEnrollment')->name('students.proof-enrollment');


    
     
});