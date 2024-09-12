<?php

// Simple PSR-4 autoloader

spl_autoload_register(function ($class) {
    $file = SOURCE_DIRECTORY . $class . '.php';

    $file = str_replace('\\', '/', $file);

    if(file_exists($file)) {
        require $file;
    }
});

