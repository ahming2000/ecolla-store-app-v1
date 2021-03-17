<?php

class UsefulFunction{

    public static function removeArrayElementE($array, $element){

        // Unset the selected element to remove
        for($i = 0; $i < sizeof($array); $i++){
            if($array[$i] === $element){ //Compare object
                unset($array[$i]); // This function will break the array with hole (discontinued key value)
                break;
            }
        }

        // Rearrange to fix discountinued key value
        $newArray = array();
        foreach($array as $e){
            array_push($newArray, $e);
        }

        return $newArray;
    }

    public static function removeArrayElementI($array, $index){

        // Unset the selected element to remove
        unset($array[$index]); // This function will break the array with hole (discontinued key value)

        // Rearrange to fix discountinued key value
        $newArray = array();
        foreach($array as $e){
            array_push($newArray, $e);
        }

        return $newArray;
    }

    public static function startsWith ($string, $startString) {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }

    public static function arrayIndexRearrage($arr){
        $new = array();
        foreach($arr as $a){
            array_push($new, $a);
        }
        return $new;
    }

    public static function isExisted($arr, $element){
        foreach($arr as $a){
            if($a === $element){
                return true;
            } else{
                return false;
            }
        }
    }

    public static function createItemPage($data){
        $newPHPFile = fopen("../items/$data->name.php", "w") or die("创建商品页面错误！<br>错误代码：Error when creating php file");

        if(!fwrite($newPHPFile, $data->html_markup)) return false;

        fclose($newPHPFile);

        return true;
    }

    // Rearrage file pointer array to better way, only applicable to php $_FILES
    public static function reArrayFiles(&$file_post) {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
    }

    public static function generateAlert($msg) {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }

    public static function getCurrentURL(){
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $header = "https://";
   else
        $header = "http://";

        $url = $header . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
        $url = str_replace("\\", "/", $url);
        return $url;
    }

}

?>
