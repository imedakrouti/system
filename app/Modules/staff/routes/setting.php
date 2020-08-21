<?php
/**
 * Sectors
 */
Route::resource('sector','SectorController')->except('show','destroy');
Route::post('sector/destroy','SectorController@destroy')->name('sector.destroy');
Route::get('get/sectors','SectorController@getSectors')->name('getSectors');
Route::get('get/sectors/null','SectorController@getSectorsWithNull')->name('getSectorsWithNull');
Route::put('get/sectorsSelected','SectorController@getSectorsSelected')->name('getSectorsSelected');

/**
 * Departments
 */
Route::resource('department','DepartmentController')->except('show','destroy');
Route::post('department/destroy','DepartmentController@destroy')->name('department.destroy');
Route::put('get/departments','DepartmentController@getDepartments')->name('getDepartments');
Route::get('get/departments/null','DepartmentController@getDepartmentsWithNull')->name('getDepartmentsWithNull');
