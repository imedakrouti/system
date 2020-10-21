<?php

Route::group(['namespace'=>'Employee'],function(){
    // Employee
    Route::resource('employees','EmployeeController')->except('destroy');
    Route::post('employees/destroy','EmployeeController@destroy')->name('employees.destroy');
    Route::put('/employees/all/filter','EmployeeController@filter')->name('employees.filter');       
    Route::post('/employees/update-structure','EmployeeController@updateStructure')->name('employees.update-structure');       
    Route::get('/employees/hr-letter-report/{id}','EmployeeController@hrLetterReport')->name('employee.hr-letter');       
    Route::get('/employees/leave-report/{id}','EmployeeController@leaveReport')->name('employee.leave');       
    Route::get('/employees/vacation-report/{id}','EmployeeController@vacationReport')->name('employee.vacation');       
    Route::get('/employees/loan-report/{id}','EmployeeController@loanReport')->name('employee.loan');       
    Route::get('/employees/experience-report/{id}','EmployeeController@experienceReport')->name('employee.experience');       



});  