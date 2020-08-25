<?php
    /**
     * Year
     */
    Route::resource('/years','YearController')->except('show','destroy');
    Route::post('years/destroy','YearController@destroy')->name('years.destroy');
    Route::get('get/years','YearController@getYears')->name('get.years');
    Route::put('years/selected','YearController@getYearSelected')->name('year.selected');

    /**
     * Division
     */
    Route::resource('/divisions','DivisionController')->except('show','destroy');
    Route::post('divisions/destroy','DivisionController@destroy')->name('divisions.destroy');
    Route::get('get/divisions','DivisionController@getDivisions')->name('get.divisions');
    Route::put('division/selected','DivisionController@getDivisionSelected')->name('division.selected');    

    /**
     * Grade
     */
    Route::resource('/grades','GradeController')->except('show','destroy');
    Route::post('grades/destroy','GradeController@destroy')->name('grades.destroy');
    Route::get('get/grades','GradeController@getGrades')->name('get.grades');
    Route::put('grade/selected','GradeController@getGradeSelected')->name('grade.selected');    
    
    /**
     * Admission Documents
     */
    Route::resource('/admission-documents','AdmissionDocController')->except('show','destroy');
    Route::post('admission-documents/destroy','AdmissionDocController@destroy')->name('admission-documents.destroy');    
    
    /**
     * Documents Grades
     */
    Route::resource('/documents-grades','DocGradesController')->except('show','destroy');
    Route::post('documents-grades/destroy','DocGradesController@destroy')->name('documents-grades.destroy');        
    Route::put('documents/grades/filter','DocGradesController@filterByGrade')->name('documents-grades.filter');    
    /**
     * Admission Steps
     */
    Route::resource('/steps','AdmissionStepsController')->except('show','destroy');
    Route::post('steps/destroy','AdmissionStepsController@destroy')->name('steps.destroy');   
    
    /**
     * Acceptance Test
     */
    Route::resource('/acceptance-tests','AcceptanceTestController')->except('show','destroy');
    Route::post('acceptance-tests/destroy','AcceptanceTestController@destroy')->name('acceptance-tests.destroy');     