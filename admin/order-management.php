<?php
/* Authorization */
if(!isset($_COOKIE["username"])) header("location: login.php");

/* Initialization */
// Standard variable declaration
$upperDirectoryCount = 1;
$title = "订单管理";
$mode = "admin";

// Auto loader for classes
include "../assets/includes/class-auto-loader.inc.php";

// Database Interaction
$view = new View();
$controller = new Controller();

//Get order information
$orderList = $view->getAllOrders();

/* Operation */
if(isset($_POST["updateDeliveryId"])){
    $controller->updateDeliveryId($_POST["orderId"], $_POST["deliveryId"]);
    UsefulFunction::generateAlert("已更新订单 " . $_POST["orderId"] . " 的运输ID为 " . $_POST["deliveryId"]);
    header("refresh: 0"); //Refresh page immediately
}

if(isset($_POST["refund"])){
    if($controller->orderRefund($_POST["orderId"])){
        UsefulFunction::generateAlert("订单已成功退款！");
    } else{
        UsefulFunction::generateAlert("订单必须要是待处理状态！");
    }
    header("refresh: 0"); //Refresh page immediately
}

if(isset($_POST["unbuy"])){
    if($controller->orderUnbuy($_POST["orderId"])){
        UsefulFunction::generateAlert("订单已成功反结账！");
    } else{
        UsefulFunction::generateAlert("订单必须要是待处理状态！");
    }
    header("refresh: 0"); //Refresh page immediately
}

if(isset($_POST["adjustOrder"])){

}

?>

<!DOCTYPE html>
<html>

<head><?php include "../assets/includes/stylesheet.inc.php"; ?></head>

<body>

    <?php include "../assets/includes/script.inc.php"; ?>

    <header><?php include "../assets/block-admin-page/header.php"; ?></header>

    <div class="container">

        <div style="margin-top: 100px;"></div>

        <div class="h1">订单查看</div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">订单详情</th>
                    <th scope="col">运送ID</th>
                    <th scope="col">顾客资料</th>
                    <th scope="col">订单物品</th>
                    <th scope="col">销售额</th>
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($orderList as $order){
                    include "../assets/block-admin-page/manage-order-block.php";
                }
                 ?>
            </tbody>
        </table>


    </div>

    <script>
    function viewReceipt(source){
        let url = source.value;
        window.open(url,'Image','width=400px,height=400px,resizable=1');
    }
    </script>
</body>

</html>
