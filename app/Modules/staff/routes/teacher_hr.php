<?php
   // Teacher Account
   Route::get('teacher/permissions','TeacherController@permissions')->name('teacher.permissions');
   Route::get('teacher/vacations','TeacherController@vacations')->name('teacher.vacations');
   Route::get('teacher/loans','TeacherController@loans')->name('teacher.loans');
   Route::get('teacher/deductions','TeacherController@deductions')->name('teacher.deductions');
   Route::get('teacher/payrolls','TeacherController@payrolls')->name('teacher.payrolls');
   Route::get('teacher/attendance','TeacherController@attendance')->name('teacher.attendance');
   Route::get('/internal-regulation/teacher','InternalRegulationController@showForTeacher')->name('internal-regulations.teacher');
   Route::get('teacher/account','TeacherController@account')->name('teacher.account');
   Route::get('teacher/password','TeacherController@password')->name('teacher.password');

   // store vacation
   Route::post('teacher/vacation/store','TeacherController@storeVacation')->name('teacher.store-vacation');
   Route::post('teacher/permission/store','LeavePermissionController@storePermission')->name('teacher.store-permission');