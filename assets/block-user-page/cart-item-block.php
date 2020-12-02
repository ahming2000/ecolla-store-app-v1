<div class="col-12 mb-3">
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
                        <div class="item-title h4 font-weight-bold"><?php echo $cartItem->getItem()->getBrand()." ".$cartItem->getItem()->getName(); ?></div>
                        <div class="item-properties h6 grey-text"><?php echo $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getProperty(); ?></div>
                        <div class="item-note h6 grey-text"><?php echo $cartItem->getNote() ?></div>
                        <div class="item-total-weight h6 grey-text"><?php $totalWeight = $cartItem->getQuantity() * $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getWeight(); echo $totalWeight.$cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getWeightUnit(); ?></div>

                        <div class="row d-flex justify-content-between align-items-center">
                            <div class="col-xs-12 col-sm-12 col-md-3"><div class="h6">数量：</div></div>
                            <div class="col-xs-12 col-sm-12 col-md-9 quantity-button-control data-update-enable">
                                <button type="button" class="btn btn-primary decrease-button btn-sm mx-3 my-3">-</button>
                                <input type="number" class="mx-3 my-3 quantity-number" value="<?php echo $cartItem->getQuantity(); ?>" style="width: 45px" disabled>
                                <button type="button" class="btn btn-primary increase-button btn-sm mx-3 my-3">+</button>
                            </div>
                        </div>

                        <div class="item-action-price d-flex justify-content-between align-items-center">
                            <div><a type="button" class="remove-item-button card-link-secondary small text-uppercase mr-3"><i class="fas fa-trash-alt mr-1"></i>移除</a></div>
                            <span class="item-price">RM<?php echo number_format($cartItem->getSubPrice(), 2); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
