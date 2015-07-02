<?php

require_once __DIR__ . '/../config/definitions.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../lib/utils.php';

if (!defined('SECURE_APP'))
    die('You should not be here');

$app = filter_input(INPUT_GET, 'app') ? : DEFAULT_APP;
$module = filter_input(INPUT_GET, 'module') ? : DEFAULT_MOD;

if (appExists($apps, $app)) {
    $name = filter_input(INPUT_GET, 'name') ?: "";
    $params = array('name' => $name);

    echo render($apps[$app], $module, $params);
}
else {
    echo "Application " . $app . " not exists";
}
