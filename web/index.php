<?php

require_once __DIR__ . '/../config/secure.php';
require_once __DIR__ . '/../config/definitions.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../lib/utils.php';

if (!defined('SECURE_APP'))
    die('You should not be here');

$app = filter_input(INPUT_GET, 'app') ? : DEFAULT_APP;
$module = filter_input(INPUT_GET, 'module') ? : DEFAULT_MOD;
$action = filter_input(INPUT_GET, 'action') ? : DEFAULT_ACTION;

$content = "";

if (appExists($apps, $app)) {
    if (moduleExists($apps[$app], $module)) {
        if (actionExists($apps[$app][MODULES][$module], $action)) {
            $content .= renderAction($apps[$app][MODULES][$module], $action);
        }
        else {
            $content .= "Action " . $action . " not exists";
        }
    }
    else {
        $content .= "Module " . $module . " not exists";
    }
    $content = render($apps[$app], array('content' => $content));
}
else {
    $content = "Application " . $app . " not exists";
}

echo $content;
