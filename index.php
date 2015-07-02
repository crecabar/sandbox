<?php

// Generic functions
// Function render, it renders the content of a php file and 
// return the results into the main script
function render($module, $data = array())
{
    $path = __DIR__ . "/" . $module;
    if (file_exists($path)) {
        extract($data);
        ob_start();
        include $path;
        return ob_get_clean();
    }
    else {
        return "Resource module " . $path . " not found.";
    }
}

// End of generic functions


// Main script, it reads the parameters passed by the user and contains
// all the application logic.
$module = filter_input(INPUT_GET, 'module');

echo "Hello world, first controller.<br>";

if (!empty($module)) {
    $name = filter_input(INPUT_GET, 'name') ? : "";
    echo render($module, ['name' => $name]);
}

