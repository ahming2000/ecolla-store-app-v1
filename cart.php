<?php include "assets/php/includes/class-auto-loader.inc.php"; //Auto include classes when needed. ?>
<?php $cart = new Cart(); //Must declare before html tag for php cookie ?>
<?php
    if(isset($_POST["clearCart"])){
        $cart->resetCart();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <link rel="stylesheet" href="assets/vendor/bootstrap-4.5.2-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/vendor/icofont/icofont.min.css">
        <link rel="stylesheet" href="deco.css">
        <link rel="shortcut icon" href="assets/images/icon/ecollafavicon.ico">
         <title>购物车 | Ecolla ε口乐</title>
    </head>
    <body>
        <!-- Important Thing To Declare -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="assets/vendor/bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
        <script src='https://kit.fontawesome.com/a076d05399.js'></script>

        <?php $c = $cart; include "block/header.php"; ?>

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

                                    include "block/cart-item-block.php";
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
                            <?php $c = $cart; include "block/order-summary-block.php"; ?>
                            <form action="check-out.php" method="post">
                                <input class="btn btn-primary btn-block" type="submit" value="前往付款">
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </main>

        <?php include "block/footer.php"; ?>

    </wrapper>

    </body>
</html>
