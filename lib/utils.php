<?php

/**
 * File utils.php
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

/**
 * Function appExists:
 * It checks if the given application exists on the configuration.
 *
 * @param array  $config Configuration array.
 * @param string $key    Key to search for in configuration.
 *
 * @return bool
 */
function appExists($config, $key)
{
    return array_key_exists($key, $config);
}

/**
 * Function actionExists:
 * It checks if the given action exists on the given module.
 *
 * @param array  $module Module in which look for.
 * @param string $action Action to search for in Module.
 *
 * @return bool
 */
function actionExists($module, $action)
{
    return array_key_exists($action, $module[ACTIONS]);
}

/**
 * Function viewExists:
 * It checks if the given action has a view, if not returns false.
 *
 * @param array  $module Module in which look for.
 * @param string $action Action to check if view exists.
 *
 * @return bool
 */
function viewExists($module, $action)
{
    return array_key_exists($action, $module[VIEWS]);
}

/**
 * Function moduleExists:
 * It checks if the given module exists on the given application.
 *
 * @param array  $app    The application in where look for.
 * @param string $module The module to search for.
 *
 * @return bool
 */
function moduleExists($app, $module)
{
    return array_key_exists($module, $app[MODULES]);
}

/**
 * Function appHasLayout:
 * It checks if the given application has a layout.
 *
 * @param array $app The application in where look for.
 *
 * @return bool
 */
function appHasLayout($app)
{
    return array_key_exists(LAYOUTS, $app);
}

/**
 * Function getAppModules:
 * Returns all application modules.
 *
 * @param array $app The application for look into.
 *
 * @return array
 */
function getAppModules($app)
{
    return $app[MODULES];
}

/**
 * Function getAppLayouts:
 * Returns all application layouts.
 *
 * @param array $app The application for look into.
 *
 * @return array
 */
function getAppLayouts($app)
{
    return $app[LAYOUTS];
}

/**
 * Function getAppLayoutDir:
 * Returns application's layouts path.
 *
 * @param array $app The application for look into.
 *
 * @return string
 */
function getAppLayoutDir($app)
{
    return $app[LAYOUTS_DIR];
}

/**
 * Function getAppModuleDir:
 * Returns application's module path.
 *
 * @param array $app The application for look into.
 *
 * @return string
 */
function getAppModuleDir($app)
{
    return $app[MODULES_DIR];
}

/**
 * Function render:
 * Renders the current application.
 *
 * @param array  $app    The application for look into.
 * @param array  $param  The list of params in the url, or post data.
 * @param string $layout If the application has no default layout, or if
 *                       there is some need to change the layout, it is possible
 *                       by passing this argument.
 *
 * @return string
 */
function render($app, array $param = [], $layout = DEFAULT_LAYOUT)
{
    $lytPath = getAppLayoutDir($app) . $app[LAYOUTS][$layout];

    $content = renderReal($lytPath, $param);

    return $content;
}

/**
 * Function renderAction:
 * Renders current action, it runs after render the application.
 *
 * @param array  $module The module where to render the action.
 * @param string $action The action to render.
 * @param array  $param  The list of parameters.
 *
 * @return string
 */
function renderAction($module, $action, array $param = [])
{
    if (!actionExists($module, $action)) {
        return "Action not exists"; 
    }

    $actionPath = $module[ACTIONS_DIR];
    $viewPath = $module[VIEWS_DIR];
    $actionFile = $actionPath . $module[ACTIONS][$action];
    $viewFile = $viewPath . $module[VIEWS][$action];

    return renderReal($viewFile, $param, $actionFile);
}

/**
 * Function renderReal:
 * "Private" function that renders the given file with the given params, also,
 * if has to mix the output of an action, it renders first the action and then
 * pass the result to the view.
 *
 * @param string $viewFile   The view file to render.
 * @param array  $param      The list of parameters to use in the view, or action.
 * @param string $actionFile If given, the action file to process after the view.
 *
 * @return string
 */
function renderReal($viewFile, array $param = [], $actionFile = null)
{
    if (file_exists($viewFile)) {
        extract($param);
        if (!is_null($actionFile)) {
            include $actionFile; 
        }
        ob_start();
        include $viewFile;
        return ob_get_clean();
    } else {
        return "Resource " . $viewFile . " not found.";
    }
}