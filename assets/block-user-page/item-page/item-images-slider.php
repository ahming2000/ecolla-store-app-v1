<div class="col-12 slider-control-main-container mb-3">
    <div class="slider-control-prev rounded"><img class="img-fluid" src="../assets/images/alt/prev-button-alt.png" /></div>
    <div class="slider-control-next rounded"><img class="img-fluid" src="../assets/images/alt/next-button-alt.png" /></div>
    <div class="slider-container">
        <?php for($i = 0; $i < $item->getImgCount(); $i++) : ?>
            <img class="img-fluid general-img" src="../assets/images/items/<?= $i_id; ?>/<?= $i; ?>.jpg"/>
        <?php endfor; ?>

        <?php foreach($item->getVarieties() as $variety) : ?>
            <?php if(file_exists("../assets/images/items/$i_id/" . $variety->getBarcode() . ".jpg")) : ?>
                <img class="img-fluid variety-img" id="img-<?= $variety->getBarcode(); ?>" src="../assets/images/items/<?= $i_id; ?>/<?= $variety->getBarcode(); ?>.jpg"/>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

<div class="col-12 slider-control-nav-container mb-3">
    <div class="slider-nav-control-prev rounded"><img class="img-fluid" src="../assets/images/alt/prev-button-alt.png" /></div>
    <div class="slider-nav-control-next rounded"><img class="img-fluid" src="../assets/images/alt/next-button-alt.png" /></div>
    <div class="slider-nav-container">
        <ul class="slider-nav">

            <?php for($i = 0; $i < $item->getImgCount(); $i++) : ?>
                <li><img class="img-fluid" src="../assets/images/items/<?= $i_id; ?>/<?= $i; ?>.jpg"/></li>
            <?php endfor; ?>

            <?php foreach($item->getVarieties() as $variety) : ?>
                <?php if(file_exists("../assets/images/items/$i_id/" . $variety->getBarcode() . ".jpg")) : ?>
                    <li><img class="img-fluid" src="../assets/images/items/<?= $i_id; ?>/<?= $variety->getBarcode(); ?>.jpg"/></li>
                <?php endif; ?>
            <?php endforeach; ?>

        </ul>
    </div>
</div>
