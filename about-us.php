<?php include "assets/php/includes/class-auto-loader.inc.php"; //Auto include classes when needed. ?>
<?php $cart = new Cart(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title>Ecolla ε口乐零食店官网</title>
        <link rel="stylesheet" href="assets/vendor/bootstrap-4.5.2-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/vendor/icofont/icofont.min.css">
        <link rel="stylesheet" href="deco.css">
        <link rel="shortcut icon" href="assets/images/icon/ecollafavicon.ico">
    </head>

    <body>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="assets/vendor/bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>

    <?php $c = $cart; include "block/header.php"; ?>

    <wrapper class="d-flex flex-column">
    <main class="flex-fill"> <!--put content-->
    <section class="mt-5">
        <div class="container">
                <div class="row pl-3 mx-auto">
                    <div class="col pt-5">
                        <h1 class="about">About</h1><h1 class="us"> Us</h1>
                        <h1 class="about"> 关于</h1><h1 class="us">我们</h1>
                        <p class="mt-4">进口零食 中国 泰国 韩国 零食<br>现在呆在家的最好佳食</p>
                    </div>
                    <div class="col">
                        <img src="assets/images/ads/shop-image.jpg" height="350" width="410" alt="image">
                    </div>
                </div>
        </div>
    </section>
    <section class="mt-5">
    <div class="container">
                <div class="row mx-auto">
                    <div class="col">
                        <img src="assets/images/ads/shop-image.jpg" height="350" width="410" alt="image">
                    </div>
                    <div class="col pt-5">
                        <h1>Operation Hours 营业时间</h1>
                        <p class="mt-4">9 a.m - 10 p.m</p>
                    </div>
                </div>
    </div>
    </section>

    </main>

    <section>
        <?php include "block/footer.php"; ?>
    </section>

    </wrapper>
    </body>
</html>
