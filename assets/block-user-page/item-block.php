<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
    <div class="card">
        <a href="items/<?php echo $item->getBrand() ?>-<?php echo $item->getName() ?>.php">
            <img src="assets/images/items/<?php echo $i_id; ?>/0.jpg" class="card-img-top" alt="image">
        </a>
        <div class="card-body">
            <h5 class="card-title"><?php echo $item->getName() ?></h5>
            <span>
                <?php
                    $price = $item->getVarieties()[0]->getPrice() * $item->getVarieties()[0]->getDiscountRate();
                    echo "RM".number_format($price, 2);
                ?>
            </span>
        </div>
    </div>
</div>
