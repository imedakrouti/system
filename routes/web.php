<?php

// ========================================= CONFIGURATIONS ======================================
Config::set('auth.defaults.guard','web');
Config::set('auth.defaults.passwords','users');
// ========================================= END CONFIGURATIONS ==================================

Route::get('/', 'HomeController@index')->name('home');
 require 'student.php';

