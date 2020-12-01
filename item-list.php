<?php include "assets/includes/class-auto-loader.inc.php"; //Auto include classes when needed. ?>
<?php $cart = new Cart(); $view = new View(); ?>
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


                        <select name="catogory" class="custom-select mb-3" style="width: 300px;">
                            <option value="<?php @$_GET["catogory"] != null? $_GET["catogory"]: ""; ?>" selected><?php if(@$_GET["catogory"] != null) echo $_GET["catogory"]; else echo "点击进行分类...";?></option>
                            <?php
                            $catList = $view->getCatogoryList();
                            foreach($catList as $catogory){
                                echo '<option value="'.$catogory["cat_name"].'">'.$catogory["cat_name"].'</option>';
                            }
                            ?>
                        </select>
                        <input class="btn btn-primary" value="搜查" type="submit">
                        <button class="btn btn-secondary" type="button" onclick="removeCatogory()">取消分类</button>


                </form>




            </div>

            <div class="row">



                <?php

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

<script>
    function removeCatogory(){
        window.location.href = "item-list.php";
    }
</script>
    </body>
</html>
