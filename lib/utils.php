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
    if (array_key_exists($key, $config)) {
        return true;
    }
    else {
        return false;
    }
}

/**
 * @param $app
 * @param $module
 * @return bool
 */
function moduleExists($app, $module)
{
    if (array_key_exists($module, $app[MODULES]))
        return true;
    else
        return false;
}

/**
 * @param $app
 * @return bool
 */
function appHasLayout($app)
{
    if (array_key_exists(LAYOUTS, $app))
        return true;
    else
        return false;
}

/**
 * @param $app
 * @return mixed
 */
function getAppModules($app)
{
    return $app[MODULES];
}

/**
 * @param $app
 * @return mixed
 */
function getAppLayouts($app)
{
    return $app[LAYOUTS];
}

/**
 * @param $app
 * @return mixed
 */
function getAppLayoutDir($app)
{
    return $app[LAYOUTS_DIR];
}

/**
 * @param $app
 * @return mixed
 */
function getAppModuleDir($app)
{
    return $app[MODULES_DIR];
}

/**
 * @param $app
 * @param string $module
 * @param array $param
 * @param string $layout
 * @return string
 */
function render($app, $module = DEFAULT_MOD, array $param = [], $layout = DEFAULT_LYOUT)
{
    if (!moduleExists($app, $module))
        return "Module " . $module . " not exists";

    $modPath = getAppModuleDir($app) . $app[MODULES][$module];
    $lytPath = getAppLayoutDir($app) . $app[LAYOUTS][$layout];

    $content = renderReal($modPath, $param);
    $content = renderReal($lytPath, array('content' => $content));

    return $content;
}

/**
 * @param $path
 * @param array $param
 * @return string
 */
function renderReal($path, array $param = [])
{
    if (file_exists($path)) {
        extract($param);
        ob_start();
        include $path;
        return ob_get_clean();
    }
    else {
        return "Resource " . $path . " not found.";
    }
}