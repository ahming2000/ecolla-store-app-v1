<?php
/* Initialization */
// Standard variable declaration
$title = "购物车 | Ecolla ε口乐";

// Auto loader for classes
include "assets/includes/class-auto-loader.inc.php";

// Database Interaction
$cart = new Cart();
$view = new View();

// Get cart information
$cartItems = $cart->getCartItems();

/* Operation */
if (isset($_POST["clearCart"])) {
    $cart->resetCart();
    header("refresh: 0"); //Refresh page immediately
}

if (isset($_POST['quantityIncreaseButton'])) {
    $barcode = $_POST['quantityIncreaseButton'];
    $cart->editQuantity($barcode, 1);
}

if (isset($_POST['quantityDecreaseButton'])) {
    $barcode = $_POST['quantityDecreaseButton'];
    $cart->editQuantity($barcode, -1);
}

if (isset($_POST['removeItem'])) {
    $obj = $_POST['removeItem'];
    $cart->removeItem($obj);
    $cartItems = $cart->getCartItems();
}

if(isset($_POST['changeRegion'])){
    $cart->setEastMY($_POST['region'][0]);
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

    <script>
        const max_count = 10;
    </script>

    <header><?php include "assets/block-user-page/header.php"; ?></header>

    <main class="container">
        <div class="row">

            <!-- Cart item and notification -->
            <div class="col-lg-8">

                <!-- Cart items -->
                <div class="card mb-3">
                    <div class="card-body" id="cartItemList">

                        <div class="h4 pl-3 mb-3">购物车（<?= $cart->getCartCount(); ?>个）</div>

                        <form method="POST" action="cart.php" id="item_list_form">
                            <?php if (empty($cartItems)) : ?>
                                <div class="text-center">
                                    <img src="assets/images/icon/empty-cart.png" width="150" height="150"/>
                                    <div class="h5 p-2">您的购物车为空</div>
                                </div>
                            <?php endif; ?>

                            <?php
                            foreach($cartItems as $cartItem){
                                include "assets/block-user-page/cart-item-block.php";
                            }
                             ?>

                            <?php if (!empty($cartItems)) : ?>
                                <div class="col-12">
                                    <form action="" method="post">
                                        <button class="btn btn-primary btn-block" name="clearCart" type="submit">清空购物车</button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </form>

                    </div>
                </div><!-- Cart items -->

                <!-- Notification -->
                <div class="card mb-3">
                    <div class="card-body bg-info">
                        <!-- Delivery Description -->
                        <h5>邮寄费用（以1KG来计算）</h5>
                        <p class="text-light">
                        西马：RM<?php echo number_format($view->getShippingFeeRate(false), 2); ?><br>
                        东马：RM<?php echo number_format($view->getShippingFeeRate(true), 2); ?><br>
                        霹雳金宝区免邮
                        </p>

                    </div>
                </div><!-- Notification -->

            </div><!-- Cart item and notification -->

            <!-- Region settings and order summary -->
            <div class="col-lg-4">

                <!-- Region settings -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="h5 mb-3">请选择您的地区：</div>
                        <form action="" method="post">
                            <select class="mb-3" style="width: 100%;" name="region[]">
                                <option value="0" id="west">西马</option>
                                <option value="1" id="east">东马</option>
                            </select>
                            <button class="btn btn-primary btn-block" name="changeRegion" type="submit">修改</button>
                        </form>
                    </div>
                </div><!-- Region settings -->

                <!-- Order summary -->
                <div class="card mb-3">
                    <div class="card-body">
                        <?php $c = $cart;
                        include "assets/block-user-page/order-summary-block.php"; ?>
                        <form action="check-out.php" method="post">
                            <button class="btn btn-primary btn-block" type="submit" id="submit_btn">前往付款</button>
                        </form>
                    </div>
                </div><!-- Order summary -->

            </div><!-- Region settings and order summary -->

        </div>
    </main>

    <script>
        // Region settings scripts
        var isEastMY = <?php echo $cart->isEastMY(); ?>;
        if(isEastMY){
            document.getElementById("east").setAttribute("selected", "selected");
        } else{
            document.getElementById("west").setAttribute("selected", "selected");
        }

    </script>

    <footer><?php include "assets/block-user-page/footer.php"; ?></footer>

</body>

</html>
