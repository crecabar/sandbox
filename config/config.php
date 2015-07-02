<?php

if (!defined('SECURE_APP'))
    die("you should not be here");

// Define the default application
$appDir = __DIR__ . '/../app/';

$apps = array(
    'frontend' => array(
        'name' => 'frontend',
        'dir' => $appDir . 'frontend/',
        MODULES_DIR => $appDir . 'frontend/modules/',
        MODULES => array(
            'index' => 'index.php',
            'hello' => 'hello.php'
        ),
        LAYOUTS_DIR => $appDir . 'frontend/templates/',
        LAYOUTS => array(
            'layout' => 'layout.php'
        )
    )
);
