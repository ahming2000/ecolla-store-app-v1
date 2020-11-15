<?php include "assets/php/includes/class-auto-loader.inc.php"; //Auto include classes when needed. ?>
<?php $cart = new Cart(); //Must declare first before have any output to continue the session ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Ecolla ε口乐零食店官网</title>
        <!-- To-do: Meta for google searching -->
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <link rel="shortcut icon" href="assets/images/icon/ecollafavicon.ico">
        <link rel="stylesheet" href="assets/vendor/bootstrap-4.5.2-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/vendor/icofont/icofont.min.css">
        <link rel="stylesheet" href="deco.css">
        <link rel="stylesheet" href="assets/vendor/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css" />
        <link rel="stylesheet" href="assets/vendor/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css" />

    </head>
    <style>/*overwrite deco.css*/
        .navbar{
        background-color:transparent;
        transition: background-color 0.5s;
        }
        .navbar-change{
        background-color: #3c3e44;
        transition: background-color 0.5s;
        }
        .navbar-custom .navbar-brand{
        color: white;
        }
        .navbar-custom .navbar-nav .nav-link, .navbar-custom .fa-bars{
        color: white;
        }
    </style>
    <body>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="assets/vendor/bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
        <script src='https://kit.fontawesome.com/a076d05399.js'></script>
        <script src="assets/vendor/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>

    <wrapper class="d-flex flex-column">
    <main class="flex-fill"> <!--put content-->

        <p class="headtext">Welcome to Ecolla</p>
        <?php $c = $cart; include "block/header.php"; ?>

        <!-- Advertisement -->
        <section class="ads-carousel">
            <?php
                // ***1920 x 540 pixels picture is needed for advertisement!!!***
                $imgList = array("assets/images/ads/ads1.jpg", "assets/images/ads/ads2.jpg", "assets/images/ads/ads3.jpg", "assets/images/ads/ads4.jpg");
                include "block/carousel-block.php";
            ?>
        </section>

        <!-- Hot Sells Items -->
        <section class="section1">
            <div class="container mt-5">
                <h3 class="pt-3 pl-5">New !</h3>
                <div class="owl-carousel owl-theme">
                    <?php include "block/item-carousel.php";?>
                </div>
            </div>
        </section>

        <section class="section2">
        <div class="container mt-5">
                <h3 class="pt-3 pl-5">Hot !</h3>
                <div class="owl-carousel owl-theme">
                    <?php include "block/item-carousel.php";?>
                </div>
        </section>

    </main>

        <section>
        <?php include "block/footer.php"; ?>
        </section>

        <script>
            $(document).ready(function(){

                $("#cartCount").html("0");

            });

            $(document).ready(function(){
            $(".owl-carousel").owlCarousel();
            });
        </script>

    </wrapper>
    </body>
</html>
