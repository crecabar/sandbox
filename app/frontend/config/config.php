<?php

/**
 * File config.php
 *
 * In application inner configuration, it can overwrite some general
 * configurations.
 *
 * PHP version 5
 *
 * @category PHP
 * @package  Nopackage
 * @author   Cristian Recabarren <crecabar_cl@me.com>
 * @license  http://unlicense.org Unlicense
 * @link     https://github.com/crecabar/sandbox
 */


if (!defined(SECURE_APP)) {
    die("you should not be here"); 
}

$appDir = __DIR__ . '/../../frontend';
