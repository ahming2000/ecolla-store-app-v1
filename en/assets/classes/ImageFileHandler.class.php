<?php

/*
    Special library required for this class
    Please make sure you have enable extension gd2 and imagick

    Guideline on installing and enable extension
    gd2: https://www.php.net/manual/en/image.installation.php
    imagick: https://www.php.net/manual/en/imagick.installation.php

    Basic step:
    1. You need to implement in php.ini which add "extension={extension name}" into dynamic extension section
    2. You need to download the dll file from https://pecl.php.net/package/ and place it in php "ext" directory
    3. Restart the server to make changes, you may check it with phpinfo() function

    For Wamp64,
    Since gd2 is pre-installed and pre-enable, so only need to install imagick
    Step 1: Download ImageMagick from http://www.imagemagick.org/script/download.php.
    Step 2: Install it at C:\imagemagick with "Add application directory to your system path" ticked.
    Step 3: Go to Control Panel -> System -> Advanced Settings -> Environment Variables -> New System Variable -> MAGICK_HOME = C:\imagemagick
    Step 4: Copy all files from C:\imagemagick\modules\coders and C:\imagemagick\modules\filters to C:\imagemagick to load ImageMagick supported formats
    Step 5: Check x64 or x86 and thread safe enable or disable from phpinfo()
    Step 6: Download correct version of dll files zip from https://pecl.php.net/package/imagick/3.4.4/windows
    Step 7: Extract and copy php_imagick.dll to C:\wamp\bin\php\{selected php version}\ext\
    Step 8: Copy all dll files (*.dll) to C:\wamp\bin\apache\{selected apache version}\bin\
    Step 9: Edit php.ini by left click wamp64 icon and choose php, php.ini to promt out the editor.
    Step 10: Add "extension=php_imagick.dll" line in extensions section

    Reference:
    https://stackoverflow.com/questions/2942523/step-by-step-instructions-for-installing-imagemagick-on-wamp

 */

class ImageFileHandler{

    // Constant
    private $RECEIPT_IMG_PATH = "assets/images/orders/";
    private $ITEM_IMG_PATH = "../assets/images/items/";

    // Variable
    private $filePtrs;

    // Variable with default value
    private $i_id; // For item image use only // Default: ""

    // Operation flag (Default: true)
    private $optimize;

    public function __construct($filePtrs, $i_id = "", $optimize = true){
        $this->filePtrs = $filePtrs;

        $this->i_id = $i_id;

        $this->optimize = $optimize;
    }

    public function uploadReceipt($fileName){
        if ($this->i_id != "") die("文件上传错误<br>错误代码：Not allow to upload receipt when item ID is not blank");

        $path = $this->RECEIPT_IMG_PATH;
        $extension = pathinfo(basename($this->filePtrs["name"]), PATHINFO_EXTENSION);

        $this->upload($path, $this->filePtrs, $fileName, $extension);
        $this->toJPG($path, $fileName, $extension);
    }

    public function uploadItemGeneralImage($cropMode = "crop"){
        if ($this->i_id == "") die("文件上传错误<br>错误代码：Item ID is blank");

        $path = $this->ITEM_IMG_PATH . "$this->i_id/";

        $currentImageCount = 0;
        $MAX_COUNT = 8;

        foreach($this->filePtrs as $filePtr){

            $extension = pathinfo(basename($filePtr["name"]), PATHINFO_EXTENSION);

            // Check if the file pointer is not blank or default value
            if($filePtr["name"] != "" and $filePtr["name"] != "image-upload-alt.png"){

                // Check the image is existed image or new uploaded image
                // (existed image cannot pass the image validation with getimagesize function)
                if(@getimagesize($filePtr["tmp_name"]) != null){
                    $this->upload($path, $filePtr, $currentImageCount, $extension);
                    $this->toJPG($path, $currentImageCount, $extension);
                    $this->cropImageToSquare($path, $currentImageCount, $cropMode);
                } else{
                    // Rename the file name to smaller (move image naming count forward)
                    $fileName = basename($filePtr["name"]);
                    if($fileName != $currentImageCount . ".jpg") rename($path . $fileName, $path . $currentImageCount . ".jpg");
                }

                $currentImageCount++;

            }
        }

        // Delete the remaining image
        for($i = $currentImageCount; $i <= $MAX_COUNT; $i++){
            $this->deleteImage($i);
        }

    }

