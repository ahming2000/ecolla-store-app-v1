<?php
/* Initialization */
// Standard variable declaration
$title = "Ecolla Official Snack Shop";

// Auto loader for classes
include "assets/includes/class-auto-loader.inc.php";

// Database Interaction
$cart = new Cart();
$view = new View();

$new = $view->getItemWithSpecificCategory("New Product", 0, 10);
$hot = $view->getItemWithSpecificCategory("Hot Selling", 0, 10);
?>

<!DOCTYPE html>
<html>

<head>
    <?php include "assets/includes/stylesheet.inc.php"; ?>
    <!-- To-do: Meta for google searching -->
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

    <?php include "assets/includes/script.inc.php"; ?>

    <header>
        <div class="headtext">Welcome to <div class="headtext1"> Ecolla </div>Official Snack Shop</div>
        <?php include "assets/block-user-page/header.php"; ?>
    </header>

    <main>

        <!-- Advertisement -->
        <section class="container">
            <?php
            // ***1920 x 540 pixels picture is needed for advertisement!!!***
            $imgList = array("assets/images/ads/ads1.jpg", "assets/images/ads/ads2.jpg", "assets/images/ads/ads3.jpg", "assets/images/ads/ads4.jpg");
            include "assets/block-user-page/carousel-block.php";
            ?>
        </section>

        <!-- Hot Sells Items -->
        <section class="section1">
            <div class="container mt-5">
                <h3 class="pt-3 pl-5">New Product</h3>
                <div class="owl-carousel mousescroll owl-theme">
                    <?php
                        for($i = 0; $i < sizeof($new); $i++){
                            $item = $new[$i];
                            include "assets/block-user-page/item-carousel.php";
                        }
                    ?>
                </div>
            </div>
        </section>

        <section class="section2">
            <div class="container mt-5">
                <h3 class="pt-3 pl-5">Hot Selling</h3>
                <div class="owl-carousel mousescroll1 owl-theme">
                    <?php
                        for($i = 0; $i < sizeof($hot); $i++){
                            $item = $hot[$i];
                            include "assets/block-user-page/item-carousel.php";
                        }
                    ?>
                </div>
            </div>
        </section>

    </main>

    <script>
    $('.owl-carousel').owlCarousel({
        margin:10,
        responsive:{
            0:{
                items:2
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    });
    var owl= $('.mousescroll1');
    owl.on('mousewheel', '.owl-stage', function (e) {
        if (e.deltaY>0) {
            owl.trigger('next.owl');
        } else {
            owl.trigger('prev.owl');
        }
        e.preventDefault();
    });
    var owl1= $('.mousescroll');
    owl1.on('mousewheel', '.owl-stage', function (e) {
        if (e.deltaY>0) {
            owl1.trigger('next.owl');
        } else {
            owl1.trigger('prev.owl');
        }
        e.preventDefault();
    });
    </script>

    <footer><?php include "assets/block-user-page/footer.php"; ?></footer>

</body>

</html>
