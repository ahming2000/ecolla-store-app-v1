<?php
/* Initialization */
// Standard variable declaration
$title = "下单成功 | Ecolla ε口乐";

// Auto loader for classes
include "assets/includes/class-auto-loader.inc.php";

// Database Interaction
$cart = new Cart();
$view = new View();

// Get order information
// if(!isset($_GET["orderId"])) header("location: index.php");
$order = $view->getOrder($_GET["orderId"]);
// if($order == null) header("location: index.php");

/* Operation */
$alertType = "";
$message = "";

if(isset($_GET["orderId"])){


}

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
                <div class="row mb-3">
                    <div class="col-xs-3 col-sm-3 mx-auto">
                        <img class="img-fluid" src="assets/images/deco/order-successful-deco.png" />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12 text-center">
                        下单成功<br>
                        <span class="text-muted">我们会在三天之内出货</span><br>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-sm-12 col-md-6 lime lighten-3 text-center mx-auto p-3 mb-2">
                        <b><?= $_GET['orderId']; ?></b>
                    </div>
                    <div class="col-12 text-center">追踪ID</div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-12 col-md-6 text-center mx-auto">
                        <div class="row">
                            <div class="col-6"><button type="button" class="btn btn-primary btn-block" onclick="goToOrderTracking()">追踪订单</button></div>
                            <div class="col-6"><button type="button" class="btn btn-primary btn-block" onclick="goToItemList()">再去逛逛</button></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-0 col-sm-2"></div>

        </div>

    </main>

    <footer><?php include "assets/block-user-page/footer.php"; ?></footer>

    <script>
    function goToOrderTracking(){
        window.location.href = "order-tracking.php?orderId=<?= $_GET['orderId']; ?>";
    }

    function goToItemList(){
        window.location.href = "item-list.php";
    }
    </script>

</body>
</html>
