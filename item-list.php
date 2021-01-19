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
$categories = $view->getCategoryList();

/* Operation */
// Calculate value for pagination
$MAX_ITEMS = $view->getMaxItemsPerPage();
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$page = is_numeric($page) ? $page : 0 ; // Avoid non number value in url
$start = ($page - 1) * $MAX_ITEMS;

$categoryFilter = isset($_GET['category']) ? $_GET['category'] : "";
$keywordSearch = isset($_GET['search']) ? $_GET['search'] : "";


$names = $view->itemListFilter($keywordSearch, $categoryFilter, $page);
$itemCount = sizeof($names);
$totalPage = ceil($itemCount / $MAX_ITEMS);

$items = array();
for($i = $start; $i < $start + $MAX_ITEMS; $i++){
    if(isset($names[$i])){
        $item = $view->getItem($names[$i]);
        $items[] = $item;
    }
}


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
            <div class="col-sm-12 col-md-6">
                <form action="/item-list.php" method="get">

                    <div class="form-row">
                        <div class="col-10">
                            <!-- Item searching -->
                            <input type="text" class="form-control" maxlength="20" name="search" value="<?= isset($_GET["search"]) ? $_GET["search"] : ""; ?>" />
                        </div>
                        <div class="col-2">
                            <input type="submit" class="btn btn-primary p-2 mt-0" value="搜索"/>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Category Filter -->
            <div class="col-sm-12 col-md-6">
                <select name="category" id="categorySelector" class="custom-select mb-3" style="width: 100%">
                    <option value="" <?= isset($_GET["category"]) ? "selected" : ""; ?>>全部商品 (<?= $view->getItemTotalCountListed(); ?>)</option>

                    <?php foreach($categories as $category) : ?>
                        <option value="<?= $category["cat_name"]; ?>" <?= @$_GET["category"] == $category["cat_name"] ? "selected" : ""; ?>>
                            <?= $category["cat_name"] . " (" . $view->getCategoryTotalCount($category["cat_name"]) . ")"; ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div><!-- Category Filter -->

        </div>

        <div class="row mb-3">
            <?php
            foreach($items as $item){
                $i_id = $view->getItemId($item);
                include "assets/block-user-page/item-block.php";
            }
            ?>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <nav>
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?= $page == 1 ? "disabled" : ""; ?>">
                            <a class="page-link" id="previous-page-button" <?= $page == 1 ? "tabindex='1' aria-disabled='true'" : ""; ?>>上一页</a>
                        </li>

                        <?php for($i = 1; $i <= $totalPage; $i++) : ?>
                            <li class="page-item <?= $page == $i ? "active" : ""; ?>" value="<?= $i; ?>"><a class="page-link page-number-link"><?= $i; ?></a></li>
                        <?php endfor; ?>

                        <li class="page-item<?= $page == $totalPage ? " disabled" : ""; ?>">
                            <a class="page-link" id="next-page-button" <?= $page == $totalPage ? "tabindex='1' aria-disabled='true'" : ""; ?>>下一页</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

    </main>

    <footer><?php include "assets/block-user-page/footer.php"; ?></footer>

    <script>
    $(document).ready(function(){
        // Category bar onchange bar
        $("#categorySelector").on("change", function(){
            if($("#categorySelector option:selected").val() !== ""){
                window.location.href = "item-list.php?<?= isset($_GET["search"]) ? "search=" . $_GET["search"] . "&" : ""; ?>category=" + $("#categorySelector option:selected").val();
            } else{
                window.location.href = "item-list.php<?= isset($_GET["search"]) ? "?search=" . $_GET["search"] : ""; ?>";
            }

        });

        $("#previous-page-button").on("click", function(){
            window.location.href = "item-list.php?<?= isset($_GET["search"]) ? "search=" . $_GET["search"] . "&" : ""; ?><?= isset($_GET["category"]) ? "category=" . $_GET["category"] . "&" : ""; ?>page=<?= ($page - 1) ?>";
        });

        $("#next-page-button").on("click", function(){
            window.location.href = "item-list.php?<?= isset($_GET["search"]) ? "search=" . $_GET["search"] . "&" : ""; ?><?= isset($_GET["category"]) ? "category=" . $_GET["category"] . "&" : ""; ?>page=<?= ($page + 1) ?>";
        });

        $(".page-number-link").on("click", function(e){
            window.location.href = "item-list.php?<?= isset($_GET["search"]) ? "search=" . $_GET["search"] . "&" : ""; ?><?= isset($_GET["category"]) ? "category=" . $_GET["category"] . "&" : ""; ?>page=" + $(this).parent().val();
        });
    });

</script>
</body>
</html>
