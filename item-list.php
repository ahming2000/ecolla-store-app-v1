<?php include "assets/includes/class-auto-loader.inc.php"; //Auto include classes when needed. ?>
<?php $cart = new Cart(); ?>
<!DOCTYPE html>
<html>
    <head>
        <?php $title = "商品列表 | Ecolla ε口乐"; include "assets/includes/stylesheet-script-declaration.inc.php" ?>
    </head>

    <body>

        <?php $c = $cart; include "assets/block-user-page/header.php"; ?>

    <wrapper class="d-flex flex-column">
    <main class="flex-fill">

        <div class="container mt-5">
            <div class="row">

                <?php
                    $view = new View();
                    $itemList = $view->getAllItems();



                    foreach($itemList as $i){
                        $item = $i;
                        $i_id = $view->getItemId($item);
                        if($item->isListed()){
                            include "assets/block-user-page/item-block.php";
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
