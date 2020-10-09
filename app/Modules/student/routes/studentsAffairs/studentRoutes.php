<?php

Route::group(['namespace'=>'StudentsAffairs'],function(){
    // student statements
    Route::post('student/add-statement','StudentStatementsController@addToStatement')->name('statement.addStudent');
    Route::resource('statements','StudentStatementsController')->except('show','edit','destroy');
    Route::put('statements/filter/students','StudentStatementsController@filter')->name('statements.filter');
    Route::post('/statements/s/destroy','StudentStatementsController@destroy')->name('statements.destroy');   
    Route::post('/statements/s/store-to-statement','StudentStatementsController@storeToStatement')->name('statements.storeToStatement');   
    Route::post('/statements/s/restore','StudentStatementsController@restoreMigration')->name('statements.restore');   
    Route::get('/statements/s/statistics-report','StudentStatementsController@statisticsReport')->name('statistics.report');   
    Route::get('/statements/s/add-to-statement','StudentStatementsController@insertStatement')->name('statements.insert');   
    Route::get('/statements/s/print-statement','StudentStatementsController@printStatementReport')->name('statements.printStatement');   
    
    // set-migration
    Route::get('/set-migrations','SetMigrationController@index')->name('setMigration.index');   
    Route::post('/set-migrations/store','SetMigrationController@storeSetMigration')->name('setMigration.store');   
    Route::post('/set-migrations/del/destroy','SetMigrationController@destroy')->name('setMigration.destroy');   

    // Commissioner
    Route::resource('/commissioners','CommissionerController')->except('destroy');
    Route::post('commissioners/destroy','CommissionerController@destroy')->name('commissioners.destroy');   
    Route::get('commissioners/student/{id}','CommissionerController@student')->name('commissioners.student');   
    Route::get('commissioners/student/report/{id}','CommissionerController@studentReport')->name('student-report.print');  
    Route::get('commissioners/reports/print-all','CommissionerController@printAll')->name('commissioners.print-all');  

    
    Route::post('commissioners/store-students','CommissionerController@storeStudents')->name('commissioners-students.store');  
    Route::post('commissioners/destroy-students','CommissionerController@destroyStudents')->name('commissioners-students.destroy');  
    Route::get('commissioners/print-students/{id}','CommissionerController@printStudents')->name('commissioners-students.print');  

    // Distribution
    Route::get('distribution-students','DistributionController@index')->name('distribution.index');
    Route::put('distribution-students/get-grade-statistics','DistributionController@getGradeStatistics')->name('distribution.getGradeStatistics');
    Route::put('distribution-students/grade','DistributionController@allStudentsGrade')->name('distribution.allStudentsGrade');
    Route::post('distribution-students/join','DistributionController@joinToClassroom')->name('distribution.joinToClassroom');
    Route::post('distribution-students/remove','DistributionController@removeFromClassroom')->name('distribution.removeFromClassroom');
    Route::put('distribution-students/get-class-statistics','DistributionController@getClassStatistics')->name('distribution.getClassStatistics');
    Route::put('distribution-students/all/grade/lang','DistributionController@getLanguagesGrade')->name('distribution.getLanguagesGrade');
    Route::put('distribution-students/class/languages','DistributionController@getLanguagesClass')->name('distribution.getLanguagesClass');
    Route::get('distribution-students/name-list','DistributionController@nameListReport')->name('distribution.nameList');
    Route::post('distribution-students/move-to-class','DistributionController@moveToClass')->name('distribution.moveToClass');

    // Leave Requests
    Route::resource('/leave-requests','LeaveRequestController')->except('destroy','edit');
    Route::post('leave-requests/destroy','LeaveRequestController@destroy')->name('leave-requests.destroy');   
    Route::get('leave-requests/print/{id}','LeaveRequestController@printLeaveRequest')->name('leave-requests.print');   
    

    // Transfer
    Route::resource('/transfers','TransferController')->except('destroy','show');
    Route::post('transfers/destroy','TransferController@destroy')->name('transfers.destroy');   
    Route::get('transfers/print/{id}','TransferController@printTransferReport')->name('transfers.print');   
    Route::get('transfers/empty-print','TransferController@emptyTransferReport')->name('empty-transfers.print');   

    // Daily Requests
    Route::get('daily-requests/index','DailyRequestController@index')->name('daily-requests.index');
    Route::get('daily-requests/create','DailyRequestController@create')->name('daily-requests.create');
    Route::post('daily-requests/store','DailyRequestController@store')->name('daily-requests.store');
    Route::post('daily-requests/destroy','DailyRequestController@destroy')->name('daily-requests.destroy');
    Route::get('daily-requests/print/{id}','DailyRequestController@print')->name('daily-requests.print');
    Route::get('daily-requests/student/{id}','DailyRequestController@student')->name('daily-requests.student');   
    
    // Parent Requests
    Route::resource('/parent-requests','ParentRequestController')->except('destroy','show');
    Route::post('parent-requests/destroy','ParentRequestController@destroy')->name('parent-requests.destroy');       
    Route::get('parent-requests/print/{id}','ParentRequestController@printLeaveRequest')->name('parent-requests.print');   
    Route::get('parent-requests/student/{id}','ParentRequestController@student')->name('parent-requests.student');  
    
    //  Card
    Route::get('/student-cards','CardController@classroom')->name('student-cards.classroom');
    Route::put('/student-cards','CardController@getStudentCards')->name('get-student-cards');
    Route::get('/student-cards/all-students','CardController@allStudents')->name('cards.all-students');
    Route::get('/student-cards/selected-students','CardController@selectedStudents')->name('cards.selected-students');
    Route::get('/student-cards/class/no-photos','CardController@studentsNotPhotosClass')->name('cards.no-photos-class');
    Route::get('/student-cards/grade/no-photos','CardController@studentsNotPhotosGrade')->name('cards.no-photos-grade');
    

     // Absence
     Route::resource('/absences','AbsenceController')->except('destroy','show','edit','update');     
     Route::post('absences/destroy','AbsenceController@destroy')->name('absences.destroy');   
     Route::put('absences/filter','AbsenceController@filter')->name('absences.filter');  
     
    //  Reports
    /**
     * statistics
     */
    Route::get('/reports/statistics','ReportController@statistics')->name('reports.statistics');
    Route::get('/reports/statistics/second-lang-report','ReportController@secondLangReportStatistics')->name('statistics.second-lang');
    Route::get('/reports/statistics/register-status-report','ReportController@regStatusReportStatistics')->name('statistics.reg-status');
    Route::get('/reports/statistics/religion-report','ReportController@religionReportStatistics')->name('statistics.religion');

    /**
     * student-data
     */
    Route::get('/reports/student-data','ReportController@studentData')->name('reports.student-data');
    Route::get('/reports/students-contact-data','ReportController@studentsContactData')->name('students-contact-data');
    Route::get('/reports/students-second-lang','ReportController@studentsSecondLangData')->name('students-second-lang');
    Route::get('/reports/students-religion','ReportController@studentsReligionData')->name('students-religion');

    /**
     * period
     */
    Route::get('/reports/period','ReportController@period')->name('reports.period');
    Route::get('/reports/period-permissions','ReportController@permissions')->name('reports.permissions');
    Route::get('/reports/period-parent-requests','ReportController@parentRequests')->name('reports.parent-requests');
    Route::get('/reports/period-leave-requests','ReportController@leaveRequests')->name('reports.leave-requests');
    Route::get('/reports/period-transfers','ReportController@transfers')->name('reports.transfers');

    /**
     * Archive
     */
    Route::resource('/archives','ArchiveController')->except('destroy','show');
    Route::post('archives/destroy','ArchiveController@destroy')->name('archives.destroy');   
    Route::get('archives/student-files/{id}','ArchiveController@studentFiles')->name('archives.student-files');   
});
