<?php include "assets/includes/class-auto-loader.inc.php"; //Auto include classes when needed. ?>
<?php $cart = new Cart(); ?>
<?php
$alertType = "";
$message = "";
if(isset($_GET["orderId"])){

    $view = new View();
    $o_delivery_id = $view->getDeliveryId($_GET["orderId"]);

    if($o_delivery_id != null){
        $message = "您的快递的运送ID为：".$o_delivery_id;
        $alertType = "alert-success";
    } else{

        if(isset($_GET["checkOut"])){
            $message = "您的订单已经提交完成，订单会在两天内出货！";
            $alertType = "alert-primary";
        } else{
            $message = "您输入的订单ID不存在我们的记录里。";
            $alertType = "alert-warning";
        }

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

            <div class="container">
                <div class="alert <?php echo $alertType ?>" role="alert"><?php echo $message ?></div>
                <div class="text-center" style="width: 300px; font-size: large;">
                    <?php if(@$_GET["orderId"] != null) echo $_GET["orderId"]; ?>
                </div>

                <?php if(@$_GET["orderId"] != null) echo "<br><br>"; ?>

                <form action="order-tracking.php" method="get">
                    <div class="form-group">
                        <label for="order-id-input">请输入订单ID</label>
                        <input type="text" class="form-control form-control-lg" name="orderId" aria-describedby="order-id-input-help" placeholder="e.g. ECOLLA20201130132713" required>
                        <small id="order-id-input-help" class="form-text text-muted">订单ID来自上一次的结账界面</small>
                    </div>
                    <input type="submit" value="确认">
                </form>



            </div>


        </main>

        <section>
            <?php include "assets/block-user-page/footer.php"; ?>
        </section>

    </wrapper>
</body>
</html>
