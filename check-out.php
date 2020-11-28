<?php include "assets/includes/class-auto-loader.inc.php"; //Auto include classes when needed. ?>
<?php $cart = new Cart(); ?>
<?php
    if(isset($_POST["submit"])){

        $customer = new Customer($_POST["nameInput"], $_POST["phoneNumberInputHead"], $_POST["phoneNumberInputTail"], $_POST["addressInputLine"], $_POST["addressInputPostalCode"], $_POST["addressInputCity"], $_POST["addressInputState"]);
        $order = new Order($customer);
        $order->orderNow($cart);
        
        $controller = new Controller();
        $controller->insertNewOrder($order);
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

            <form action="" method="post">
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
                        <input type="text" class="form-control" name="addressInputLine" placeholder="e.g. 123, Jalan 20, Taman Baru" required>
                    </div>

                    <div class="col-4 mb-3">
                        <label for="addressInputPostalCode">邮政编码（Postcode）</label>
                        <input type="text" class="form-control" name="addressInputPostalCode" placeholder="e.g. 81000" required>
                    </div>
                    <div class="col-4 mb-3">
                        <label for="addressInputCity">城市（City）</label>
                        <input type="text" class="form-control" name="addressInputCity" placeholder="e.g. Kampar" required>
                    </div>
                    <div class="col-4 mb-3">
                        <label for="addressInputState">州属（State）</label>
                        <input type="text" class="form-control" name="addressInputState" placeholder="e.g. Perak" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="receiptUpload">上传收据</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">请上传您的收据</label>
                    </div>
                </div>
                <input class="btn btn-primary btn-block" type="submit" value="提交" name="submit">
            </form>

        </div>

        <?php include "assets/block-user-page/footer.php"; ?>

    </body>
</html>
