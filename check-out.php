<?php include "assets/includes/class-auto-loader.inc.php"; //Auto include classes when needed. ?>
<?php $cart = new Cart(); ?>
<?php
    if(isset($_POST["submit"])){

        $customer = new Customer($_POST["nameInput"], $_POST["phoneNumberInputHead"], $_POST["phoneNumberInputTail"], $_POST["addressInputLine"], $_POST["addressInputPostalCode"], $_POST["addressInputCity"], $_POST["addressInputState"]);
        $order = new Order($customer);
        $order->orderNow($cart);
        $cart->resetCart();

        UsefulFunction::uploadReceipt($_FILES["receipt"], $order->getOrderId());

        $controller = new Controller();
        $controller->insertNewOrder($order);
        header("location: order-tracking.php?orderId=".$order->getOrderId()."&checkOut=1");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php $title = "结账 | Ecolla e口乐"; include "assets/includes/stylesheet-script-declaration.inc.php" ?>
    </head>

    <body>

        <?php $c = $cart; include "assets/block-user-page/header.php"; ?>

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
                    <div class="col-4"><input type="text" class="form-control" name="phoneNumberInputHead" placeholder="e.g. 012" required></div>
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
        $(document).ready(function () {
            bsCustomFileInput.init() //For file uploaded name to show
        })
        </script>

    </body>
</html>
