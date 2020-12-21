<?php
/* Initialization */
// Standard variable declaration
$title = "商品列表 | Ecolla ε口乐";
$pageName = "item-list.php";

// Auto loader for classes
include "assets/includes/class-auto-loader.inc.php";

// Database Interaction
$cart = new Cart();
$view = new View();

/* Operation */
// Calculate value for pagination
$MAX_ITEMS = $view->getMaxItemsPerPage();
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $MAX_ITEMS;

$itemCount = isset($_GET['category']) ? $view->getCatogoryTotalCount($_GET['category']) : $view->getItemTotalCountListed();
$totalPage = ceil($itemCount / $MAX_ITEMS);

$items = isset($_GET['category']) ? $view->getItemWithSpecificCatogory($_GET['category'], $start, $MAX_ITEMS) : $view->getItemsWithRange($start, $MAX_ITEMS);

?>

<!DOCTYPE html>
<html>
<head>
    <?php include "assets/includes/stylesheet.inc.php"; ?>
</head>

<body>

    <?php include "assets/includes/script.inc.php"; ?>

    <header><?php include "assets/block-user-page/header.php"; ?></header>

    <main class="container">

        <div class="row mb-3">
            <div class="col-6">
                <form action="" method="get">

                    <div class="form-row">
                        <div class="col-9">
                            <!-- Item searching -->
                            <input type="text" class="form-control" maxlength="20"/>
                        </div>
                        <div class="col-3">
                            <input type="submit" class="btn btn-primary" name="searchButton" value="搜索"/>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Catogory Filter -->
            <div class="col-6">
                <select name="category" id="categorySelector" class="custom-select mb-3" style="width: 100%">
                    <option value="" <?php if (@$_GET["category"] == null) echo "selected"; ?>><?php echo "全部商品 (".$view->getItemTotalCountListed().")"; ?></option>

                    <?php
                    $catList = $view->getCatogoryList();
                    foreach($catList as $category){
                        echo "<option value='".$category["cat_name"]."'";
                        if (@$_GET["category"] == $category["cat_name"]) echo " selected";
                        echo ">".$category["cat_name"]." (".$view->getCatogoryTotalCount($category["cat_name"]).")</option>";
                    }
                    ?>
                </select>
            </div><!-- Catogory Filter -->

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

        <div class="row mb-3">
            <div class="col-12">
                <nav>
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?= $page == 1 ? "disabled" : ""; ?>">
                            <a class="page-link" href="<?= isset($_GET['category']) ? $pageName . "?category=" . $_GET['category'] . "&page=" . ($page - 1) : $pageName . "?page=" . ($page - 1); ?>" id="previous-button" <?= $page == 1 ? "tabindex='1' aria-disabled='true'" : ""; ?>>上一页</a>
                        </li>
                        <?php for($i = 1; $i <= $totalPage; $i++) : ?>
                            <li class="page-item <?= $page == $i ? "active" : ""; ?>"><a class="page-link" href="<?= isset($_GET['category']) ? $pageName . "?category=" . $_GET['category'] . "&page=" . $i : $pageName . "?page=" . $i; ?>"><?= $i; ?></a></li>
                        <?php endfor; ?>
                        <li class="page-item<?= $page == $totalPage ? " disabled" : ""; ?>">
                            <a class="page-link" href="<?= isset($_GET['category']) ? $pageName . "?category=" . $_GET['category'] . "&page=" . ($page + 1) : $pageName . "?page=" . ($page + 1); ?>" id="next-button" <?= $page == $totalPage ? "tabindex='1' aria-disabled='true'" : ""; ?>>下一页</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

    </main>

    <footer><?php include "assets/block-user-page/footer.php"; ?></footer>

    <script>
    $(document).ready(function(){
        // Catogory bar onchange bar
        $("#categorySelector").on("change", function(){
            if($("#categorySelector option:selected").val() !== ""){
                window.location.href = "item-list.php?category=" + $("#categorySelector option:selected").val();
            } else{
                window.location.href = "item-list.php";
            }

        });
    });

</script>
</body>
</html>
