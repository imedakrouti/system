<?php

// ========================================= CONFIGURATIONS ======================================
Config::set('auth.defaults.guard','web');
Config::set('auth.defaults.passwords','users');
// ========================================= END CONFIGURATIONS ==================================

Route::get('/', 'Admin\ClosureController@index');
 require 'student.php';