    public function uploadItemVarietyImage($oldBarcodeList, $newBarcodeList, $cropMode = "crop"){
        if ($this->i_id == "") die("文件上传错误<br>错误代码：Item ID is blank");

        $path = $this->ITEM_IMG_PATH . "$this->i_id/";

        $barcodeToRemove = array_diff($oldBarcodeList, $newBarcodeList);

        $i = 0;

        foreach($this->filePtrs as $filePtr){

            $extension = pathinfo(basename($filePtr["name"]), PATHINFO_EXTENSION);

            // Check if the file pointer is not blank or default value
            if($filePtr["name"] != "" and $filePtr["name"] != "image-upload-alt.png"){

                // Check the image is existed image or new uploaded image
                // (existed image cannot pass the image validation with getimagesize function)
                if(@getimagesize($filePtr["tmp_name"]) != null){
                    $this->upload($path, $filePtr, $newBarcodeList[$i], $extension);
                    $this->toJPG($path, $newBarcodeList[$i], $extension);
                    $this->cropImageToSquare($path, $newBarcodeList[$i], $cropMode);
                }

            } else{
                $this->deleteImage($newBarcodeList[$i]);
            }

            $i++;
        }

        // Delete the remaining image
        for($i = 0; $i < sizeof($barcodeToRemove); $i++){
            $this->deleteImage($barcodeToRemove[$i]);
        }
    }

    // Standard
    private function upload($path, $filePtr, $fileName, $extension){
        // Validate image is real image or not
        if(!$this->validate($filePtr)){
            die("文件上传出现错误，请联系客服人员。<br>错误代码：Error when validate image.");
        }

        // Create a directory if it is not existed
        if (!is_dir($path)){
            mkdir($path, 0700);
        }

        // Upload to server
        $fullPath = $path . $fileName . "." . $extension;
        if (!move_uploaded_file($filePtr["tmp_name"], $fullPath)) {
            die("文件上传出现错误，请联系客服人员。<br>错误代码：Error when upload image to server.");
        }
    }

    private function toJPG($path, $fileName, $extension, $imageQuality = 100){
        if($this->optimize == true) $imageQuality = 75;
        // Reference: https://theonlytutorials.com/convert-image-to-jpg-png-gif-in-php/
        $fullPath = $path . "/" . $fileName . "." . $extension;
        $binary = imagecreatefromstring(file_get_contents($fullPath));
        imageJpeg($binary, $path . $fileName . '.jpg', $imageQuality);
        if($extension != "jpg") unlink($fullPath);
    }

    private function optimizeImageJPG($path, $fileName){ // Only accept jpg format // Old version backup
        $img = imagecreatefromjpeg($path . $fileName . ".jpg");
        imagejpeg ($img, $path . $fileName . ".jpg", 75);
    }

    private function cropImageToSquare($path, $fileName, $mode){

        // Frame mode Reference: https://stackoverflow.com/questions/34699245/php-imagemagick-how-to-square-an-image-in-the-middle-of-a-white-square-without
        // Crop mode Reference: https://www.bitrepository.com/crop-rectangle-image-to-square.html

        // Declare full path variable for later use
        $fullPath = $path . $fileName . ".jpg";

        // Get image width and height
        $info = GetImageSize($fullPath);
        $width = $info[0];
        $height = $info[1];

        // Skip the calculation if it originally is square
        if($width == $height) {
            return;
        } else{

            switch($mode){
                case 'frame':

                $im = new Imagick(realpath($fullPath));

                $offset_top = 0;
                $offset_left = 0;

                if($width > $height){ // Horizontal Rectangle?
                    $new_width = $width;
                    $new_height = $width;
                    $offset_top = (($new_height-$height)/2) * -1;
                }
                else if($height > $width){ // Vertical Rectangle?
                    $new_width = $height;
                    $new_height = $height;
                    $offset_left = (($new_width-$width)/2) * -1;
                }

                // Resize the image to new size
                $im->resizeImage($new_height, $new_width, Imagick::FILTER_LANCZOS, 1, TRUE);

                // Implement white background
                $im->setImageBackgroundColor("white");

                // Extent image
                $im->extentImage($new_height,$new_width, $offset_left, $offset_top);

                // Write to image
                $im->writeImage(realpath($fullPath));

                break;

                case 'crop':

                if($width > $height){ // Horizontal Rectangle?
                    $x_pos = ($width - $height) / 2;
                    $x_pos = ceil($x_pos);
                    $y_pos = 0;

                    $new_width = $height;
                    $new_height = $height;
                } else if($height > $width){ // Vertical Rectangle?
                    $x_pos = 0;
                    $y_pos = ($height - $width) / 2;
                    $y_pos = ceil($y_pos);

                    $new_width = $width;
                    $new_height = $width;
                }

                // Create image temp
                $image = ImageCreateFromJPEG($fullPath);

                // Create new image with new width and height
                $new_image = ImageCreateTrueColor($new_width, $new_height);

                // Paste on the new image
                ImageCopy($new_image, $image, 0, 0, $x_pos, $y_pos, $width, $height);

                // Save image
                ImageJPEG($new_image, $fullPath) or die("There was a problem in saving the new file.");

                break;
            }


        }
    }

    private function deleteImage($fileName){
        if($this->i_id != ""){
            if(file_exists("../assets/images/items/$this->i_id/$fileName.jpg")){
                unlink("../assets/images/items/$this->i_id/$fileName.jpg");
            }
        } else{
            if(file_exists("assets/images/orders/$fileName.jpg")){
                unlink("assets/images/orders/$fileName.jpg");
            }
        }
    }

    // Useful tool
    private function validate($filePtr){
        return getimagesize($filePtr["tmp_name"]);
    }

}

?>