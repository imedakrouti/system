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

    // Deduction
    Route::resource('deductions','DeductionController')->except('destroy','show');
    Route::post('deductions/destroy','DeductionController@destroy')->name('deductions.destroy');
    Route::post('deductions/accept','DeductionController@accept')->name('deductions.accept');
    Route::post('deductions/reject','DeductionController@reject')->name('deductions.reject');
    Route::post('deductions/cancel','DeductionController@cancel')->name('deductions.cancel');
    Route::get('deductions-confirm/deductions','DeductionController@confirm')->name('deductions.confirm');
    Route::post('deductions-confirm/deductions/accept','DeductionController@acceptConfirm')->name('deductions.accept-confirm');
    Route::post('deductions-confirm/deductions/reject','DeductionController@rejectConfirm')->name('deductions.reject-confirm');  
    Route::put('deductions/search/get/filter','DeductionController@filter')->name('deductions.filter');
    Route::put('deductions/search/get/filter/confirm','DeductionController@filterConfirm')->name('deductions.filter-confirm');

    // Vacation
    Route::resource('vacations','VacationController')->except('destroy','show','edit','update');
    Route::post('vacations/destroy','VacationController@destroy')->name('vacations.destroy');
    Route::post('vacations/accept','VacationController@accept')->name('vacations.accept');
    Route::post('vacations/reject','VacationController@reject')->name('vacations.reject');
    Route::post('vacations/cancel','VacationController@cancel')->name('vacations.cancel');
    Route::get('vacations-confirm/vacations','VacationController@confirm')->name('vacations.confirm');
    Route::post('vacations-confirm/vacations/accept','VacationController@acceptConfirm')->name('vacations.accept-confirm');
    Route::post('vacations-confirm/vacations/reject','VacationController@rejectConfirm')->name('vacations.reject-confirm');  
    Route::put('vacations/search/get/filter','VacationController@filter')->name('vacations.filter');
    Route::put('vacations/search/get/filter/confirm','VacationController@filterConfirm')->name('vacations.filter-confirm');
    Route::get('vacations-balance/vacations','VacationController@balance')->name('vacations.balance');
    Route::post('vacations-balance/vacations','VacationController@setBalance')->name('vacations.set-balance');

    // Leave Permissions
    Route::resource('leave-permissions','LeavePermissionController')->except('destroy','show','edit','update');
    Route::post('leave-permissions/destroy','LeavePermissionController@destroy')->name('leave-permissions.destroy');  
    Route::post('leave-permissions/accept','LeavePermissionController@accept')->name('leave-permissions.accept');
    Route::post('leave-permissions/reject','LeavePermissionController@reject')->name('leave-permissions.reject');
    Route::post('leave-permissions/cancel','LeavePermissionController@cancel')->name('leave-permissions.cancel');
    Route::get('leave-permissions-confirm/leave-permissions','LeavePermissionController@confirm')->name('leave-permissions.confirm');
    Route::post('leave-permissions-confirm/leave-permissions/accept','LeavePermissionController@acceptConfirm')->name('leave-permissions.accept-confirm');
    Route::post('leave-permissions-confirm/leave-permissions/reject','LeavePermissionController@rejectConfirm')->name('leave-permissions.reject-confirm');  
    Route::put('leave-permissions/search/get/filter','LeavePermissionController@filter')->name('leave-permissions.filter');
    Route::put('leave-permissions/search/get/filter/confirm','LeavePermissionController@filterConfirm')->name('leave-permissions.filter-confirm');
    Route::get('leave-permissions-balance/leave-permissions','LeavePermissionController@balance')->name('leave-permissions.balance');
    Route::post('leave-permissions-balance/leave-permissions','LeavePermissionController@setBalance')->name('leave-permissions.set-balance');
    Route::get('leave-permissions-deduction/leave-permissions','LeavePermissionController@leaveDeduction')->name('leave-permissions.deduction');

    // attendance
    Route::get('attendances/import','AttendanceController@importPage')->name('attendances.import');
    Route::post('attendances/import/excel','AttendanceController@importExcel')->name('attendances.import-excel');
    Route::post('attendances/destroy','AttendanceController@destroy')->name('attendances.destroy');  
    Route::get('attendances/sheet/{id}','AttendanceController@attendanceSheet')->name('attendances.sheet');  
    Route::get('attendances/logs','AttendanceController@logs')->name('attendances.logs');  
    Route::put('attendances/sheet','AttendanceController@sheetLogs')->name('attendances.logs-sheet');  
    Route::put('attendances/summary','AttendanceController@summary')->name('attendances.summary');  
    Route::get('attendances/logs/sheet/report','AttendanceController@attendanceSheetReport')->name('attendances.report');  

    // reports
    Route::get('reports/print','EmployeeController@employeesReports')->name('employees.reports');
    Route::get('reports/print/contacts','EmployeeController@contacts')->name('employees.contacts');
    Route::get('reports/print/insurance','EmployeeController@insurance')->name('employees.insurance');
    Route::get('reports/print/tax','EmployeeController@tax')->name('employees.tax');
    Route::get('reports/print/bus','EmployeeController@bus')->name('employees.bus');
    Route::get('reports/print/salaries','EmployeeController@salaries')->name('employees.salaries');
    Route::get('reports/print/contract','EmployeeController@contract')->name('employees.contract');
    Route::get('reports/print/salarySuspended','EmployeeController@salarySuspended')->name('employees.salarySuspended');
    Route::get('reports/print/timetable','EmployeeController@noTimetable')->name('employees.timetable');
    Route::get('reports/print/requiredDocument','EmployeeController@requiredDocument')->name('employees.requiredDocument');
    

});  