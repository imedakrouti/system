<?php
Route::group(['namespace'=>'Payroll'],function(){
    Route::get('/payrolls/temporary-component','TemporaryComController@index')->name('temporary-component.index');
    Route::get('/payrolls/temporary-component/create','TemporaryComController@create')->name('temporary-component.create');
    Route::post('/payrolls/temporary-component/store','TemporaryComController@store')->name('temporary-component.store');
    Route::post('/payrolls/temporary-component/destroy','TemporaryComController@destroy')->name('temporary-component.destroy');
});