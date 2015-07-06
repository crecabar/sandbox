<?php

/**
 * File definitions.php
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

define('DEFAULT_APP', 'frontend');
define('DEFAULT_MOD', 'default');
define('DEFAULT_LAYOUT', 'layout');
define('DEFAULT_ACTION', 'index');

define('MODULES_DIR', 'modulesDir');
define('LAYOUTS_DIR', 'layoutDir');
define('VIEWS_DIR', 'viewsDir');
define('ACTIONS_DIR', 'actionDir');
define('MODULES', 'modules');
define('LAYOUTS', 'layouts');
define('VIEWS', 'views');
define('ACTIONS', 'actions');