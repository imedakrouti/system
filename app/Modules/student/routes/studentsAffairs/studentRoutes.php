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
});
