<?php

if (@$upperDirectoryCount == null) $upperDirectoryCount = 0;

if($upperDirectoryCount == 1){
    spl_autoload_register('classAutoLoaderSingle');
} else if($upperDirectoryCount == 2){
    spl_autoload_register('classAutoLoaderDouble');
}else{
    spl_autoload_register('classAutoLoader');
}

/*
 * Reference: https://www.youtube.com/watch?v=z3pZdmJ64jo&list=PL0eyrZgxdwhypQiZnYXM7z7-OTkcMgGPh&index=9
 */

function classAutoLoader($className){
    $path = "assets/php/classes/";
    $extention = ".class.php";
    $fullPath = $path.$className.$extention;

    if(!file_exists($fullPath)){ return false; }

    include_once $fullPath;
}

function classAutoLoaderSingle($className){
    $path = "../assets/php/classes/";
    $extention = ".class.php";
    $fullPath = $path.$className.$extention;

    if(!file_exists($fullPath)){ return false; }

    include_once $fullPath;
}

function classAutoLoaderDouble($className){
    $path = "../../assets/php/classes/";
    $extention = ".class.php";
    $fullPath = $path.$className.$extention;

    if(!file_exists($fullPath)){ return false; }

    include_once $fullPath;
}

?>
