<?php
/* Authorization */
if(!isset($_COOKIE["username"])) header("location: login.php");
if(!isset($_GET["orderId"])) header("location: order-management.php");

/* Initialization */
// Standard variable declaration
$upperDirectoryCount = 1;
$title = "订单查看";
$mode = "admin";

// Auto loader for classes
include "../assets/includes/class-auto-loader.inc.php";

// Database Interaction
$view = new View();
$controller = new Controller();

// Get order information
$order = $view->getOrder($_GET["orderId"]);
if($order == null) header("location: order-management.php");

/* Operation */

?>


<!DOCTYPE html>
<html>
<head>
    <?php include "../assets/includes/stylesheet.inc.php"; ?>
    <style>
        .receipt-image {
            height: 40px;
            width: 100%;
        }

        .item_txt1 {
            font-size: 12px;
        }


        .item_txt2 {
            font-size: 12px;
        }

        /* for xiao ji, total amount */
        .item_txt3 {
            font-size: 15px;
        }

        .cl1 {
            width: 10%;
        }

        .cl2 {
            width: 20%;
        }

        .cl3 {
            width: 5%;
        }

        .cl4 {
            width: 15%;
        }

        .cl11 {
            width: 25%;
        }

        .cl12 {
            width: 20%;
        }

        .img-payment {
            width: 30%;
        }

        @media only screen and (min-width: 600px) {
            .receipt-image {
                height: 80px;
                width: 100%;
            }

            .item_txt1 {
                font-size: 20px;
            }


            .item_txt2 {
                font-size: 20px;
            }

            /* for xiao ji, total amount */
            .item_txt3 {
                font-size: 24px;
            }

            .img-fluid{
                height: 180px;
                width: 180px;
            }
        }
    </style>
</head>

<body>
    <?php include "../assets/includes/script.inc.php"; ?>

    <header><?php include_once "../assets/block-admin-page/header.php"; ?></header>

    <main class="container">
        <div class="row">
            <div class="col-12">
                <div class="container border border-secondary">
                    <div id="order_item_list">
                        <?php

                        $cartList = $order->getCart()->getCartItems();
                        foreach ($cartList as $cartItem):
                        ?>

                        <div class="col-12 mb-3" id="<?= $cartItem->getBarcode() ?>">
                            <div class="row">
                                <!-- Cart item information -->
                                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 col-xl-7">

                                    <!-- Item name display -->
                                    <div class="h4 font-weight-bold"><?= $cartItem->getItem()->getName(); ?></div>
                                    <!-- Item name display -->

                                    <!-- Variety property display -->
                                    <div class="h6 grey-text"><?= $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getProperty(); ?></div>
                                    <!-- Variety property display -->

                                    <!-- Quantity control -->
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <div class="col-xs-12 col-sm-12 col-md-3"><div class="h6">数量：</div></div>
                                        <div class="col-xs-12 col-sm-12 col-md-9 text-center">
                                            <button type="submit" name="quantityDecreaseButton" class="btn btn-primary btn-sm quantity-decrease-button" value="<?= $cartItem->getBarcode() ?>">-</button>
                                            <input type="number" class="mx-3 my-3 cart-item-quantity" value="<?php echo $cartItem->getQuantity(); ?>" style="width: 45px" disabled>
                                            <button type="submit" name="quantityIncreaseButton" class="btn btn-primary btn-sm quantity-increase-button" value="<?= $cartItem->getBarcode() ?>">+</button>
                                        </div>
                                    </div><!-- Quantity control -->

                                    <!-- Remove button and price display -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <button type="submit" name="removeItem" class="btn btn-primary btn-sm p-2 card-link-secondary small" value="<?= $cartItem->getBarcode() ?>">
                                                <i class="fas fa-trash-alt mr-1"></i>移除
                                            </button>
                                        </div>
                                        <span>RM<?= number_format($cartItem->getSubPrice(), 2, '.', ''); ?></span>
                                    </div><!-- Remove button and price -->

                                </div><!-- Cart item information price display-->

                            </div>
                        </div>

                        <script>
                            <?php $inventoryVariableName = "inventory_" . $cartItem->getBarcode(); ?>
                            <?php $quantityVariableName = "quantity_" . $cartItem->getBarcode(); ?>

                            let <?= $inventoryVariableName ?> = <?= $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getTotalQuantity(); ?>;
                            let <?= $quantityVariableName ?> = $("#<?= $cartItem->getBarcode() ?> .cart-item-quantity").val();

                            if(<?= $quantityVariableName; ?> >= <?= $inventoryVariableName; ?>){
                                $("#<?= $cartItem->getBarcode() ?> .quantity-increase-button").attr('disabled', 'disabled');
                            } else if(<?= $quantityVariableName; ?> <= 1){
                                $("#<?= $cartItem->getBarcode() ?> .quantity-decrease-button").attr('disabled', 'disabled');
                            }
                        </script>

                    <?php endforeach; ?>
                    </div>
                    <div class="row">
                        <div style="width: 55%"></div>
                        <div class="cl11 text-center"><b class='item_txt3'>小计</b></div>
                        <div class="cl12 text-center"><b class='item_txt3' style="float: right;">RM<span id="t_price"><?php echo number_format($order->getCart()->getSubtotal(), 2, '.', '')  ?></span></b></div>
                    </div>
                    <div class="row">
                        <div style="width: 55%"></div>
                        <div class="cl11 text-center"><b class='item_txt3'>邮费 </b></div>
                        <div class="cl12 text-center"><b class='item_txt3' style="float: right;">RM<span id="t_price"><?php echo number_format($order->getCart()->getShippingFee(), 2, '.', '')  ?></span></b></div>
                    </div>
                    <div class="row" style="width:auto;height:5px;background-color: black;"></div>
                    <div class="row">
                        <div style="width: 55%"></div>
                        <div class="cl11 text-center"><b class='item_txt3'>总计 </b></div>
                        <div class="cl12 text-center"><b class='item_txt3' style="float: right;">RM<span id="t_price"><?php $total = $order->getCart()->getSubtotal() + $order->getCart()->getShippingFee();
                                                                                                                        echo number_format($total, 2, '.', ''); ?></span></b></div>
                    </div>
                </div>
            </div>

        </div>


    </main>

</body>
</html>
