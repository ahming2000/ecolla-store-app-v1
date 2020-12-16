<div class="col-xs-12 col-sm-4">
    <div class="h5"><?= $item->getVarieties()[0]->getPropertyName(); ?>：</div>
</div>

<input id="barcode" type="text" name="barcode" value="<?= $item->getVarieties()[0]->getBarcode(); ?>" hidden/>
<input id="inventory" type="text" value="<?= $item->getVarieties()[0]->getTotalQuantity(); ?>" hidden/>

<div class="col-xs-12 col-sm-8">
    <ol class="list-group variety-selector">
        <?php for($i = 0; $i < sizeof($item->getVarieties()); $i++) : ?>
            <li class="list-group-item <?= $i == 0 ? "active" : "" ?>">
                <input type="text" class="variety-barcode" value="<?= $item->getVarieties()[$i]->getBarcode(); ?>" hidden/>
                <input type="text" class="variety-inventory" value="<?= $item->getVarieties()[$i]->getTotalQuantity(); ?>" hidden/>
                <?= $item->getVarieties()[$i]->getProperty() ?>
            </li>
        <?php endfor; ?>
    </ol>
</div>
