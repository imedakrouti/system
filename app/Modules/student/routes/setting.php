<?php
    /**
     * Year
     */
    Route::resource('/years','YearController')->except('show','destroy');
    Route::post('years/destroy','YearController@destroy')->name('years.destroy');