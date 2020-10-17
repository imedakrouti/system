<?php
// Sectors
Route::resource('sectors','SectorController')->except('show','destroy');
Route::post('sectors/destroy','SectorController@destroy')->name('sectors.destroy');

// Departments
Route::resource('departments','DepartmentController')->except('show','destroy');
Route::post('departments/destroy','DepartmentController@destroy')->name('departments.destroy');