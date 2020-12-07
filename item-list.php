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
                <div class="col-12">
                    <div class="row">
                        <div class="col-6">
                            <!-- Item searching -->
                        </div>

                        <div class="col-6 text-right">
                            <select name="catogory" id="catogorySelector" class="custom-select mb-3" style="width: 100%">
                                <option <?php if (@$_GET["catogory"] == null) echo "selected"; ?>><?php echo "全部商品 (".$view->getItemTotalCount().")"; ?></option>

                                <?php
                                $catList = $view->getCatogoryList();
                                foreach($catList as $catogory){
                                    echo "<option value='".$catogory["cat_name"]."'";
                                    if (@$_GET["catogory"] == $catogory["cat_name"]) echo " selected";
                                    echo ">".$catogory["cat_name"]." (".$view->getCatogoryTotalCount($catogory["cat_name"]).")</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
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
    $(document).ready(function(){
        // Catogory bar onchange bar
        $("#catogorySelector").on("change", function(){
            window.location.href = "item-list.php?catogory=" + $("#catogorySelector option:selected").val();
        });
    });

</script>
    </body>
</html>
