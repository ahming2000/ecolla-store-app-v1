<?php include "assets/includes/class-auto-loader.inc.php"; //Auto include classes when needed. ?>
<?php $cart = new Cart(); //Must declare before html tag for php cookie ?>
<?php
    if(isset($_POST["clearCart"])){
        $cart->resetCart();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php $title = "购物车 | Ecolla ε口乐"; include "assets/includes/stylesheet-script-declaration.inc.php" ?>
        <!-- To-do: Meta for google searching -->
    </head>

    <body>
        <?php $c = $cart; include "assets/block-user-page/header.php"; ?>

    <wrapper class="d-flex flex-column">
    <main class="flex-fill"> <!--put content-->

        <div class="container mt-4">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-2">
                        <div class="card-body" id="cartItemList">
                            <?php

                                $cartList = $cart->getCartItems();

                                if(empty($cartList[0])) echo "<div>您的购物车为空</div>";

                                for($i = 0; $i < sizeof($cartList); $i++){
                                    $cartItem = $cartList[$i];

                                    include "assets/block-user-page/cart-item-block.php";
                                }
                                if(isset($cartList[0])){
                                    echo "<div class=\"col-12\"><form action=\"\" method=\"post\"><button class=\"btn btn-primary btn-block\" name=\"clearCart\" type=\"submit\">清空购物车</button></form></div>";
                                }
                            ?>


                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body bg-warning">
                            <!-- Delivery Description -->
                            <h5>Delivery Service</h5>
                            <p class="text-muted">We only deliver within Kampar.</p>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <?php $c = $cart; include "assets/block-user-page/order-summary-block.php"; ?>
                            <form action="check-out.php" method="post">
                                <input class="btn btn-primary btn-block" type="submit" value="前往付款">
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </main>

        <?php include "assets/block-user-page/footer.php"; ?>

    </wrapper>

    </body>
</html>
