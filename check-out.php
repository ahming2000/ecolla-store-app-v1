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
// Redirect the page if there is no item in the cart
if(empty($cart->getCartItems())) header("location: item-list.php");

if (isset($_POST["submit"])) {

    // Initialize new information
    $customer = new Customer($_POST["c_name"], $_POST["c_phone_mcc"], $_POST["c_phone"], $_POST["c_address"], $_POST["c_state"], $_POST["c_area"], $_POST["c_postal_code"]);
    $order = new Order($customer);
    $order->orderNow($cart, $_POST['o_payment_method']);

    // Upload Receipt
    UsefulFunction::uploadReceipt($_FILES["receipt"], $order->getOrderId());

    // Insert order
    $controller->insertNewOrder($order);

    // Reset cart
    $cart->resetCart();

    // Redirect to order successful page
    header("location: order-successfully.php?orderId=" . $order->getOrderId());
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include "assets/includes/stylesheet.inc.php"; ?>
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
        }
    </style>
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

                                    echo "<div class=\"row\">
                                        <div class=\"cl1\"><img class='receipt-image' src=\"assets/images/items/" . $view->getItemId($cartItem->getItem()) . "/0.png\"></div>
                                        <div class=\"cl2 text-center \"><b class='item_txt1'>" . $cartItem->getItem()->getName() . "</b></div>
                                        <div class=\"cl2 text-center \"><b class='item_txt1'>" . $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getProperty() . "</b></div>

                                        <div class='cl3'></div>
                                        <div class='cl3'></div>

                                        <div class='cl3 text-center'><b class='item_txt2'>" . $cartItem->getQuantity() . "</b></div>
                                        <div class='cl3 text-center'><b class='item_txt2'>*</b></div>
                                        <div class='cl4 text-center'><b class='item_txt2'>RM" . $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getPrice() . " =</b></div>
                                        <div class=\"cl4 text-right\"><b class='item_txt2'>RM<span id=\"t_price\">" . number_format($cartItem->getSubPrice(), 2) . "</span></b></div>
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
                            <div class="row">
                                <div style="width: 55%"></div>
                                <div class="cl11 text-center"><b class='item_txt3'>小计</b></div>
                                <div class="cl12 text-center"><b class='item_txt3' style="float: right;">RM<span id="t_price"><?php echo number_format($cart->getSubtotal(), 2)  ?></span></b></div>
                            </div>
                            <div class="row">
                                <div style="width: 55%"></div>
                                <div class="cl11 text-center"><b class='item_txt3'>邮费 </b></div>
                                <div class="cl12 text-center"><b class='item_txt3' style="float: right;">RM<span id="t_price"><?php echo number_format($cart->getShippingFee(), 2)  ?></span></b></div>
                            </div>
                            <div class="row" style="width:auto;height:5px;background-color: black;"></div>
                            <div class="row">
                                <div style="width: 55%"></div>
                                <div class="cl11 text-center"><b class='item_txt3'>总计 </b></div>
                                <div class="cl12 text-center"><b class='item_txt3' style="float: right;">RM<span id="t_price"><?php $total = $cart->getSubtotal() + $cart->getShippingFee();
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
                                <input type="text" name="o_payment_method" id="selected-payment-method" value="TnG" hidden />
                                <div class="col-12"><label><strong>请点击付款方式进行付款</strong></label></div>
                                <div class="img-payment view zoom payment-method active">
                                    <input type="text" value="TnG" hidden />
                                    <img class="img-fluid" src="assets/images/payment/tng.png" alt="image">
                                </div>
                                <div class="img-payment view zoom payment-method">
                                    <input type="text" value="Boost" hidden />
                                    <img class="img-fluid" src="assets/images/payment/boost.png" alt="image">
                                </div>
                                <div class="img-payment view zoom payment-method">
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
                        <div style="width: 30%"><select class="form-control" name="c_phone_mcc" id="c-phone-mcc"></select></div>
                        <!--class="col-sm-8 col-md-5 col-lg-4"-->
                        <div style="width: 50%"><input type="text" class="form-control" name="c_phone" aria-describedby="phoneHelp" placeholder="电话号码" required></div>
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
                            <input type="file" class="custom-file-input" name="receipt" id="receipt" required>
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
            bsCustomFileInput.init(); //For uploaded file name to show

            // For payment method select
            $(".payment-method").on("click", function() {
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

        // Image file validater
        // Reference: https://stackoverflow.com/questions/4234589/validation-of-file-extension-before-uploading-file
        var validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];
        function validateImage(fileInput) {

            if (fileInput.type == "file") {
                var fileName = fileInput.value;

                if (fileName.length > 0) {

                    var valid = false;
                    for (var j = 0; j < validFileExtensions.length; j++) {
                        var cur = validFileExtensions[j];
                        if (fileName.substr(fileName.length - cur.length, cur.length).toLowerCase() == cur.toLowerCase()) {
                            valid = true;
                            break;
                        }
                    }

                    if (!valid) {
                        alert("请上传格式正确的图像");
                        return false;
                    }
                }
            }

            return true;
        }

        // Validate image extension before submit
        $("#receipt").on("change", function(){
            if (!validateImage(document.getElementById("receipt"))){
                document.getElementById("receipt").value = ''; // Empty the file upload input if wrong extension
            }
        });
        
    </script>

    <script src="assets/js/post_code.js"></script>

</body>

</html>
