<?php

class UsefulFunction{
    public static function removeArrayElementE($array, $element){
        //Get the index of the element that require to remove
        for($i = 0; $i < sizeof($array); $i++){
            if(is_null($value)){
                $index = $i;
                break;
            }
        }
        //Delete the element from array (will left a null space)
        $array = array_diff($array, $element); 
        //Copy the array part after the null space to the end
        $arrayAfterElement = array_slice($array, $index + 1, length($array)); 
        //Replace the array element (from null space to the last element) with elements after null space
        array_splice($array, $index, length($array), $arrayAfterElement);
        return $array; //To do (Debug): if the array do not change by using array_splice(), need to address the result using return
    }

    public static function removeArrayElementI($array, $index){
        //Track back the array element
        $element = $array[$index];
        //Delete the element from array (will left a null space)
        $array = array_diff($array, $element); 
        //Copy the array part after the null space to the end
        $arrayAfterElement = array_slice($array, $index + 1, length($array)); 
        //Replace the array element (from null space to the last element) with elements after null space
        array_splice($array, $index, length($array), $arrayAfterElement);
        return $array; //To do (Debug): if the array do not change by using array_splice(), need to address the result using return
    }

    public static function startsWith ($string, $startString) { 
        $len = strlen($startString); 
        return (substr($string, 0, $len) === $startString); 
    } 
}

?>