<?php include "assets/includes/class-auto-loader.inc.php"; //Auto include classes when needed. ?>
<?php $cart = new Cart(); ?>
<?php




?>
<!DOCTYPE html>
<html>
<head>
    <?php $title = "订单追踪 | Ecolla ε口乐"; include "assets/includes/stylesheet-script-declaration.inc.php" ?>
    <!-- To-do: Meta for google searching -->
</head>

<body>

    <?php $c = $cart; include "assets/block-user-page/header.php"; ?>

    <wrapper class="d-flex flex-column">
        <main class="flex-fill"> <!--put content-->

            <div class="container">
                <div id="result">
                    <?php
                        if(isset($_GET["orderId"])){
                            $view = new View();
                            $o_delivery_id = $view->getDeliveryId($_GET["orderId"]);
                            if($o_delivery_id != null){
                                echo "Your delivery id is ".$o_delivery_id;
                            } else{
                                echo "Your order is currently in process or order not found.";
                            }
                        }
                    ?>
                </div>


            </div>


        </main>

        <section>
            <?php include "assets/block-user-page/footer.php"; ?>
        </section>

    </wrapper>
</body>
</html>
