<?php include "assets/php/includes/class-auto-loader.inc.php"; //Auto include classes when needed. ?>
<?php $cart = new Cart(); ?>
<?php
    if(isset($_POST["submit"])){
        $customer = array(
            "name" => $_POST["nameInput"],
            "phone" => $_POST["phoneNumberInputHead"].$_POST["phoneNumberInputTail"],
            "address" => $_POST["addressInputLine"],
            "postcode" => $_POST["addressInputPostalCode"],
            "city" => $_POST["addressInputCity"],
            "state" => $_POST["addressInputState"],
            "receiptPath" => "example path"
        );

        //To-do: debug the problem of same s_id insert to the database and same o_id as previous
        $order = new Order($customer);
        $order->createOrder($cart);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="assets/vendor/bootstrap-4.5.2-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/vendor/icofont/icofont.min.css">
        <link rel="stylesheet" href="deco.css">
        <link rel="shortcut icon" href="assets/images/icon/ecollafavicon.ico">
        <title>结账 | Ecolla e口乐</title>
    </head>
    <body>
        <!-- Important Thing To Declare -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="assets/vendor/bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
        <script src='https://kit.fontawesome.com/a076d05399.js'></script>

        <?php $c = $cart; include "block/header.php"; ?>

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

        <?php include "block/footer.php"; ?>

    </body>
</html>
