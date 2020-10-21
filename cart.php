<?php include "assets/php/includes/autoloader.inc.php"; //Auto include all the classes. ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
         <link rel="shortcut icon" href="assets/images/icon/ecollafavicon.ico">
         <link rel="stylesheet" href="assets/vendor/bootstrap-4.5.2-dist/css/bootstrap.min.css">
         <link rel="stylesheet" href="deco.css">
         <title>购物车 | Ecolla ε口乐</title>
    </head>
    <body>
        <!-- Important Thing To Declare -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script> 
        <script src="assets/vendor/bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
        <script src='https://kit.fontawesome.com/a076d05399.js'></script>      
        <?php include "assets/php/classes.php"; ?>

        <?php include "block/header.php"; ?>

        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <?php
                                $cartList = array();
                                
                                for($i = 0; $i < sizeof($cartList); $i++){
                                    $cartItem = $cartList[$i];
                                    include "block/cart-item-block";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="cart-body">
                            <!-- Delivery Description -->
                        </div>
                    </div>

                </div>           
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="cart-body">
                            <?php include "block/order-summary-block.php"; ?>
                            <form action="check-out.php" method="post">
                                <input class="btn btn-primary btn-block" type="submit" value="前往付款">
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
            
        </div>
        <?php include "block/footer.php"; ?>

    </body>
</html>
