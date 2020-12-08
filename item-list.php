<?php
    include "assets/includes/class-auto-loader.inc.php";
    $cart = new Cart();
    $view = new View();

    $pageName = "item-list.php";

    $MAX_ITEMS = $view->getMaxItemsPerPage();
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page - 1) * $MAX_ITEMS;

    $itemCount = isset($_GET['catogory']) ? $view->getCatogoryTotalCount($_GET['catogory']) : $view->getItemTotalCount();
    $totalPage = ceil($itemCount / $MAX_ITEMS);

    $items = isset($_GET['catogory']) ? $view->getItemWithSpecificCatogory($_GET['catogory'], $start, $MAX_ITEMS) : $view->getItemsWithRange($start, $MAX_ITEMS);
 ?>

<!DOCTYPE html>
<html>
    <head>
        <?php
            $title = "商品列表 | Ecolla ε口乐";
            include "assets/includes/stylesheet-script-declaration.inc.php"
         ?>
    </head>

    <body>

        <?php $c = $cart; include "assets/block-user-page/header.php"; ?>

    <wrapper class="d-flex flex-column">
    <main class="flex-fill">

        <div class="container mt-5">

            <div class="row mb-3">
                <div class="col-12">
                    <div class="row">
                        <div class="col-6">
                            <form action="" method="get">

                                <div class="form-row">
                                    <div class="col-10">
                                        <!-- Item searching -->
                                        <input type="text" class="form-control" maxlength="20"/>
                                    </div>
                                    <div class="col-2">
                                        <input type="submit" class="btn btn-primary btn-block" name="searchButton" value="搜索"/>
                                    </div>
                                </div>

                            </form>
                        </div>

                        <div class="col-6">
                            <select name="catogory" id="catogorySelector" class="custom-select mb-3" style="width: 100%">
                                <option value="" <?php if (@$_GET["catogory"] == null) echo "selected"; ?>><?php echo "全部商品 (".$view->getItemTotalCount().")"; ?></option>

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

            <div class="row mb-3">
                <?php



                    foreach($items as $item){
                        $i_id = $view->getItemId($item);
                        if($item->isListed()){
                            include "assets/block-user-page/item-block.php";
                        }
                    }

                ?>
            </div>

            <div class="row">
                <div class="col-12">

                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= $page == 1 ? "disabled" : ""; ?>">
                                <a class="page-link" href="<?= isset($_GET['catogory']) ? $pageName . "?catogory=" . $_GET['catogory'] . "&page=" . ($page - 1) : $pageName . "?page=" . ($page - 1); ?>" id="previous-button" <?= $page == 1 ? "tabindex='1' aria-disabled='true'" : ""; ?>>上一页</a>
                            </li>
                            <?php for($i = 1; $i <= $totalPage; $i++) : ?>
                                <li class="page-item <?= $page == $i ? "active" : ""; ?>"><a class="page-link" href="<?= isset($_GET['catogory']) ? $pageName . "?catogory=" . $_GET['catogory'] . "&page=" . $i : $pageName . "?page=" . $i; ?>"><?= $i; ?></a></li>
                            <?php endfor; ?>
                            <li class="page-item<?= $page == $totalPage ? " disabled" : ""; ?>">
                                <a class="page-link" href="<?= isset($_GET['catogory']) ? $pageName . "?catogory=" . $_GET['catogory'] . "&page=" . ($page + 1) : $pageName . "?page=" . ($page + 1); ?>" id="next-button" <?= $page == $totalPage ? "tabindex='1' aria-disabled='true'" : ""; ?>>下一页</a>
                            </li>
                        </ul>
                    </nav>

                </div>
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
            if($("#catogorySelector option:selected").val() !== ""){
                window.location.href = "item-list.php?catogory=" + $("#catogorySelector option:selected").val();
            } else{
                window.location.href = "item-list.php";
            }

        });
    });

</script>
    </body>
</html>
