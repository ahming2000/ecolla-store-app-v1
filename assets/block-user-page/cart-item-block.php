<div class="col-12 mb-3" id="<?= $cartItem->getBarcode() ?>">
    <div class="row">

        <!-- Cart Item Image -->
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 col-xl-5">
            <div class="view zoom z-depth-1 rounded mb-3">
                <?php $imgPath = file_exists("assets/images/items/" . $view->getItemId($cartItem->getItem()) . "/" . $cartItem->getBarcode() . ".jpg") ? $cartItem->getBarcode() . ".jpg" : "0.jpg"; ?>
                <a href="items/<?= $cartItem->getItem()->getName() ?>"><img src="assets/images/items/<?= $view->getItemId($cartItem->getItem()); ?>/<?= $imgPath; ?>" class="w-100" height="250"></a>
            </div>
        </div>

        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 col-xl-7">
            <div class="cart-item-info">
                <div class="item-title h4 font-weight-bold"><?php echo $cartItem->getItem()->getName(); ?></div>
                <div class="item-properties h6 grey-text"><?php echo $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getProperty(); ?></div>
                <div class="item-total-weight h6 grey-text"><?php $totalWeight = $cartItem->getQuantity() * $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getWeight();
                                                            echo $totalWeight . "kg" ?></div>

                <div class="row d-flex justify-content-between align-items-center">
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <div class="h6">数量：</div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-9 quantity-button-control data-update-enable">
                        <button type="submit" name="minusItemQuantity" class="btn btn-primary decrease-button btn-sm" value=<?php echo $cartItem->getBarcode() ?>>-</button>
                        <input type="number" class="mx-3 my-3 quantity-number" value="<?php echo $cartItem->getQuantity(); ?>" style="width: 45px" disabled>
                        <button type="submit" name="addItemQuantity" class="btn btn-primary increase-button btn-sm" value=<?php echo $cartItem->getBarcode() ?>>+</button>
                    </div>
                </div>

                <div class="item-action-price d-flex justify-content-between align-items-center">
                    <div><button type="submit" name="removeItem" class="remove-item-button card-link-secondary small text-uppercase mr-3 btn btn-primary" value=<?php echo $cartItem->getBarcode() ?>><i class="fas fa-trash-alt mr-1"></i>移除</button></div>
                    <span class="item-price">RM<?php echo number_format($cartItem->getSubPrice(), 2); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let count_<?php echo $cartItem->getBarcode() ?> = $("#<?php echo $cartItem->getBarcode() ?> .quantity-number").val();
    if(count_<?php echo $cartItem->getBarcode() ?> >= max_count){
        $("#<?php echo $cartItem->getBarcode() ?> .increase-button").attr('disabled', 'disabled');
    }else if(count_<?php echo $cartItem->getBarcode() ?> <= 1){
        $("#<?php echo $cartItem->getBarcode() ?> .decrease-button").attr('disabled', 'disabled');
    }
</script>
