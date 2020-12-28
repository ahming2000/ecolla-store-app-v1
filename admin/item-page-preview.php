<?php
if(!isset($_GET["itemName"])) header("location: index.php");

/* Initialization */
// Standard variable declaration
$mode = "admin";
$upperDirectoryCount = 1;

// Auto loader for classes
include "../assets/includes/class-auto-loader.inc.php";

// Database Interaction
$cart = new Cart();
$view = new View();
$controller = new Controller();

// Get item information
$item = $view->getItem($_GET["itemName"]);

$i_id = $view->getItemId($item);
$title = "商品界面预览";

?>

<!DOCTYPE html>
<html>

<head>
    <?php include "../assets/includes/stylesheet.inc.php" ?>
    <!-- To-do: Meta for google searching -->
</head>

<style>
.slider-nav li {
    display: inline;
}

</style>

<body>

    <?php include "../assets/includes/script.inc.php"; ?>

    <header><?php include "../assets/block-user-page/header.php"; ?></header>

    <main class="container">

        <!-- Breadcrumb -->
        <?php include "../assets/block-user-page/item-page/breadcrumb.php"; ?>
        <!-- Breadcrumb -->

        <!-- Item Information -->
        <div class="row">
            <!-- Item Images Slider -->
            <div class="col-md-5 mb-4">
                <div class="row">
                    <?php include "../assets/block-user-page/item-page/item-images-slider.php"; ?>
                </div>
            </div><!-- Item Images Slider -->

            <!-- Item Purchasing Option -->
            <div class="col-md-7 mb-4 p-4">
                <div class="row">

                    <!-- Item category badge -->
                    <?php include "../assets/block-user-page/item-page/item-category-badge.php"; ?>
                    <!-- Item category badge -->

                    <!-- Item information -->
                    <?php include "../assets/block-user-page/item-page/item-info.php"; ?>
                    <!-- Item information -->

                    <div class="col-12">
                        <form action="" method="post">
                            <div class="row mb-3">
                                <!-- Property selector -->
                                <?php include "../assets/block-user-page/item-page/item-property-selector.php"; ?>
                                <!-- Property selector -->
                            </div>

                            <div class="row mb-3 text-center">
                                <!-- Quantity control interface -->
                                <?php include "../assets/block-user-page/item-page/item-quantity-control-interface.php"; ?>
                                <!-- Quantity control interface -->

                                <!-- Submit button -->
                                <div class="col-xs-12 col-sm-5 col-lg-6">
                                    <button class="btn secondary-color" type="submit" id="add-to-cart-button">
                                        加入购物车<i class="fas fa-shopping-cart ml-1"></i>
                                    </button>
                                </div><!-- Submit button -->
                            </div>
                        </form>
                    </div>

                </div>
            </div><!-- Item Purchasing Option -->


        </div><!-- Item Information -->

    </main>

    <footer><?php include "../assets/block-user-page/footer.php"; ?></footer>

    <?php include "../assets/block-user-page/item-page/item-images-slider-config.php"; ?>

    <?php include "../assets/block-user-page/item-page/item-page-info-controller.php"; ?>

</body>

</html>
