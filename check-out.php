<?php include "assets/includes/class-auto-loader.inc.php"; //Auto include classes when needed. 
?>
<?php $cart = new Cart();
$view = new View(); ?>
<?php
if (isset($_POST["submit"])) {

    $customer = new Customer($_POST["nameInput"], $_POST["phoneNumberInputHead"], $_POST["phoneNumberInputTail"], $_POST["addressInputLine"], $_POST["addressInputPostalCode"], $_POST["addressInputCity"], $_POST["addressInputState"]);
    $order = new Order($customer);
    $order->orderNow($cart);
    $cart->resetCart();

    UsefulFunction::uploadReceipt($_FILES["receipt"], $order->getOrderId());

    $controller = new Controller();
    $controller->insertNewOrder($order);
    header("location: order-tracking.php?orderId=" . $order->getOrderId() . "&checkOut=1");
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php $title = "结账 | Ecolla e口乐";
    include "assets/includes/stylesheet-script-declaration.inc.php" ?>
</head>

<body>

    <?php $c = $cart;
    include "assets/block-user-page/header.php"; ?>

    <div class="container">

        <div class="h1">结账界面</div>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nameInput">名字/昵称</label>
                <input type="text" class="form-control" name="nameInput" aria-describedby="nameHelp" placeholder="e.g. Alex Lee" required>
                <small id="nameHelp" class="form-text text-muted">请输入可辨认的名字，我们将会以这个名字进行邮寄</small>
            </div>
            <div class="form-row mb-3">
                <div class="col-12"><label for="phoneNumberInput">电话号码</label></div>
                <div class="col-4" id="phoneNum_inputHead"><input type="text" class="form-control" name="phoneNumberInputHead" placeholder="e.g. 012" required autocomplete="off"></div>
                <div class="col-1 text-center">-</div>
                <div class="col-7"><input type="text" class="form-control" name="phoneNumberInputTail" placeholder="12345678" required></div>
                <div class="col-12"><small id="nameHelp" class="form-text text-muted">电话号码格式：012-12345678</small></div>
            </div>
            <div class="form-row">
                <div class="col-12 mb-3">
                    <label for="addressInputLine">地址</label>
                    <input type="text" class="form-control" name="addressInputLine" placeholder="e.g. 123, Jalan 20, Taman Baru, 82000 Kampar, Perak" required>
                </div>
            </div>
            <div class="form-row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <label for="payment">付款方式</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <input type="radio" name="paymentServices" /><img src="assets/images/icon/pay-cash.png" alt="image" height="50" width="50"><label for="cash">Cash</label>
                        </div>
                        <div class="col-3">
                            <input type="radio" name="paymentServices" /><img src="assets/images/icon/pay-boost.jpg" alt="image" height="50" width="50" style="padding-left: 5px;"><label for="boost" style="padding-left: 10px;">Boost Pay e-wallet</label>
                        </div>
                        <div class="col-3">
                            <input type="radio" name="paymentServices" /><img src="assets/images/icon/pay-tnc.jpg" alt="image" height="50" width="50"><label for="touchNgo">Touch N'go e-wallet</label>
                        </div>
                        <div class="col-3">
                            <input type="radio" name="paymentServices" /><img src="assets/images/icon/pay-fpx.jpeg" alt="image" height="50" width="50"><label for="ebanking">Online banking services</label>
                        </div>
                    </div>
                </div>
            </div>

            <!--Havent do @media-->
            <div class="form-row">
                <div class="col-12">
                    <label for="Order_generated">Your Order: </label>
                    <div class="container border border-secondary">
                        <div id="order_item_list">
                            <?php

                            $cartList = $cart->getCartItems();
                            for ($i = 0; $i < sizeof($cartList); $i++) {
                                $cartItem = $cartList[$i];
                                $totalWeight = $cartItem->getQuantity() * $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getWeight();
                                $subPrice = $cartItem->getSubPrice();

                                echo "<div class=\"row\" style=\"height: 100px\">
                                <div class=\"col-1 p-1\"><img src=\"assets/images/items/" . $view->getItemId($cartItem->getItem()) . "/0.png\" style=\"height: 90px; width: auto;\"></div>
                                    <div class=\"col-3 pt-3\"><b style=\"font-size: 26px;\">". $cartItem->getItem()->getBrand() . " " . $cartItem->getItem()->getName() . "</b></div>
                                    <div class=\"col-1 pt-4\"><b style=\"font-size: 15px;\">" . $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getProperty() . "</b></div>
                                    <div class=\"col-1 pt-4\"><b style=\"font-size: 20px;\">". $totalWeight ."kg</b></div>
                            
                                    <div class=\"col-1 pt-3\"></div>
                            
                                    <div class=\"col-3 pt-3\"><b style=\"font-size: 32px; float: right;\">". $cartItem->getQuantity() ." * RM".$subPrice." = </b></div>
                                    <div class=\"col-2 pt-3\"><b style=\"font-size: 32px;float: right;\">RM<span id=\"t_price\">". number_format($cartItem->getSubPrice(), 2) ."</span></b></div>
                                </div>";
                            }
                            ?>
                        </div>
                        <div class="row" style="width:auto;height:5px;background-color: black;"></div>
                        <div class="row" style="height: 50px;">
                            <div class="col-7"></div>
                            <div class="col-3"><b style="font-size: 32px;float: right;">Total Price:</b></div>
                            <div class="col-2"><b style="font-size: 32px;float: right;">RM<span id="t_price"><?php echo $cart->getSubtotal()  ?></span></b></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>上传收据</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="receipt" id="receipt">
                    <label class="custom-file-label" for="receipt" data-browse="上传">请上传您的收据</label>
                </div>
            </div>
            <div class="text-center"><input class="btn btn-primary" type="submit" value="提交" name="submit" style="width: 200px"></div>
        </form>

    </div>

    <?php include "assets/block-user-page/footer.php"; ?>
    <script>
        $(document).ready(function() {
            bsCustomFileInput.init() //For file uploaded name to show
            // $("input[name=phoneNumberInputHead]").focus(e => {
            //     $("#phoneNum_inputHead").append(`<div style="height: 100px; width: 400px; background-color: black; color: white; position: absolute; z-index: 2;"><p>Testing</p></div>`);
            // });

            // $("input[name=phoneNumberInputHead]").blur(e => {
            //     $("input[name=phoneNumberInputHead]").css("background-color", "white");
            // });

        })
    </script>

</body>

</html>