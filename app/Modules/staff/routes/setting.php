<?php
// Sectors
Route::resource('sectors','SectorController')->except('show','destroy');
Route::post('sectors/destroy','SectorController@destroy')->name('sectors.destroy');

// Departments
Route::resource('departments','DepartmentController')->except('show','destroy');
Route::post('departments/destroy','DepartmentController@destroy')->name('departments.destroy');

// Sections
Route::resource('sections','SectionController')->except('show','destroy');
Route::post('sections/destroy','SectionController@destroy')->name('sections.destroy');

// Positions
Route::resource('positions','PositionController')->except('show','destroy');
Route::post('positions/destroy','PositionController@destroy')->name('positions.destroy');