<style>/*can move it to css file later, just for demo*/
.btn1 {
  position: absolute;
  top: 50%;
  right: 90%;
  background-color: rgba(71, 71, 107, 0.5);
  border: none;
  font-size: 20px;
  cursor: pointer;
  z-index: 2;
}
.btn2{
  position: absolute;
  top: 50%;
  left: 90%;
  background-color: rgba(71, 71, 107, 0.5);
  border: none;
  font-size: 20px;
  cursor: pointer;
  z-index: 2;
}
</style>

<div class="col-12 mb-3">
    <div class="btn1 slider-nav-control-prev"><img class="img-fluid" src="../assets/images/alt/prev-button-alt.png" /></div>
    <div class="btn2 slider-nav-control-next"><img class="img-fluid" src="../assets/images/alt/next-button-alt.png" /></div>
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

<div class="col-12 mb-3">
    <div class="row slider-control-container">
        <div class="col-2 slider-nav-control-prev"><img class="img-fluid" src="../assets/images/alt/prev-button-alt.png" /></div>
        <div class="col-8 slider-nav-container">
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
        <div class="col-2 slider-nav-control-next"><img class="img-fluid" src="../assets/images/alt/next-button-alt.png" /></div>
    </div>
</div>
