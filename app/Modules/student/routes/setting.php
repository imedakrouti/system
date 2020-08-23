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