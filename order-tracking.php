<?php
// Initialize
include "assets/includes/class-auto-loader.inc.php"; //Auto include classes when needed.
$cart = new Cart();

if(isset($_GET["orderId"])){

    $view = new View();
    $o_delivery_id = $view->getDeliveryId($_GET["orderId"]);
    $order = $view->getOrder($_GET["orderId"]);

    if($o_delivery_id != null && $order != null){
        $message = "您的订单已经在路上：";
        $alertType = "alert-success";
    } else if($o_delivery_id == null && $order != null){
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
    <?php $title = "订单追踪 | Ecolla ε口乐"; include "assets/includes/stylesheet-script-declaration.inc.php" ?>
    <!-- To-do: Meta for google searching -->
</head>

<body>

    <?php $c = $cart; include "assets/block-user-page/header.php"; ?>

    <wrapper class="d-flex flex-column">
        <main class="flex-fill"> <!--put content-->

            <div class="container-sm">

                <div class="row">
                    <div class="col-12">
                        <form action="order-tracking.php" method="get">
                            <div class="form-group">
                                <label for="order-id-input">请输入订单ID</label>
                                <input type="text" class="form-control form-control-lg" name="orderId" aria-describedby="order-id-input-help" placeholder="e.g. ECOLLA20201130132713" required>
                                <small id="order-id-input-help" class="form-text text-muted">订单ID来自上一次的结账界面</small>
                            </div>
                            <input type="submit" value="确认">
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="alert <?php
                        if(isset($alertType)){
                            echo $alertType;
                        } ?>" role="alert"><?php
                        if(isset($message)){
                            echo $message;
                        } ?></div>
                    </div>
                    <div class="col-4">
                        <div class="text-center" style="font-size: large;">
                            <?php if(@$_GET["orderId"] != null) echo $_GET["orderId"]; ?>
                        </div>
                    </div>
                </div>





            </div>


        </main>

        <section>
            <?php include "assets/block-user-page/footer.php"; ?>
        </section>

    </wrapper>
</body>
</html>
