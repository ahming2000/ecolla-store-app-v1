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

    public static function isExisted($arr, $element){
        foreach($arr as $a){
            if($a === $element){
                return true;
            } else{
                return false;
            }
        }
    }

    public static function generateSolidBackground(){
        // Get height and width of the image
        // Generate solid background (black)
        // Invert the color
        // Return img file path or return img file
    }

    public static function cropImageToSquare(){
        // Two option: add frame or crop directly
        // Recieve optimized source image and white background with same size of source image
    }

    public static function optimizeImage($imgPath, $orgFileExtention){
        $img = imagecreatefromjpeg($imgPath.".".$orgFileExtention);
        imagejpeg ($img, $imgPath.".jpg", 75);
    }

    public static function uploadReceipt($filePtr, $orderId){
        // To-do: if it is jpg file, convert to png file
        echo UsefulFunction::upload($filePtr, "assets/images/orders/", $orderId);
        UsefulFunction::optimizeImage("assets/images/orders/".$orderId, strtolower(pathinfo($filePtr["name"], PATHINFO_EXTENSION)));
    }

    public static function uploadItemImage(){

        // Get image heigh and width
        // Generate white background
        // crop image to square and combine with white background


        // upload
        // optimize the immage
    }

    public static function upload($filePtr, $targetDIR, $fileName){
        $imageFileType = strtolower(pathinfo($filePtr["name"], PATHINFO_EXTENSION));
        $fullPath = $targetDIR.$fileName.".".$imageFileType;

        //Check is actual image or not
        if(!getimagesize($filePtr["tmp_name"])){
            return "请上传正确的图像！"; // Reference: https://www.php.net/manual/en/function.getimagesize.php
        }

        // Check file size
        if ($filePtr["size"] > 20000000) {
            echo "2";
            return "图像大小过大！"; // If file too large
        }

        // Allow certain file formats
        // if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        //   return "收据图像格式错误!";
        // }
        if($imageFileType != "jpg" && $imageFileType != "jpeg") {
          return "收据图像格式错误!";
        }

        // Upload file
        if (!move_uploaded_file($filePtr["tmp_name"], $fullPath)) {
            return "伺服器出错！请通过Whatapps联系客服来发送个人资料和单据。";
        }

        return "上传成功！";
    }

}

?>
