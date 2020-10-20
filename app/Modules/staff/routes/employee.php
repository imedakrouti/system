<?php

Route::group(['namespace'=>'Employee'],function(){
    // Employee
    Route::resource('employees','EmployeeController')->except('destroy');
    Route::post('employees/destroy','EmployeeController@destroy')->name('employees.destroy');
    Route::put('/employees/all/filter','EmployeeController@filter')->name('employees.filter');       



});  