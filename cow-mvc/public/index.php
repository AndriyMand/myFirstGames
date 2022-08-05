<?php

// Go one dir up
chdir(dirname(__DIR__));

// Autoloading
spl_autoload_register(function ($class) {
    include "./src/$class.php";
});

$local  = include('./config/local.php');
$global = include('./config/global.php');

// Application run
echo Cow006\Application::run($local + $global);
