<?php
// Route helper function for all modules
/**
 * buildPrefix : return prefix related to module
 */
 function buildPrefix(string $moduleName)
 {
    return config($moduleName.'Route.moduleName').'/';
 }