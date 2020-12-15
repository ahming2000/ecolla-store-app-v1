<?php

/*  Stylesheet Declaration
    1. $upperDirectoryCount (Default: 0)
    2. $mode ("user" or "admin") (Default: "user")
    3. $title
 */

//Set default value // '@' is to ignore the error message on null variable
if (@$upperDirectoryCount == null) $upperDirectoryCount = 0;
if (@$mode == null) $mode = "user";

//Initial
$SYMBOL = "../";
$upperDirectory = "";
for($i = 0; $i < $upperDirectoryCount; $i++){
    $upperDirectory = $upperDirectory.$SYMBOL;
}
?>

<!-- Layout Scale Viewport Declaration -->
<meta content="width=device-width, initial-scale=1.0" name="viewport">

<!-- Charset Declaration -->
<meta charset="utf-8">

<!-- Title Declaration -->
<title><?php echo $title ?></title>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<!-- Google Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<!-- Material Design Bootstrap -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css">
<!-- Icofont -->
<link rel="stylesheet" href="<?php echo $upperDirectory; ?>assets/vendor/icofont/icofont.min.css">
<!-- Tiny Slider 2 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/tiny-slider.css">

<!-- Others -->
<link rel="stylesheet" href="<?php echo $upperDirectory; ?>assets/vendor/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css" />
<link rel="stylesheet" href="<?php echo $upperDirectory; ?>assets/vendor/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css" />

<!-- Website Icon -->
<link rel="shortcut icon" href="<?php echo $upperDirectory; ?>assets/images/icon/ecollafavicon.ico">
<!-- Global CSS -->
<link rel="stylesheet" href="<?php echo $upperDirectory; ?>assets/css/main.css">
