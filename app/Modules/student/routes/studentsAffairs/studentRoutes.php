<?php

Route::group(['namespace'=>'StudentsAffairs'],function(){
    Route::post('student/add-statement','StudentStatementsController@addToStatement')->name('statement.addStudent');
    Route::resource('statements','StudentStatementsController')->except('show','edit','destroy');
    Route::put('statements/filter/students','StudentStatementsController@filter')->name('statements.filter');
    Route::post('/statements/s/destroy','StudentStatementsController@destroy')->name('statements.destroy');   
    Route::post('/statements/s/store-to-statement','StudentStatementsController@storeToStatement')->name('statements.storeToStatement');   
    Route::post('/statements/s/restore','StudentStatementsController@restoreMigration')->name('statements.restore');   
    Route::get('/statements/s/statistics-report','StudentStatementsController@statisticsReport')->name('statistics.report');   
    Route::get('/statements/s/add-to-statement','StudentStatementsController@insertStatement')->name('statements.insert');   
    Route::get('/statements/s/print-statement','StudentStatementsController@printStatementReport')->name('statements.printStatement');   
    
    // set-migration
    Route::get('/set-migrations','SetMigrationController@index')->name('setMigration.index');   
    Route::post('/set-migrations/store','SetMigrationController@storeSetMigration')->name('setMigration.store');   
    Route::post('/set-migrations/del/destroy','SetMigrationController@destroy')->name('setMigration.destroy');   
    
});
