<?php

if (!defined('SECURE_APP'))
    die("you should not be here");

// Utility functions
/**
 * @param string $path
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
        }
        else {
            $fileList[$file] = $file;
        }
    }
    return $fileList;

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

    foreach ($modules as $module){
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