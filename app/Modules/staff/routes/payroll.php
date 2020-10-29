<?php
Route::group(['namespace'=>'Payroll'],function(){
    
    Route::get('/payrolls/temporary-component','TemporaryComController@index')->name('temporary-component.index');
    Route::get('/payrolls/temporary-component/create','TemporaryComController@create')->name('temporary-component.create');
    Route::post('/payrolls/temporary-component/store','TemporaryComController@store')->name('temporary-component.store');
    Route::post('/payrolls/temporary-component/destroy','TemporaryComController@destroy')->name('temporary-component.destroy');

    // fixed-component
    Route::get('/payrolls/fixed-component','FixedComController@index')->name('fixed-component.index');
    Route::get('/payrolls/fixed-component/create','FixedComController@create')->name('fixed-component.create');
    Route::post('/payrolls/fixed-component/store','FixedComController@store')->name('fixed-component.store');
    Route::post('/payrolls/fixed-component/destroy','FixedComController@destroy')->name('fixed-component.destroy');

    // payrolls-sheets
    Route::get('/payrolls/payrolls-sheets','PayrollSheetController@index')->name('payrolls-sheets.index');
    Route::get('/payrolls/payrolls-sheets/create','PayrollSheetController@create')->name('payrolls-sheets.create');
    Route::post('/payrolls/payrolls-sheets/store','PayrollSheetController@store')->name('payrolls-sheets.store');
    Route::get('/payrolls/payrolls-sheets/edit/{id}','PayrollSheetController@edit')->name('payrolls-sheets.edit');
    Route::post('/payrolls/payrolls-sheets/update/{id}','PayrollSheetController@update')->name('payrolls-sheets.update');
    Route::post('/payrolls/payrolls-sheets/destroy','PayrollSheetController@destroy')->name('payrolls-sheets.destroy');
    Route::get('/payrolls/payrolls-sheets/add-employees/{id}','PayrollSheetController@addEmployeesPage')->name('payrolls-sheets.add-employees-page');
    Route::get('/payrolls/payrolls-sheets/all/employees/{id}','PayrollSheetController@employeesPayrollSheet')->name('payrolls-sheets.employees');
    Route::get('/payrolls/payrolls-sheets/employees/create/{id}','PayrollSheetController@addEmployeesToSheet')->name('payrolls-sheets.add-employees');
    Route::post('/payrolls/payrolls-sheets/employees/store','PayrollSheetController@storeEmployeeIntoSheet')->name('payrolls-sheets.store-employees');
    Route::post('/payrolls/payrolls-sheets/employees/remove','PayrollSheetController@removeEmployeeFromSheet')->name('payrolls-sheets.remove-employees');

    // payroll process
    Route::get('/payrolls/payroll-process','PayrollProcessController@index')->name('payroll-process.index');
    Route::get('/payrolls/payroll-process/create','PayrollProcessController@create')->name('payroll-process.create');
    Route::post('/payrolls/payroll-process/store','PayrollProcessController@store')->name('payroll-process.store');

});