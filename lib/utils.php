<?php

if (!defined('SECURE_APP'))
    die("you should not be here");

/**
 * @param $config
 * @param $key
 * @return bool
 */
function appExists($config, $key)
{
    return array_key_exists($key, $config);
}

/**
 * @param $module
 * @param $action
 * @return bool
 */
function actionExists($module, $action)
{
    return array_key_exists($action, $module[ACTIONS]);
}

/**
 * @param $module
 * @param $action
 * @return bool
 */
function viewExists($module, $action)
{
    return array_key_exists($action, $module[VIEWS]);
}

/**
 * @param $app
 * @param $module
 * @return bool
 */
function moduleExists($app, $module)
{
    return array_key_exists($module, $app[MODULES]);
}

/**
 * @param array $app
 * @return bool
 */
function appHasLayout($app)
{
    return array_key_exists(LAYOUTS, $app);
}

/**
 * @param array $app
 * @return array
 */
function getAppModules($app)
{
    return $app[MODULES];
}

/**
 * @param array $app
 * @return array
 */
function getAppLayouts($app)
{
    return $app[LAYOUTS];
}

/**
 * @param array$app
 * @return string
 */
function getAppLayoutDir($app)
{
    return $app[LAYOUTS_DIR];
}

/**
 * @param array $app
 * @return string
 */
function getAppModuleDir($app)
{
    return $app[MODULES_DIR];
}

/**
 * @param array $app
 * @param string $module
 * @param array $param
 * @param string $layout
 * @return string
 */
function render($app, array $param = [], $layout = DEFAULT_LAYOUT)
{
    $lytPath = getAppLayoutDir($app) . $app[LAYOUTS][$layout];

    $content = renderReal($lytPath, $param);

    return $content;
}

/**
 * @param array $module
 * @param string $action
 * @param array $param
 * @return string
 */
function renderAction($module, $action, array $param = [])
{
    if (!actionExists($module, $action))
        return "Action not exists";

    $actionPath = $module[ACTIONS_DIR];
    $viewPath = $module[VIEWS_DIR];
    $actionFile = $actionPath . $module[ACTIONS][$action];
    $viewFile = $viewPath . $module[VIEWS][$action];

    return renderReal($viewFile, $param, $actionFile);
}

/**
 * @param string $viewFile
 * @param array $param
 * @param string $actionFile
 * @return string
 */
function renderReal($viewFile, array $param = [], $actionFile = null)
{
    if (file_exists($viewFile)) {
        if (!is_null($actionFile))
            include $actionFile;

        extract($param);
        ob_start();
        include($viewFile);
        return ob_get_clean();
    }
    else {
        return "Resource " . $viewFile . " not found.";
    }
}