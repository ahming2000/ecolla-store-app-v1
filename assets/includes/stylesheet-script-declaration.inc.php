<?php
//Set default value // '@' is to ignore the error message on null variable
if (@$upperDirectoryCount == null) $upperDirectoryCount = 0;

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

<!-- Stylesheet Declaration -->
<link rel="shortcut icon" href="<?php echo $upperDirectory; ?>assets/images/icon/ecollafavicon.ico">
<link rel="stylesheet" href="<?php echo $upperDirectory; ?>assets/vendor/bootstrap-4.5.2-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $upperDirectory; ?>assets/vendor/icofont/icofont.min.css">
<link rel="stylesheet" href="<?php echo $upperDirectory; ?>assets/vendor/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css" />
<link rel="stylesheet" href="<?php echo $upperDirectory; ?>assets/vendor/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css" />
<link rel="stylesheet" href="<?php echo $upperDirectory; ?>assets/css/main.css">

<!-- JS Declaration -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="<?php echo $upperDirectory; ?>assets/vendor/bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<script src="<?php echo $upperDirectory; ?>assets/vendor/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>
<script src="<?php echo $upperDirectory; ?>assets/vendor/jquery-mousewheel-master/jquery.mousewheel.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>



<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/5fd2003a920fc91564cf5d7e/default';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
