<?php
/* Initialization */
// Standard variable declaration
$upperDirectoryCount = 1;

// Auto loader for classes
include "../assets/includes/class-auto-loader.inc.php";

// Database Interaction
$cart = new Cart();
$view = new View();
$controller = new Controller();

// Get item information
$item = $view->getItem("好味屋手撕素肉排");

$i_id = $view->getItemId($item);
$title = $item->getBrand() . " " . $item->getName() . " | Ecolla ε口乐";

/* Operation */
// Add view count to database
$controller->addViewCount($item);

// Add to cart action
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cartItem = new CartItem($item, $_POST['quantity'], $_POST['barcode'], "");
    $inventoryQuantity = $item->getVarieties()[$cartItem->getVarietyIndex()]->getTotalQuantity();

    if ($cart->isDuplicated($cartItem)) {

        $cur_count = $_POST['quantity'];
        $existing_item_count = $cart->getSpecificCartItem($_POST['barcode'])->getQuantity();

        if ($cur_count + $existing_item_count <= $inventoryQuantity) // if the existing item count and current count does not exceed max_count
            $cart->editQuantity($_POST['barcode'], $cur_count);
        else // This adds item to the max_count since they already added more than 10
            $cart->editQuantity($_POST['barcode'], 10 - $existing_item_count);

        //Will work on disabling the add item, or show a notification if existing item count has already exceeded the max value
    } else {
        $cart->addItem($cartItem);
    }
}


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
                                    <?php $isSoldOut = $item->getVarieties()[0]->getTotalQuantity() == 0 ? true : false; ?>
                                    <button class="btn secondary-color" type="submit" id="add-to-cart-button" <?= $isSoldOut ? "disabled" : ""; ?>>
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
