<?php

Route::group(['namespace'=>'StudentsAffairs'],function(){
    Route::post('student/add-statement','StudentStatementsController@addToStatement')->name('statement.addStudent');
    Route::resource('statements','StudentStatementsController')->except('show','edit','destroy');
    Route::put('statements/filter/students','StudentStatementsController@filter')->name('statements.filter');
    Route::post('/statements/destroy','StudentStatementsController@destroy')->name('statements.destroy');   
    
});
