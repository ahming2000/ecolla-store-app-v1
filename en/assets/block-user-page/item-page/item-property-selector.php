<div class="col-xs-12 col-sm-4">
    <div class="h5"><?= $item->getPropertyName(); ?>：</div>
</div>

<input id="barcode" type="text" name="barcode" value="<?= $item->getVarieties()[0]->getBarcode(); ?>" hidden/>
<input id="inventory" type="text" value="<?= $item->getVarieties()[0]->getTotalQuantity(); ?>" hidden/>

<div class="col-xs-12 col-sm-8">
    <ol class="list-group variety-selector">
        <?php for($i = 0; $i < sizeof($item->getVarieties()); $i++) : ?>
            <?php $totalQuantity = $item->getVarieties()[$i]->getTotalQuantity(); ?>
            <li class="list-group-item <?= $i == 0 ? "active" : "" ?>">
                <input type="text" class="variety-barcode" value="<?= $item->getVarieties()[$i]->getBarcode(); ?>" hidden/>
                <input type="text" class="variety-inventory" value="<?= $totalQuantity ?>" hidden/>
                <?= $item->getVarieties()[$i]->getProperty() ?>
                <?php if($totalQuantity == 0) : ?><span class="badge badge-danger mx-1">Sold Out<span><?php endif; ?>
            </li>
        <?php endfor; ?>
    </ol>
</div>
