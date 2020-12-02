<?php include "assets/includes/class-auto-loader.inc.php"; //Auto include classes when needed. ?>
<?php $cart = new Cart(); ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <?php $title = "Ecolla ε口乐零食店官网"; include "assets/includes/stylesheet-script-declaration.inc.php" ?>
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

    <wrapper class="d-flex flex-column">
        <main class="flex-fill"> <!--put content-->
        
            <div class="headtext">欢迎来到 <div class="headtext1">Ecolla ε口乐 </div>零食店官网</div>
            <?php $c = $cart; include "assets/block-user-page/header.php"; ?>

            <!-- Advertisement -->
            <section class="ads-carousel">
                <div class="container p-0">
                    <?php
                    // ***1920 x 540 pixels picture is needed for advertisement!!!***
                    $imgList = array("assets/images/ads/ads1.jpg", "assets/images/ads/ads2.jpg", "assets/images/ads/ads3.jpg", "assets/images/ads/ads4.jpg");
                    include "assets/block-user-page/carousel-block.php";
                    ?>
                </div>
            </section>

            <!-- Hot Sells Items -->
            <section class="section1">
                <div class="container mt-5">
                    <h3 class="pt-3 pl-5">New !</h3>
                    <div class="owl-carousel mousescroll owl-theme">
                        <?php include "assets/block-user-page/item-carousel.php";?>
                    </div>
                </div>
            </section>

            <section class="section2">
                <div class="container mt-5">
                    <h3 class="pt-3 pl-5">Hot !</h3>
                    <div class="owl-carousel mousescroll1 owl-theme">
                        <?php include "assets/block-user-page/item-carousel.php";?>
                    </div>
                </section>

            </main>

            <section>
                <?php include "assets/block-user-page/footer.php"; ?>
            </section>


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

        </wrapper>
    </body>
    </html>
