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

// Documents
Route::resource('documents','DocumentController')->except('show','destroy');
Route::post('documents/destroy','DocumentController@destroy')->name('documents.destroy');

// Skills
Route::resource('skills','SkillController')->except('show','destroy');
Route::post('skills/destroy','SkillController@destroy')->name('skills.destroy');

// Holidays
Route::resource('holidays','HolidayController')->except('show','destroy');
Route::post('holidays/destroy','HolidayController@destroy')->name('holidays.destroy');

Route::resource('holidays/holidays-days','HolidayDayController')->except('show','destroy','index','create','edit','update');
Route::get('holidays/holidays-days/index/{id}','HolidayDayController@index')->name('holidays-days.index');
Route::get('holidays/holidays-days/create/{id}','HolidayDayController@create')->name('holidays-days.create');
Route::put('holidays/holidays-days/get-days','HolidayDayController@getAllDays')->name('holidays-days.allDays');
Route::post('holidays/holidays-days/destroy','HolidayDayController@destroy')->name('holidays-days.destroy');

// LeaveTypes
Route::resource('leave-types','LeaveTypeController')->except('show','destroy');
Route::post('leave-types/destroy','LeaveTypeController@destroy')->name('leave-types.destroy');

// Machines
Route::resource('machines','MachineController')->except('show','destroy');
Route::post('machines/destroy','MachineController@destroy')->name('machines.destroy');

// Reports
Route::get('hr-letter/report-form','ReportController@hrLetter')->name('hr-letter.get');  
Route::post('hr-letter/report-form','ReportController@updateHrLetter')->name('hr-letter.update'); 

Route::get('employee-leave/report-form','ReportController@hrLeave')->name('employee-leave.get');  
Route::post('employee-leave/report-form','ReportController@updateLeave')->name('employee-leave.update');  

Route::get('employee-experience/report-form','ReportController@hrExperience')->name('employee-experience.get');  
Route::post('employee-experience/report-form','ReportController@updateHrExperience')->name('employee-experience.update');  

Route::get('employee-vacation/report-form','ReportController@hrVacation')->name('employee-vacation.get');  
Route::post('employee-vacation/report-form','ReportController@updateHrVacation')->name('employee-vacation.update');  

// External code
Route::resource('external-codes','ExternalCodeController')->except('show','destroy');
Route::post('external-codes/destroy','ExternalCodeController@destroy')->name('external-codes.destroy');

// Salary Components
Route::resource('salary-components','SalaryComponentController')->except('show','destroy');
Route::post('salary-components/destroy','SalaryComponentController@destroy')->name('salary-components.destroy');
