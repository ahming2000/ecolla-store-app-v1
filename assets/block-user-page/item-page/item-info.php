<div class="col-12">
    <div class="h2 font-weight-bold"><?= $item->getName(); ?></div>
</div>

<div class="col-12">
    <div class="h6 text-muted">
        <span>已售出 <?= $view->getTotalPurchaseCount($item); ?> 个</span> |
        <span><?= $item->getViewCount(); ?> 次浏览</span>
    </div>
</div>

<div class="col-12 mb-3">
    <?php $i = 0; ?>
    <?php foreach($item->getVarieties() as $variety) : ?>
        <?php if($variety->getDiscountRate() != 1.0) : ?>
            <div class="h4 price-view discounted-price" id="variety-<?= $variety->getBarcode(); ?>" <?= $i++ != 0 ? "hidden" : ""; ?>>
                <span class="grey-text mr-1" style="font-size: 15px"><del>RM<?= number_format($variety->getPrice(), 2); ?></del></span>
                <span class="red-text font-weight-bold mr-1"><strong>RM<?= number_format($variety->getPrice() * $variety->getDiscountRate(), 2); ?></strong></span>
                <span class="badge badge-danger mr-1"><?= number_format((1 - $variety->getDiscountRate()) * 100, 0) ?>% OFF</span><br>
            </div>
        <?php else : ?>
            <div class="h4 price-view pl-3 font-weight-bold blue-text" id="variety-<?= $variety->getBarcode(); ?>" <?= $i++ != 0 ? "hidden" : ""; ?>>
                <?php if(!empty($item->getWholesales())) : ?>
                    <div class="price-view-normal" <?= $item->getWholesales()[0]->getMin() == 1 ? "hidden" : ""; ?>><strong>RM<?= number_format($variety->getPrice(), 2); ?></strong></div>
                    <?php for($j = 0; $j < sizeof($item->getWholesales()); $j++) : ?>
                        <div class="price-view-wholesale wholesale-<?= $item->getWholesales()[$j]->getMin(); ?>" <?= ($item->getWholesales()[0]->getMin() == 1 and $j == 0) ? "" : "hidden" ?>>
                            <span class="grey-text mr-1" style="font-size: 15px"><del>RM<?= number_format($variety->getPrice(), 2); ?></del></span>
                            <span class="orange-text font-weight-bold"><strong>RM<?= number_format($variety->getPrice() * $item->getWholesales()[$j]->getDiscountRate(), 2); ?></strong></span>
                            <span class="badge badge-warning mr-1"><?= number_format((1 - $item->getWholesales()[$j]->getDiscountRate()) * 100, 0) ?>% OFF</span>
                            <span class="grey-text mr-1" style="font-size: 10px">（批发价）</span>
                        </div>
                    <?php endfor; ?>
                <?php else: ?>
                    <div class="price-view-normal"><strong>RM<?= number_format($variety->getPrice(), 2); ?></strong></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php if(!empty($item->getWholesales())) : ?>

        <?php for($i = 0; $i < sizeof($item->getWholesales()); $i++) : ?>
            <div class="h6 wholesale-view" <?= $i != 0 ? "hidden" : ""; ?>>
                <?php $wholesalePrice = $variety->getPrice() * $item->getWholesales()[$i]->getDiscountRate(); ?>
                <input type="number" class="wholesale-min" value="<?= $item->getWholesales()[$i]->getMin() ?>" hidden/>
                <span class="grey-text">
                    购买至<?= $item->getWholesales()[$i]->getMin() ?>件可以以批发价 RM<?= number_format($wholesalePrice, 2); ?> 购买
                </span>
            </div>
        <?php endfor; ?>

    <?php endif; ?>
</div>
