<?php
 Route::group(['namespace'=>'ParentsAndStudents'],function(){            
     Route::get('/parents','ParentController@index')->name('parents.index');
     Route::get('/parents/create','ParentController@create')->name('parents.create');
     Route::post('/parents/store','ParentController@store')->name('parents.store');
     Route::post('/parents/destroy','ParentController@destroy')->name('parents.destroy');
    //  father
     Route::get('/parents/fathers/show/{id}','ParentController@fatherShow')->name('father.show');
     Route::get('/parents/fathers/{id}/edit','ParentController@editFather')->name('fathers.edit');
     Route::post('/parents/fathers/update/{id}','ParentController@updateFather')->name('fathers.update');
     Route::get('/parents/fathers/add-wife/{id}','ParentController@addWife')->name('fathers.addWife');
     Route::post('/parents/fathers/add-wife','ParentController@storeWife')->name('addWife.store');
    // mother
     Route::get('/parents/mothers/show/{id}','ParentController@motherShow')->name('mother.show');
     Route::get('/parents/mothers/{id}/edit','ParentController@editMother')->name('mothers.edit');
     Route::post('/parents/mothers/update/{id}','ParentController@updateMother')->name('mothers.update');
     Route::get('/parents/mothers/add-wife/{id}','ParentController@addHusband')->name('mothers.addHusband');
     Route::post('/parents/mothers/add-wife','ParentController@storeHusband')->name('addHusband.store');
    // Guardian
     Route::resource('/guardians','GuardianController')->except('destroy');
     Route::post('/guardians/destroy','GuardianController@destroy')->name('guardians.destroy');
     Route::get('/guardians/show/students/{id}','GuardianController@guardiansShowStudents')->name('guardians.show.students');

    // Contacts
    Route::resource('/contacts','ContactController')->except('destroy','show','create','index');
    Route::get('/contacts/index/{id}','ContactController@index')->name('contacts.index');
    Route::get('/contacts/create/{id}','ContactController@create')->name('contacts.create');
    Route::post('/contacts/destroy','ContactController@destroy')->name('contacts.destroy');

    // Notes
    /**
     * Fathers Notes
     */
    
    Route::get('/father-notes/index/{id}','FatherNoteController@index')->name('father-notes.index');
    Route::get('/father-notes/create/{id}','FatherNoteController@create')->name('father-notes.create');
    Route::get('/father-notes/edit/{id}','FatherNoteController@edit')->name('father-notes.edit');
    Route::post('/father-notes/store','FatherNoteController@store')->name('father-notes.store');
    Route::post('/father-notes/update/{id}','FatherNoteController@update')->name('father-notes.update');
    Route::post('/father-notes/destroy','FatherNoteController@destroy')->name('father-notes.destroy');

    
    /**
     * Student Notes
     */
     
    Route::get('/student-notes/index/{id}','StudentNoteController@index')->name('student-notes.index');
    Route::get('/student-notes/create/{id}','StudentNoteController@create')->name('student-notes.create');
    Route::get('/student-notes/edit/{id}','StudentNoteController@edit')->name('student-notes.edit');
    Route::post('/student-notes/store','StudentNoteController@store')->name('student-notes.store');
    Route::post('/student-notes/update/{id}','StudentNoteController@update')->name('student-notes.update');
    Route::post('/student-notes/destroy','StudentNoteController@destroy')->name('student-notes.destroy');     
});