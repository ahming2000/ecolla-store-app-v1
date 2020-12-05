<?php include "assets/includes/class-auto-loader.inc.php"; //Auto include classes when needed.
?>
<?php $cart = new Cart();
$view = new View(); //Must declare before html tag for php cookie
?>
<?php

if (isset($_POST["clearCart"])) {
    $cart->resetCart();
}

if (isset($_POST['addItemQuantity'])) {
    $obj = $_POST['addItemQuantity'];
    $cart->editQuantity($obj, 1);
}

if (isset($_POST['minusItemQuantity'])) {
    $obj = $_POST['minusItemQuantity'];
    $cart->editQuantity($obj, -1);
}

if (isset($_POST['removeItem'])) {
    $obj = $_POST['removeItem'];
    $cart->removeItem($obj);
}

if(isset($_POST['changeRegion'])){
    $cart->setEastMY($_POST['region'][0]);
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php $title = "购物车 | Ecolla ε口乐";
    include "assets/includes/stylesheet-script-declaration.inc.php" ?>
    <!-- To-do: Meta for google searching -->
</head>

<body>
    <script>
        const max_count = 10;
    </script>
    <?php $c = $cart;
    include "assets/block-user-page/header.php"; ?>

    <wrapper class="d-flex flex-column">
        <main class="flex-fill">
            <!--put content-->

            <div class="container mt-4">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-2">
                            <div class="card-body" id="cartItemList">
                                <form method="POST" action="cart.php" id="item_list_form">
                                    <?php

                                    $cartList = $cart->getCartItems();

                                    if (empty($cartList[0])) echo "<div class=\"text-center\"><img src=\"assets/images/icon/empty-cart.png\" width=\"150\" height=\"150\"> <h5 class=\"p-2\">您的购物车为空</h5></div>";

                                    for ($i = 0; $i < sizeof($cartList); $i++) {
                                        $cartItem = $cartList[$i];

                                        include "assets/block-user-page/cart-item-block.php";
                                    }
                                    if (isset($cartList[0])) {
                                        echo "<div class=\"col-12\"><form action=\"\" method=\"post\"><button class=\"btn btn-primary btn-block\" name=\"clearCart\" type=\"submit\">清空购物车</button></form></div>";
                                    }
                                    ?>
                                </form>


                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body bg-warning">
                                <!-- Delivery Description -->
                                <h5>邮寄服务</h5>
                                <p class="text-muted">
                                西马邮寄费用：RM<?php echo number_format($view->getShippingFeeRate(false), 2); ?><br>
                                东马马邮寄费用：RM<?php echo number_format($view->getShippingFeeRate(true), 2); ?><br>
                                仅限金宝区免邮
                                </p>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4">

                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="h5 mb-3">请选择您的地区：</div>
                                <form action="" method="post">
                                    <select class="mb-3" style="width: 100%;" name="region[]">
                                        <option value="0" id="west">西马</option>
                                        <option value="1" id="east">东马</option>
                                    </select>
                                    <input class="btn btn-primary btn-block" name="changeRegion" type="submit" value="修改">
                                </form>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-body">
                                <?php $c = $cart;
                                include "assets/block-user-page/order-summary-block.php"; ?>
                                <form action="check-out.php" method="post">
                                    <input class="btn btn-primary btn-block" type="submit" value="前往付款" id="submit_btn">
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </main>

        <?php include "assets/block-user-page/footer.php"; ?>

    </wrapper>

    <script>
        var isEastMY = <?php echo $cart->isEastMY(); ?>;
        if(isEastMY){
            document.getElementById("east").setAttribute("selected", "selected");
        } else{
            document.getElementById("west").setAttribute("selected", "selected");
        }

    </script>

</body>

</html>
