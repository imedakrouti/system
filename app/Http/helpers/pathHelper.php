<?php
// system seprator
function DS()
{
    return DIRECTORY_SEPARATOR;
}
// get module name
function getModuleName(string $modileName)
{
    return app_path() . DS() . 'Modules'.DS() . $modileName . DS();
}
// load file configuration
function loadFileConfiguration(string $fileName,string $modileName)
{
    return getModuleName($modileName).'Config'.DS(). $fileName .'.php';
}
function loadRoute(string $fileName,string $modileName)
{
    return getModuleName($modileName).'routes'.DS(). $fileName .'.php';
}
function loadViews(string $modileName)
{
    return getModuleName($modileName).'resources'.DS().'views';
}
function loadMigrations(string $modileName)
{
    return getModuleName($modileName).'database'.DS().'migrations';
}
function loadTranslation(string $modileName)
{    
    return getModuleName($modileName).'resources'.DS().'lang';
}
function getNamespaceController(string $modileName)
{
    return ucfirst($modileName).'\Http\Controllers';
}
