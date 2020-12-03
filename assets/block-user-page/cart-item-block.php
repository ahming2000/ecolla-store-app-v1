<div class="col-12 mb-3" id="<?php echo $cartItem->getBarcode() ?>">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="view zoom overlay z-depth-1 rounded mb-3 mb-md-0">
                        <a href="items/"><img src="assets/images/items/<?php echo $view->getItemId($cartItem->getItem()); ?>/0.png" class="w-100" height="250"></a>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                    <div class="cart-item-info">
                        <div class="item-title h4 font-weight-bold"><?php echo $cartItem->getItem()->getBrand() . " " . $cartItem->getItem()->getName(); ?></div>
                        <div class="item-properties h6 grey-text"><?php echo $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getProperty(); ?></div>
                        <div class="item-note h6 grey-text"><?php echo $cartItem->getNote() ?></div>
                        <div class="item-total-weight h6 grey-text"><?php $totalWeight = $cartItem->getQuantity() * $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getWeight();
                                                                    echo $totalWeight . "kg" ?></div>

                        <div class="row d-flex justify-content-between align-items-center">
                            <div class="col-xs-12 col-sm-12 col-md-3">
                                <div class="h6">数量：</div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 quantity-button-control data-update-enable">
                                <button type="button" class="btn btn-primary decrease-button btn-sm mx-3 my-3">-</button>
                                <input type="number" class="mx-3 my-3 quantity-number" value="<?php echo $cartItem->getQuantity(); ?>" style="width: 45px" disabled>
                                <button type="button" class="btn btn-primary increase-button btn-sm mx-3 my-3">+</button>
                            </div>
                        </div>

                        <div class="item-action-price d-flex justify-content-between align-items-center">
                            <div><a type="button" class="remove-item-button card-link-secondary small text-uppercase mr-3"><i class="fas fa-trash-alt mr-1"></i>移除</a></div>
                            <span class="item-price">RM<?php echo number_format($cartItem->getSubPrice() * $cartItem->getQuantity(), 2); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<script>
    $(function() {
        let cartItem_obj = {
            barcode: "<?php echo $cartItem->getBarcode() ?>",
            quantity: 1
        };

        $("#<?php echo $cartItem->getBarcode() ?> .quantity-button-control button").on("click", function() {
            let price = <?php echo $cartItem->getSubPrice() ?>,
                quantity = <?php echo $cartItem->getQuantity() ?>,
                pricePerItem = price / quantity;

            let MAX_COUNT = 10;

            var count = $(this).parent().children('input').val();

            if ($(this).hasClass("increase-button")) {
                $(this).parent().children('input').val(++count);

                if ($(this).parent().children('input').val() == MAX_COUNT) {
                    $(this).attr('disabled', 'disabled');
                    $(this).parent().children('.decrease-button').removeAttr('disabled');
                } else {
                    $(this).removeAttr('disabled');
                    $(this).parent().children('.decrease-button').removeAttr('disabled');
                }

                $.ajax({
                    type: "POST",
                    url: 'cart.php',
                    dataType: 'json',
                    data: {
                        addItemQuantity: JSON.stringify(cartItem_obj)
                    }
                });
            } else if ($(this).hasClass("decrease-button")) {
                $(this).parent().children('input').val(--count);

                if ($(this).parent().children('input').val() == 1) {
                    $(this).parent().children('.increase-button').removeAttr('disabled');
                    $(this).attr('disabled', 'disabled');
                } else {
                    $(this).parent().children('.increase-button').removeAttr('disabled');
                    $(this).removeAttr('disabled');
                }

                $.ajax({
                    type: "POST",
                    url: 'cart.php',
                    dataType: 'json',
                    data: {
                        minusItemQuantity: JSON.stringify(cartItem_obj)
                    }
                });
            }

            $("#<?php echo $cartItem->getBarcode() ?> .item-price").html(`RM${(pricePerItem * $(this).parent().children('input').val()).toFixed(2)}`);

        });

        $("#<?php echo $cartItem->getBarcode() ?> .remove-item-button").on("click", function() {
            $.ajax({
                type: "POST",
                url: 'cart.php',
                dataType: 'json',
                data: {
                    removeItem: JSON.stringify(cartItem_obj)
                }
            });
            $("#<?php echo $cartItem->getBarcode() ?>").remove();
        });
    });
</script>
