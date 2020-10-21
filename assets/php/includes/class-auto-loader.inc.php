<?php

/*
 * Reference: https://www.youtube.com/watch?v=z3pZdmJ64jo&list=PL0eyrZgxdwhypQiZnYXM7z7-OTkcMgGPh&index=9
 */

spl_autoload_register('classAutoLoader');

function classAutoLoader($className){
    $path = "assets/php/classes/";
    $extention = ".class.php";
    $fullPath = $path.$className.$extention;

    if(!file_exists($fullPath)){ return false; }

    include_once $fullPath;
}

?>