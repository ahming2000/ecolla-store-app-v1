<?php
/* Initialization */
// Standard variable declaration
$title = "About us | Ecolla";

// Auto loader for classes
include "assets/includes/class-auto-loader.inc.php";

// Database Interaction
$cart = new Cart();

 ?>

<!DOCTYPE html>
<html>
<head>
    <?php include "assets/includes/stylesheet.inc.php" ?>
    <!-- To-do: Meta for google searching -->
</head>

<body>

    <?php include "assets/includes/script.inc.php"; ?>

    <header><?php include "assets/block-user-page/header.php"; ?></header>

    <main class="flex-fill"> <!--put content-->
        <section class="mt-5">
            <div class="container">
                <div class="row pl-3 mx-auto">
                    <div class="col pt-5">
                        <h1 class="about">About</h1><h1 class="us"> Us</h1>
                        <p class="mt-4">Snacks from foreign country China Thailand Korea<br>Best taste ever</p>
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
                        <h1>Operation Hours</h1>
                        <p class="mt-4">9 a.m - 10 p.m</p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer><?php include "assets/block-user-page/footer.php"; ?></footer>

</body>
</html>
