<?php include "assets/includes/class-auto-loader.inc.php"; //Auto include classes when needed. ?>
<?php $cart = new Cart(); ?>
<!DOCTYPE html>
<html>
<head>
    <?php $title = "付款方式 | Ecolla ε口乐"; include "assets/includes/stylesheet-script-declaration.inc.php" ?>
</head>
<body>

    <?php $c = $cart; include "assets/block-user-page/header.php"; ?>

    <wrapper class="d-flex flex-column">
        <main class="flex-fill"> <!--put content-->
            <div class="container">
                <h1 class="mt-4 mb-3">付款方式</h1>
                <p>这是我们能接受的付款通道</p>
                <div class="row shadow p-3 m-2 mx-auto">
                    <div class="col-6 col-md-3 col-sm-6">
                        <img src="assets/images/icon/pay-cash.png" alt="image" height="100" width="100">
                    </div>
                    <div class="col-6 col-md-9 col-sm-6 pt-4">
                        <h5>Cash</h5>
                    </div>
                </div>

                <div class="row shadow p-3 m-2 mx-auto">
                    <div class="col-6 col-md-3 col-sm-6">
                        <img src="assets/images/icon/pay-boost.jpg" alt="image" height="100" width="100">
                    </div>
                    <div class="col-6 col-md-9 col-sm-6 pt-4">
                        <h5>Boost</h5>
                    </div>
                </div>

                <div class="row shadow p-3 m-2 mx-auto">
                    <div class="col-6 col-md-3 col-sm-6">
                        <img src="assets/images/icon/pay-tnc.jpg" alt="image" height="100" width="100">
                    </div>
                    <div class="col-6 col-md-9 col-sm-6 pt-4">
                        <h5>Touch 'n Go</h5>
                    </div>
                </div>

                <div class="row shadow p-3 m-2 mx-auto">
                    <div class="col-6 col-md-3 col-sm-6">
                        <img src="assets/images/icon/pay-fpx.jpeg" alt="image" height="100" width="100">
                    </div>
                    <div class="col-6 col-md-9 col-sm-6 pt-4">
                        <h5>Online Banking</h5>
                    </div>
                </div>
            </div>

        </main>

        <section>
            <?php include "assets/block-user-page/footer.php"; ?>
        </section>

    </wrapper>
</body>
</html>
