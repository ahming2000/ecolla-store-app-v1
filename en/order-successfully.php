<?php
/* Initialization */
// Standard variable declaration
$title = "Order successfully | Ecolla ε口乐";

// Auto loader for classes
include "assets/includes/class-auto-loader.inc.php";

// Database Interaction
$cart = new Cart();
$view = new View();

/* Operation */
// Redirect to home page if url parameter orderId not found
// if(!isset($_GET["orderId"])) header("location: index.php");

// Get any attribute from orders table to detect the availability
$o_date_time = $view->getOrderDateTime($_GET["orderId"]);

// Redirect to home page if the order is not available in database
// if($o_date_time == null) header("location: index.php");

$alertType = "";
$message = "";

?>

<!DOCTYPE html>
<html>

<head>
    <?php include "assets/includes/stylesheet.inc.php"; ?>
</head>

<body>

    <?php include "assets/includes/script.inc.php"; ?>

    <header><?php include "assets/block-user-page/header.php"; ?></header>

    <main class="container">

        <div class="row">

            <div class="col-xs-0 col-sm-2"></div>
            <div class="col-xs-12 col-sm-8">
                <div class="row mb-3 justify-content-center align-items-center">
                    <img class="img-fluid" src="assets/images/deco/order-successful-deco.png" style="height: 150px;" />
                </div>

                <div class="row mb-3">
                    <div class="col-12 text-center">
                        Order successful!<br>
                        <span class="text-muted">Thank you for your support!<br>We will process your order as soon as possible!</span><br>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-sm-12 col-md-6 lime lighten-3 text-center mx-auto p-3 mb-2">
                        <b><?= $_GET['orderId']; ?></b>
                    </div>
                    <div class="col-12 text-center">Tracking ID</div>
                </div>

                <div class="row justify-content-center align-items-center">
                    <div class="d-flex mx-1">
                        <button type="button" class="btn btn-primary btn-block" onclick="goToOrderTracking()">Order Tracking</button>
                        <button type="button" class="btn btn-primary btn-block" onclick="goToItemList()">Continue Browsing</button>
                    </div>
                </div>
            </div>
            <div class="col-xs-0 col-sm-2"></div>

        </div>

    </main>

    <footer><?php include "assets/block-user-page/footer.php"; ?></footer>

    <script>
        function goToOrderTracking() {
            window.location.href = "order-tracking.php?orderId=<?= $_GET['orderId']; ?>";
        }

        function goToItemList() {
            window.location.href = "item-list.php";
        }
    </script>

</body>

</html>
