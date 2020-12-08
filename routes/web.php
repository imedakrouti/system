<?php

// ========================================= CONFIGURATIONS ======================================
Config::set('auth.defaults.guard','web');
Config::set('auth.defaults.passwords','users');
// ========================================= END CONFIGURATIONS ==================================

Route::get('/', 'HomeController@index')->name('home');

    // student routes
require 'student-routes/login.php';
require 'student-routes/dashboard.php';
require 'student-routes/subject.php';
require 'student-routes/homework.php';
require 'student-routes/exam.php';
require 'student-routes/virtual_classroom.php';

