<div class="col-xs-12 col-sm-7 col-lg-6 quantity-button-control mt-2">
    <?php $isSoldOut = $item->getVarieties()[0]->getTotalQuantity() == 0 ? true : false; ?>
    <button type="button" class="btn btn-primary btn-sm quantity-decrease-button" disabled>-</button>
    <input type="number" class="mx-2" id="quantity" name="quantity" value="<?= $isSoldOut ? "0" : "1"; ?>" style="width: 45px;" <?= $isSoldOut ? "disabled" : ""; ?>>
    <button type="button" class="btn btn-primary btn-sm quantity-increase-button" <?= $isSoldOut ? "disabled" : ""; ?>>+</button>
</div>
