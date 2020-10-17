<?php
// Sectors
Route::resource('sectors','SectorController')->except('show','destroy');
Route::post('sectors/destroy','SectorController@destroy')->name('sectors.destroy');
