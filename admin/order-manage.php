<?php $upperDirectoryCount = 1; include "../assets/includes/class-auto-loader.inc.php"; //Auto include all the classes. ?>
<?php if(!isset($_COOKIE["username"])) header("location: login.php"); ?>
<?php $view = new View(); $orderList = $view->getAllOrders(); ?>
<!DOCTYPE html>
<html>

<head><?php $upperDirectoryCount = 1; $title = "订单管理"; include "../assets/includes/stylesheet-script-declaration.inc.php" ?></head>

<body>
    <?php $upperDirectoryCount = 1; include "../assets/block-admin-page/header.php"; ?>

    <div class="container">

        <div style="margin-top: 100px;"></div>

        <div class="h1">订单查看</div>

        <table class="table table-bordered" id="item-table">
            <thead>
                <tr>
                    <th scope="col">订单ID</th>
                    <th scope="col">订单日期时间</th>
                    <th scope="col">顾客资料资料</th>
                    <th scope="col">订单物品列表</th>
                    <th scope="col">订单物品总数量</th>
                    <th scope="col">总计</th>
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
</body>

</html>
