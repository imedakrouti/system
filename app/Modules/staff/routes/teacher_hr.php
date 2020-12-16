<?php
   // Teacher Account
   // permissions
   Route::get('teacher/permissions','LeavePermissionController@profile')->name('teacher.permissions');
   Route::post('teacher/permission/store','LeavePermissionController@storePermission')->name('teacher.store-permission');

   // vacations
   Route::get('teacher/vacations','VacationController@profile')->name('teacher.vacations');
   Route::post('teacher/vacation/store','VacationController@storeVacation')->name('teacher.store-vacation');
   
   // loans
   Route::get('teacher/loans','LoanController@profile')->name('teacher.loans');
   Route::post('teacher/loan/store','LoanController@storeLoan')->name('teacher.store-loan');

   // deductions 
   Route::get('teacher/deductions','DeductionController@profile')->name('teacher.deductions');


   Route::get('teacher/attendance','TeacherController@attendance')->name('teacher.attendance');
   Route::get('/internal-regulation/teacher','InternalRegulationController@showForTeacher')->name('internal-regulations.teacher');
   Route::get('teacher/account','TeacherController@account')->name('teacher.account');
   Route::get('teacher/password','TeacherController@password')->name('teacher.password');
