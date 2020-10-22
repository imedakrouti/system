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
    Route::get('/leaved/employees/all','EmployeeController@leaved')->name('employees.leaved');       
    Route::post('/leaved/employees/all','EmployeeController@backToWork')->name('employees.backToWork');       
    Route::get('/trash/employees/all','EmployeeController@trash')->name('employees.trash');       
    Route::post('/trash/employees/all','EmployeeController@restore')->name('employees.restore');       

    //  advanced search
    Route::get('advanced-search/employees/filter','EmployeeController@advancedSearchPage')->name('employees.advanced-search');
    Route::put('employees/advanced-search/ajax','EmployeeController@search')->name('employees.advancedSearch');


    // attachments
    Route::resource('attachments','AttachmentController')->except('destroy','show');
    Route::post('attachments/destroy','AttachmentController@destroy')->name('attachments.destroy');

    // loans
    Route::resource('loans','LoanController')->except('destroy','edit','update','show');
    Route::post('loans/destroy','LoanController@destroy')->name('loans.destroy');
    Route::post('loans/accept','LoanController@accept')->name('loans.accept');
    Route::post('loans/reject','LoanController@reject')->name('loans.reject');
    Route::post('loans/cancel','LoanController@cancel')->name('loans.cancel');
    Route::get('loans-confirm/loans','LoanController@confirm')->name('loans.confirm');
    Route::post('loans-confirm/loans/accept','LoanController@acceptConfirm')->name('loans.accept-confirm');
    Route::post('loans-confirm/loans/reject','LoanController@rejectConfirm')->name('loans.reject-confirm');  
    Route::put('loans/filter','LoanController@filter')->name('loans.filter');
    Route::put('loans/filter/confirm','LoanController@filterConfirm')->name('loans.filter-confirm');


    
});  