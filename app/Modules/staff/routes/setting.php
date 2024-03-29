<?php
// Sectors
Route::resource('sectors','SectorController')->except('show','destroy');
Route::post('sectors/destroy','SectorController@destroy')->name('sectors.destroy');

// Departments
Route::resource('departments','DepartmentController')->except('show','destroy');
Route::post('departments/destroy','DepartmentController@destroy')->name('departments.destroy');
Route::put('departments/get/all','DepartmentController@getDepartmentsBySectorId')->name('getDepartmentsBySectorId');    
// Sections
Route::resource('sections','SectionController')->except('show','destroy');
Route::post('sections/destroy','SectionController@destroy')->name('sections.destroy');

// Positions
Route::resource('positions','PositionController')->except('show','destroy');
Route::post('positions/destroy','PositionController@destroy')->name('positions.destroy');

// Documents
Route::resource('documents','DocumentController')->except('show','destroy');
Route::post('documents/destroy','DocumentController@destroy')->name('documents.destroy');
Route::put('documents/get/selected','DocumentController@getDocumentsSelected')->name('getDocumentsSelected');    
// Skills
Route::resource('skills','SkillController')->except('show','destroy');
Route::post('skills/destroy','SkillController@destroy')->name('skills.destroy');
Route::put('skills/get/selected','SkillController@getSkillsSelected')->name('getSkillsSelected');    
// Holidays
Route::resource('holidays','HolidayController')->except('show','destroy');
Route::post('holidays/destroy','HolidayController@destroy')->name('holidays.destroy');
Route::put('holidays/get/selected','HolidayController@getHolidaysSelected')->name('getHolidaysSelected');    

Route::resource('holidays/holidays-days','HolidayDayController')->except('show','destroy','index','create','edit','update');
Route::get('holidays/holidays-days/index/{id}','HolidayDayController@index')->name('holidays-days.index');
Route::get('holidays/holidays-days/create/{id}','HolidayDayController@create')->name('holidays-days.create');
Route::put('holidays/holidays-days/get-days','HolidayDayController@getAllDays')->name('holidays-days.allDays');
Route::post('holidays/holidays-days/destroy','HolidayDayController@destroy')->name('holidays-days.destroy');

// LeaveTypes
Route::resource('leave-types','LeaveTypeController')->except('show','destroy');
Route::post('leave-types/destroy','LeaveTypeController@destroy')->name('leave-types.destroy');
Route::put('leave-types/get/selected','LeaveTypeController@getDaysSelected')->name('getDaysSelected');    

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

Route::get('employee-loan/report-form','ReportController@hrLoan')->name('employee-loan.get');  
Route::post('employee-loan/report-form','ReportController@updateHrLoan')->name('employee-loan.update');  

Route::get('header/report-form','ReportController@header')->name('header.get');  
Route::post('header/report-form','ReportController@updateHeader')->name('header.update');  

Route::get('footer/report-form','ReportController@footer')->name('footer.get');  
Route::post('footer/report-form','ReportController@updateFooter')->name('footer.update');  
// External code
Route::resource('external-codes','ExternalCodeController')->except('show','destroy');
Route::post('external-codes/destroy','ExternalCodeController@destroy')->name('external-codes.destroy');

// Salary Components
Route::resource('salary-components','SalaryComponentController')->except('show','destroy');
Route::post('salary-components/destroy','SalaryComponentController@destroy')->name('salary-components.destroy');
Route::put('salary-components/s/filter','SalaryComponentController@filter')->name('salary-components.filter');

// Timetable
Route::resource('timetables','TimetableController')->except('show','destroy');
Route::post('timetables/destroy','TimetableController@destroy')->name('timetables.destroy');


