<?php
/* Initialization */
// Standard variable declaration
$title = "订单追踪 | Ecolla ε口乐";

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
        $message = "您的订单已经在路上<br><div class='text-center'><a href='#'>$o_delivery_id</a></div><br>订单日期：$o_date_time";
        $alertType = "alert-success";
    } else if($o_delivery_id == null && $o_date_time != null){
        $message = "您的订单正在处理中。";
        $alertType = "alert-secondary";
    } else{
        $message = "订单不在我们的数据库里！";
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
                            <label for="order-id-input">请输入订单ID</label>
                            <input type="text" class="form-control form-control-lg" name="orderId" aria-describedby="order-id-input-help" value="<?= isset($_GET["orderId"]) ? $_GET["orderId"] : ""; ?>" placeholder="e.g. ECOLLA01234567890123" required>
                            <small id="order-id-input-help" class="form-text text-muted">订单ID来自上一次的结账界面</small>
                        </div>
                        <div class="text-center mb-3"><input class="btn btn-primary" type="submit" value="追踪" style="width: 100px;"></div>
                    </form>
                </div>

            </div>

            <div class="col-sm-0 col-md-1 col-lg-2"></div> <!-- Side space -->
        </div>


    </main>

    <footer><?php include "assets/block-user-page/footer.php"; ?></footer>

</body>
</html>
