<?php
/* Initialization */
// Standard variable declaration
$title = "关于我们 | Ecolla ε口乐";

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

    <footer><?php include "assets/block-user-page/footer.php"; ?></footer>
    
</body>
</html>
