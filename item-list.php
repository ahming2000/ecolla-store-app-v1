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

                <form action="item-list.php" method="get">
                    <select name="catogory" class="custom-select mb-3">
                        <option selected>打开选单选择类别/标签...</option>
                        <option value="饮料">饮料</option>
                        <option value="小零食">小零食</option>
                    </select>
                </form>

                <?php
                    $view = new View();
                    $itemList = $view->getAllItems();



                    foreach($itemList as $i){
                        $item = $i;
                        $i_id = $view->getItemId($item);
                        if($item->isListed()){
                            if(isset($_GET["catogory"])){
                                foreach($i->getCatogories() as $catogory){
                                    if($catogory == $_GET["catogory"]){
                                        include "assets/block-user-page/item-block.php";
                                        break;
                                    }
                                }
                            } else{
                                include "assets/block-user-page/item-block.php";
                            }

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
