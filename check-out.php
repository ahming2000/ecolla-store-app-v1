<?php
/* Initialization */
// Standard variable declaration
$title = "结账 | Ecolla e口乐";

// Auto loader for classes
include "assets/includes/class-auto-loader.inc.php";

// Database Interaction
$cart = new Cart();
$view = new View();
$controller = new Controller();

/* Operation */
if (isset($_POST["submit"])) {

    $customer = new Customer($_POST["c_name"], $_POST["c_phone_mcc"], $_POST["c_phone"], $_POST["c_address"], $_POST["c_state"], $_POST["c_area"], $_POST["c_postal_code"]);
    $order = new Order($customer);
    $order->orderNow($cart, $_POST['o_payment_method']);
    $cart->resetCart();

    UsefulFunction::uploadReceipt($_FILES["receipt"], $order->getOrderId());


    $controller->insertNewOrder($order);
    header("location: order-successfully.php?orderId=" . $order->getOrderId());
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include "assets/includes/stylesheet.inc.php"; ?>
</head>

<body>

    <?php include "assets/includes/script.inc.php"; ?>

    <header><?php include "assets/block-user-page/header.php"; ?></header>

    <main class="container">

        <div class="row">
            <div class="col-md-0 col-lg-2"></div>
            <div class="col-md-12 col-lg-8">
                <div class="h1">结账界面</div>

                <!--Havent do @media-->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="container border border-secondary">
                            <div id="order_item_list">
                                <?php

                                $cartList = $cart->getCartItems();
                                for ($i = 0; $i < sizeof($cartList); $i++) {
                                    $cartItem = $cartList[$i];
                                    $totalWeight = $cartItem->getQuantity() * $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getWeight();
                                    $subPrice = $cartItem->getSubPrice();

                                    echo "<div class=\"row\" style=\"height: 100px\">
                                        <div class=\"col-2 p-1 \"><img src=\"assets/images/items/" . $view->getItemId($cartItem->getItem()) . "/0.png\" style=\"height: 90px; width: auto;\"></div>
                                        <div class=\"col-3 pt-3 \"><b style=\"font-size: 18px;\">" . $cartItem->getItem()->getBrand() . " " . $cartItem->getItem()->getName() . "</b></div>
                                        <div class=\"col-2 pt-3 \"><b style=\"font-size: 18px;\">" . $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getProperty() . "</b></div>



                                        <div class=\"col-3 pt-3 \"><b style=\"font-size: 20px; float: right;\"> " . $cartItem->getQuantity() . " * RM" . $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getPrice() . " = </b></div>
                                        <div class=\"col-2 pt-3 \"><b style=\"font-size: 20px;float: right;\">RM<span id=\"t_price\">" . number_format($cartItem->getSubPrice(), 2) . "</span></b></div>
                                        </div>";

                                    //backup
                                    // echo "<div class=\"row\" style=\"height: 100px\">
                                    // <div class=\"col-1 p-1\"><img src=\"assets/images/items/" . $view->getItemId($cartItem->getItem()) . "/0.png\" style=\"height: 90px; width: auto;\"></div>
                                    //     <div class=\"col-3 pt-3\"><b style=\"font-size: 26px;\">" . $cartItem->getItem()->getBrand() . " " . $cartItem->getItem()->getName() . "</b></div>
                                    //     <div class=\"col-1 pt-4\"><b style=\"font-size: 15px;\">" . $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getProperty() . "</b></div>
                                    //     <div class=\"col-1 pt-4\"><b style=\"font-size: 20px;\">" . $totalWeight . "kg</b></div>

                                    //     <div class=\"col-1 pt-3\"></div>

                                    //     <div class=\"col-3 pt-3\"><b style=\"font-size: 32px; float: right;\">" . $cartItem->getQuantity() . " * RM" . $subPrice . " = </b></div>
                                    //     <div class=\"col-2 pt-3\"><b style=\"font-size: 32px;float: right;\">RM<span id=\"t_price\">" . number_format($cartItem->getSubPrice(), 2) . "</span></b></div>
                                    // </div>";
                                }
                                ?>
                            </div>
                            <div class="row" style="height: 50px;">
                                <div class="col-7"></div>
                                <div class="col-3"><b style="font-size: 24px;float: right;">小计</b></div>
                                <div class="col-2"><b style="font-size: 24px;float: right;">RM<span id="t_price"><?php echo number_format($cart->getSubtotal(), 2)  ?></span></b></div>
                            </div>
                            <div class="row" style="height: 50px;">
                                <div class="col-7"></div>
                                <div class="col-3"><b style="font-size: 24px;float: right;">邮费 </b></div>
                                <div class="col-2"><b style="font-size: 24px;float: right;">RM<span id="t_price"><?php echo number_format($cart->getShippingFee(), 2)  ?></span></b></div>
                            </div>
                            <div class="row" style="width:auto;height:5px;background-color: black;"></div>
                            <div class="row" style="height: 50px;">
                                <div class="col-7"></div>
                                <div class="col-3"><b style="font-size: 24px;float: right;">总计 </b></div>
                                <div class="col-2"><b style="font-size: 24px;float: right;">RM<span id="t_price"><?php $total = $cart->getSubtotal() + $cart->getShippingFee();
                                                                                                                    echo number_format($total, 2); ?></span></b></div>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="" method="post" enctype="multipart/form-data">

                    <!-- Make Payment -->
                    <div class="form-row mb-3 p-3">
                        <div class="col-12">
                            <div class="row">
                                <input type="text" name="o_payment_method" id="selected-payment-method" value="TnG" hidden/>
                                <div class="col-12"><label><strong>请点击付款方式进行付款</strong></label></div>
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 view zoom payment-method active">
                                    <input type="text" value="TnG" hidden />
                                    <img class="img-fluid" src="assets/images/payment/tng.png" alt="image">
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 view zoom payment-method">
                                    <input type="text" value="Boost" hidden />
                                    <img class="img-fluid" src="assets/images/payment/boost.png" alt="image">
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 view zoom payment-method">
                                    <input type="text" value="Bank Transfer" hidden />
                                    <img class="img-fluid" src="assets/images/payment/bank-transfer.png" alt="image">
                                </div>
                            </div>
                        </div>
                    </div><!-- Make Payment -->

                    <!-- User name -->
                    <div class="form-group">
                        <label>名字（英文名）</label>
                        <input type="text" class="form-control" name="c_name" aria-describedby="nameHelp" placeholder="e.g. Alex Lee" required>
                        <small id="nameHelp" class="form-text text-muted">请输入可辨认的名字，我们将会以这个名字进行邮寄</small>
                    </div><!-- User name -->

                    <!-- Phone number -->
                    <div class="form-row mb-3">
                        <div class="col-12"><label>电话号码</label></div>
                        <div class="col-sm-4 col-md-3 col-lg-2"><select class="form-control" name="c_phone_mcc" id="c-phone-mcc"></select></div>
                        <div class="col-sm-8 col-md-5 col-lg-4"><input type="text" class="form-control" name="c_phone" aria-describedby="phoneHelp" placeholder="电话号码" required></div>
                        <div class="col-12"><small id="phoneHelp" class="form-text text-muted">电话号码格式：+60 12-1234 5678</small></div>
                    </div><!-- Phone number -->

                    <!-- Address (House Number and Street) -->
                    <div class="form-row mb-2">
                        <div class="col-12"><label>地址</label></div>
                        <div class="col-12 mb-1"><input type="text" name="c_address" class="form-control" placeholder="门牌/路名" autocomplete="off" required /></div>
                        <div class="col mb-1" id="c-state"><input type="text" name="c_state" class="form-control" placeholder="州属" autocomplete="off" required /></div>
                        <div class="col mb-1" id="c-area"><input type="text" name="c_area" class="form-control" placeholder="地区/城市" disabled autocomplete="off" required /></div>
                        <div class="col mb-1" id="c-postal-code"><input type="text" name="c_postal_code" class="form-control" placeholder="邮政编号" disabled autocomplete="off" required /></div>
                    </div><!-- Address (House Number and Street) -->

                    <!-- Upload Receipt -->
                    <div class="form-group">
                        <label>上传收据</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="receipt" id="receipt">
                            <label class="custom-file-label" for="receipt" data-browse="上传">请上传您的收据</label>
                        </div>
                    </div><!-- Upload Receipt -->

                    <div class="text-center"><input class="btn btn-primary" type="submit" value="提交" name="submit" style="width: 200px;"></div>

                </form>
            </div>
            <div class="col-md-0 col-lg-2"></div>
        </div>




    </main>

    <footer><?php include "assets/block-user-page/footer.php"; ?></footer>

    <script>

        $(document).ready(function() {
            bsCustomFileInput.init() //For file uploaded name to show

            // For payment method select
            $(".payment-method").on("click", function(){
                $(".payment-method").removeClass('active');
                $(this).addClass('active');

                var method = $(this).children('input').val();
                $('#selected-payment-method').val(method);
                url = "assets/images/payment/pay_" + method.toLowerCase() + ".png";
                window.open(url, 'Image', 'width=400px, height=400px, resizable=1');
            });

            //add phone number mmc
            addPhoneMCC("+60");
            addPhoneMCC("+65");

        });

        function addPhoneMCC(option) {
            let str =
            `
                <option value="${option}">
                    ${option}
                </option>
            `;
            $("#c-phone-mcc").append(str);
        }

    </script>

    <script src="assets/js/post_code.js"></script>

</body>

</html>
