<?php

/**
 * File index.php
 *
 * Front controller for sandbox tutorial, it loads the definitions, configs
 * and libraries, also gets the application requested on the url, the module
 * and the action to perform.
 *
 * PHP version 5
 *
 * @category PHP
 * @package  Nopackage
 * @author   Cristian Recabarren <crecabar_cl@me.com>
 * @license  http://unlicense.org Unlicense
 * @link     https://github.com/crecabar/sandbox
 */

require_once __DIR__ . '/../config/secure.php';
require_once __DIR__ . '/../config/definitions.php';
require_once __DIR__ . '/../config/config.php';
loadLibs(__DIR__ . '/../lib/');

if (!defined('SECURE_APP')) {
    die('You should not be here'); 
}

$app = filter_input(INPUT_GET, 'app') ? : DEFAULT_APP;
$module = filter_input(INPUT_GET, 'module') ? : DEFAULT_MOD;
$action = filter_input(INPUT_GET, 'action') ? : DEFAULT_ACTION;

$content = "";

if (appExists($apps, $app)) {
    if (moduleExists($apps[$app], $module)) {
        if (actionExists($apps[$app][MODULES][$module], $action)) {
            $content .= renderAction($apps[$app][MODULES][$module], $action);
        } else {
            $content .= "Action " . $action . " not exists";
        }
    } else {
        $content .= "Module " . $module . " not exists";
    }
    $content = render($apps[$app], array('content' => $content));
} else {
    $content = "Application " . $app . " not exists";
}

echo $content;
