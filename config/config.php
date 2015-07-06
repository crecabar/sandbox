<?php

/**
 * File config.php
 *
 * Construct the application configuration based on directories
 * founds under $appDir.
 *
 * PHP version 5
 *
 * @category PHP
 * @package  Nopackage
 * @author   Cristian Recabarren <crecabar_cl@me.com>
 * @license  http://unlicense.org Unlicense
 * @link     https://github.com/crecabar/sandbox
 */

if (!defined('SECURE_APP')) {
    die("you should not be here"); 
}

// Utility functions
/**
 * Function getFiles:
 * It gets all the files on the given path
 * and construct an array with the structure. It is used
 * to get all the applications, modules, actions and views.
 *
 * @param string $path The path dir were get modules and actions
 *
 * @return array
 */
function getFiles($path)
{
    $files = scandir($path);
    $files = array_diff($files, array('.', '..'));
    $fileList = array();
    foreach ($files as $file) {
        if (strpos($file, '.')) {
            $fileName = explode('.', $file);
            $fileList[$fileName[0]] = $file;
        } else {
            $fileList[$file] = $file;
        }
    }
    return $fileList;

}

/**
 * Function loadLibs:
 * It gets all the libraries under $libPath and includes
 * them for their use on the application.
 *
 * @param string $libPath The path where look for functions library files
 *
 * @return void
 */
function loadLibs($libPath)
{
    $files = scandir($libPath);
    $files = array_diff($files, array('.', '..'));
    foreach ($files as $file) {
        include $libPath . $file;
    }
}
// End of utility functions


$appDir = __DIR__ . '/../app/';

// Getting the list of applications
$appList = getFiles($appDir);
$apps = array();
foreach ($appList as $key => $app) {
    $applicationPath = $appDir. $key . '/';
    $modulePath = $applicationPath . 'modules/';
    $layoutPath = $applicationPath . 'templates/';
    $modules = getFiles($modulePath);
    $layouts = getFiles($layoutPath);

    foreach ($modules as $module) {
        $actionsPath = $modulePath . $module . '/' . ACTIONS . '/';
        $viewsPath = $modulePath . $module . '/' . VIEWS . '/';
        $actions = getFiles($actionsPath);
        $views = getFiles($viewsPath);
        $m = array(
            'module' => $module,
            ACTIONS_DIR => $actionsPath,
            VIEWS_DIR => $viewsPath,
            ACTIONS => $actions,
            VIEWS => $views
        );
        $modules[$module] = $m;
    }

    $app = array(
        'name' => $key,
        'path' => $applicationPath,
        MODULES_DIR => $modulePath,
        LAYOUTS_DIR => $layoutPath,
        MODULES => $modules,
        LAYOUTS => $layouts,
    );

    $apps[$key] = $app;
}