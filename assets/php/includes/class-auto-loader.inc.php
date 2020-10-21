<?php

spl_autoload_register('classAutoLoader');

function classAutoLoader($className){
    $path = "../assets/php/classes/";
    $extention = ".class.php";
    $fullPath = $path.$className.$extention;

    include_once $fullPath;
}

?>