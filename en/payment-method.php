<?php
/* Initialization */
// Standard variable declaration
$title = "Payment Method | Ecolla ε口乐";

// Auto loader for classes
include "assets/includes/class-auto-loader.inc.php";

// Database Interaction
$cart = new Cart();

 ?>

<!DOCTYPE html>
<html>
<head>
    <?php include "assets/includes/stylesheet.inc.php"; ?>
</head>

<body>

    <?php include "assets/includes/script.inc.php"; ?>

    <header><?php include "assets/block-user-page/header.php"; ?></header>

    <main class="flex-fill"> <!--put content-->
        <div class="container">
            <h1 class="mt-4 mb-3">Payment Method</h1>
            <p>We accept these payment method</p>

            <div class="row shadow p-3 m-2 mx-auto">
                <div class="col-6 col-md-3 col-sm-6">
                    <img src="assets/images/payment/tng.png" alt="image" height="100" width="100">
                </div>
                <div class="col-6 col-md-9 col-sm-6 pt-4">
                    <h5>Touch 'n Go</h5>
                </div>
            </div>

            <div class="row shadow p-3 m-2 mx-auto">
                <div class="col-6 col-md-3 col-sm-6">
                    <img src="assets/images/payment/boost.png" alt="image" height="100" width="100">
                </div>
                <div class="col-6 col-md-9 col-sm-6 pt-4">
                    <h5>Boost</h5>
                </div>
            </div>

            <div class="row shadow p-3 m-2 mx-auto">
                <div class="col-6 col-md-3 col-sm-6">
                    <img src="assets/images/payment/bank-transfer.png" alt="image" height="100" width="100">
                </div>
                <div class="col-6 col-md-9 col-sm-6 pt-4">
                    <h5>Bank Transfer</h5>
                </div>
            </div>
        </div>

    </main>

    <footer><?php include "assets/block-user-page/footer.php"; ?></footer>

</body>
</html>
