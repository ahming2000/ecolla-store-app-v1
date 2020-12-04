<?php include "assets/includes/class-auto-loader.inc.php"; //Auto include classes when needed. ?>
<?php
if($_GET["orderId"] == null) header("location: index.php");
$cart = new Cart();

 ?>
<?php
$alertType = "";
$message = "";
if(isset($_GET["orderId"])){

    $view = new View();

}



?>
<!DOCTYPE html>
<html>
<head>
    <?php $title = "下单成功 | Ecolla ε口乐"; include "assets/includes/stylesheet-script-declaration.inc.php" ?>
    <!-- To-do: Meta for google searching -->
</head>

<body>

    <?php $c = $cart; include "assets/block-user-page/header.php"; ?>

    <wrapper class="d-flex flex-column">
        <main class="flex-fill"> <!--put content-->

            <div class="container">




            </div>


        </main>

        <section>
            <?php include "assets/block-user-page/footer.php"; ?>
        </section>

    </wrapper>
</body>
</html>
