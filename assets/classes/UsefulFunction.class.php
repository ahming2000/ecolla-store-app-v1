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

    public static function isExisted($arr, $element){
        foreach($arr as $a){
            if($a === $element){
                return true;
            } else{
                return false;
            }
        }
    }

    public static function cropImageToSquare($imgPath, $mode){

        $info = GetImageSize($imgPath);
        $width = $info[0];
        $height = $info[1];
        $mime = $info['mime'];

        if($width == $height) {
            return;
        } else{

            $type = substr(strrchr($mime, '/'), 1);

            switch ($type){
                case 'jpeg':
                $image_create_func = 'ImageCreateFromJPEG';
                $image_save_func = 'ImageJPEG';
                $new_image_ext = 'jpg';
                break;

                case 'png':
                $image_create_func = 'ImageCreateFromPNG';
                $image_save_func = 'ImagePNG';
                $new_image_ext = 'png';
                break;

                case 'bmp':
                $image_create_func = 'ImageCreateFromBMP';
                $image_save_func = 'ImageBMP';
                $new_image_ext = 'bmp';
                break;

                case 'gif':
                    $image_create_func = 'ImageCreateFromGIF';
                    $image_save_func = 'ImageGIF';
                    $new_image_ext = 'gif';
                    break;

                    case 'vnd.wap.wbmp':
                    $image_create_func = 'ImageCreateFromWBMP';
                    $image_save_func = 'ImageWBMP';
                    $new_image_ext = 'bmp';
                    break;

                    case 'xbm':
                    $image_create_func = 'ImageCreateFromXBM';
                    $image_save_func = 'ImageXBM';
                    $new_image_ext = 'xbm';
                    break;

                    default:
                    $image_create_func = 'ImageCreateFromJPEG';
                    $image_save_func = 'ImageJPEG';
                    $new_image_ext = 'jpg';
                }

                if($width > $height){ // Horizontal Rectangle?
                    $x_pos = ($width - $height) / 2;
                    $x_pos = ceil($x_pos);

                    $y_pos = 0;
                } else if($height > $width) {// Vertical Rectangle?
                    $x_pos = 0;

                    $y_pos = ($height - $width) / 2;
                    $y_pos = ceil($y_pos);
                }


                switch($mode){
                    case 'frame':
                    if($width > $height){ // Horizontal Rectangle?
                        $new_width = $width;
                        $new_height = $width;
                    }
                    else if($height > $width){ // Vertical Rectangle?
                        $new_width = $height;
                        $new_height = $height;
                    }
                    break;

                    case 'crop':
                    if($width > $height){ // Horizontal Rectangle?
                        $new_width = $height;
                        $new_height = $height;
                    }
                    else if($height > $width){ // Vertical Rectangle?
                        $new_width = $width;
                        $new_height = $width;
                    }

                    break;

                    default:
                }
                $image = $image_create_func($imgPath);

                $new_image = ImageCreate($new_width, $new_height);
                $new_image = imagecolorallocate($new_image, 255, 255, 255);

                // Crop to Square using the given dimensions
                switch($mode){
                    case 'frame':
                    ImageCopy($new_image, $image, 0, 0, -$y_pos, -$x_pos, $new_width, $new_height);

                    // $white = imagecolorallocate($new_image, 255, 255, 255);
                    // if($width > $height){
                    //     ImageFilledRectangle($new_image, 0, 0, $width, $y_pos, $white);
                    //     ImageFilledRectangle($new_image, 0, 0 + $y_pos + $height, $width, $y_pos + $y_pos + $height, $white);
                    // }else if($height > $width){
                    //     ImageFilledRectangle($new_image, 0, 0, $x_pos, $height, $white);
                    //     ImageFilledRectangle($new_image, 0 + $x_pos + $height, 0, $x_pos + $x_pos + $height, $height, $white);
                    // }
                    break;

                    case 'crop':
                    ImageCopy($new_image, $image, 0, 0, $x_pos, $y_pos, $width, $height);
                    break;
                }

                // Save image
                $process = $image_save_func($new_image, $imgPath) or die("There was a problem in saving the new file.");
            }
        }

        public static function optimizeImage($imgPath, $orgFileExtention){
            $img = imagecreatefromjpeg($imgPath.".".$orgFileExtention);
            imagejpeg ($img, $imgPath.".jpg", 75);
        }

        public static function uploadReceipt($filePtr, $orderId){
            // To-do: if it is other image file, convert to jpg file
            echo UsefulFunction::upload($filePtr, "assets/images/orders/", $orderId);
            UsefulFunction::optimizeImage("assets/images/orders/".$orderId, strtolower(pathinfo($filePtr["name"], PATHINFO_EXTENSION)));
        }

        public static function uploadItemImage($filePtr, $o_id, $fileName, $mode){
            // To-do: if it is other image file, convert to jpg file
            $dir =  "assets/images/items/".$o_id."/";
            $fullPath = $dir.$fileName;

            UsefulFunction::upload($filePtr, $dir, $fileName);
            UsefulFunction::optimizeImage($fullPath, strtolower(pathinfo($filePtr["name"], PATHINFO_EXTENSION)));
            UsefulFunction::cropImageToSquare($fullPath, $mode);

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
