<div class="col-12 mb-3" id="<?= $cartItem->getBarcode() ?>">
    <div class="row">

        <!-- Cart Item Image -->
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 col-xl-5">
            <div class="view zoom z-depth-1 rounded mb-3">
                <?php $imgPath = file_exists("assets/images/items/" . $view->getItemId($cartItem->getItem()) . "/" . $cartItem->getBarcode() . ".jpg") ? $cartItem->getBarcode() . ".jpg" : "0.jpg"; ?>
                <a href="items/<?= $cartItem->getItem()->getName() ?>"><img src="assets/images/items/<?= $view->getItemId($cartItem->getItem()); ?>/<?= $imgPath; ?>" class="w-100" height="250"></a>
            </div>
        </div><!-- Cart Item Image -->

        <!-- Cart item information -->
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 col-xl-7">

            <!-- Item name display -->
            <div class="h4 font-weight-bold"><?= $cartItem->getItem()->getName(); ?></div>
            <!-- Item name display -->

            <!-- Variety property display -->
            <div class="h6 grey-text"><?= $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getProperty(); ?></div>
            <!-- Variety property display -->

            <!-- Weight display -->
            <?php $totalWeight = $cartItem->getQuantity() * $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getWeight(); ?>
            <div class="h6 text-muted"><?= $totalWeight . "kg"; ?></div>
            <!-- Weight display -->

            <!-- Quantity control -->
            <div class="row d-flex justify-content-between align-items-center">
                <div class="col-xs-12 col-sm-12 col-md-3"><div class="h6">数量：</div></div>
                <div class="col-xs-12 col-sm-12 col-md-9 text-center">
                    <button type="submit" name="quantityDecreaseButton" class="btn btn-primary btn-sm quantity-decrease-button" value="<?= $cartItem->getBarcode() ?>">-</button>
                    <input type="number" class="mx-3 my-3 cart-item-quantity" value="<?php echo $cartItem->getQuantity(); ?>" style="width: 45px" disabled>
                    <button type="submit" name="quantityIncreaseButton" class="btn btn-primary btn-sm quantity-increase-button" value="<?= $cartItem->getBarcode() ?>">+</button>
                </div>
            </div><!-- Quantity control -->

            <!-- Remove button and price display -->
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <button type="submit" name="removeItem" class="btn btn-primary card-link-secondary small" value="<?= $cartItem->getBarcode() ?>">
                        <i class="fas fa-trash-alt mr-1"></i>移除
                    </button>
                </div>
                <span>RM<?= number_format($cartItem->getSubPrice(), 2); ?></span>
            </div><!-- Remove button and price -->

        </div><!-- Cart item information price display-->

    </div>
</div>

<script>
    <?php $inventoryVariableName = "inventory_" . $cartItem->getBarcode(); ?>
    <?php $quantityVariableName = "quantity_" . $cartItem->getBarcode(); ?>

    let <?= $inventoryVariableName ?> = <?= $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getTotalQuantity(); ?>;
    let <?= $quantityVariableName ?> = $("#<?= $cartItem->getBarcode() ?> .cart-item-quantity").val();

    if(<?= $quantityVariableName; ?> >= <?= $inventoryVariableName; ?>){
        $("#<?= $cartItem->getBarcode() ?> .quantity-increase-button").attr('disabled', 'disabled');
    } else if(<?= $quantityVariableName; ?> <= 1){
        $("#<?= $cartItem->getBarcode() ?> .quantity-decrease-button").attr('disabled', 'disabled');
    }
</script>
