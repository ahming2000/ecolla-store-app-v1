<?php
/* Initialization */
// Standard variable declaration
$title = "Order Tracking | Ecolla ε口乐";

// Auto loader for classes
include "assets/includes/class-auto-loader.inc.php";

// Database Interaction
$cart = new Cart();

/* Operation */
// Track order
if(isset($_GET["orderId"])){

    $view = new View();
    $o_delivery_id = $view->getDeliveryId($_GET["orderId"]);
    $o_date_time = $view->getOrderDateTime($_GET["orderId"]);

    if($o_delivery_id != null && $o_date_time != null){
        $message = "Your order is on the way!<br><div class='text-center'><a href='#'>$o_delivery_id</a></div><br>Order date：$o_date_time";
        $alertType = "alert-success";
    } else if($o_delivery_id == null && $o_date_time != null){
        $message = "Your order is processing.";
        $alertType = "alert-secondary";
    } else{
        $message = "Order ID not found!";
        $alertType = "alert-warning";
    }

}

?>

<!DOCTYPE html>
<html>
<head>
    <?php include "assets/includes/stylesheet.inc.php"; ?>
    <!-- To-do: Meta for google searching -->
</head>

<body>

    <?php include "assets/includes/script.inc.php"; ?>

    <header><?php include "assets/block-user-page/header.php"; ?></header>

    <main class="container"> <!--put content-->

        <div class="row">
            <div class="col-sm-0 col-md-1 col-lg-2"></div> <!-- Side space -->

            <div class="col-sm-12 col-md-10 col-lg-8"> <!-- content -->

                <div class="col-12">
                    <div class="alert <?= isset($alertType) ? $alertType : ""; ?>" role="alert">
                        <?= isset($message) ? $message : ""; ?>
                    </div>
                </div>

                <div class="col-12 mb-3"><img src="assets/images/deco/order-tracking-deco.jpg" style="width: 100%;" /></div>

                <div class="col-12">
                    <form action="order-tracking.php" method="get">
                        <div class="form-group">
                            <label for="order-id-input">Please enter your order ID:</label>
                            <input type="text" class="form-control form-control-lg" name="orderId" aria-describedby="order-id-input-help" value="<?= isset($_GET["orderId"]) ? $_GET["orderId"] : ""; ?>" placeholder="e.g. ECOLLA01234567890123" required>
                            <small id="order-id-input-help" class="form-text text-muted">Order ID is taken from order successful page.</small>
                        </div>
                        <div class="text-center mb-3"><input class="btn btn-primary" type="submit" value="Track" style="width: 200px;"></div>
                    </form>
                </div>

            </div>

            <div class="col-sm-0 col-md-1 col-lg-2"></div> <!-- Side space -->
        </div>


    </main>

    <footer><?php include "assets/block-user-page/footer.php"; ?></footer>

</body>
</html>
