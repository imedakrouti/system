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

     Route::resource('/guardians','GuardianController')->except('destroy');
     Route::post('/guardians/destroy','GuardianController@destroy')->name('guardians.destroy');
     Route::get('/guardians/show/students/{id}','GuardianController@guardiansShowStudents')->name('guardians.show.students');
});