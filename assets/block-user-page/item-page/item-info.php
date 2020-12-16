<div class="col-12">
    <div class="h2 font-weight-bold"><?= $item->getBrand().$item->getName(); ?></div>
</div>
<div class="col-12 mb-3">
    <?php $i = 0; ?>
    <?php foreach($item->getVarieties() as $variety) : ?>
        <?php if($variety->getDiscountRate() != 1.0) : ?>
            <div class="h4 price-view" id="variety-<?= $variety->getBarcode(); ?>" <?= $i++ != 0 ? "hidden" : ""; ?>>
                <span class="grey-text mr-1" style="font-size: 15px"><del>RM<?= number_format($variety->getPrice(), 2); ?></del></span>
                <span class="red-text font-weight-bold mr-1"><strong>RM<?= number_format($variety->getPrice() * $variety->getDiscountRate(), 2); ?></strong></span>
                <span class="badge badge-danger mr-1"><?= (1 - $variety->getDiscountRate()) * 100 ?>% OFF<span>
            </div>
        <?php else : ?>
            <div class="h4 price-view pl-3 font-weight-bold blue-text" id="variety-<?= $variety->getBarcode(); ?>" <?= $i++ != 0 ? "hidden" : ""; ?>>
                <strong>RM<?= number_format($variety->getPrice(), 2); ?></strong>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
