<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
    <div class="card">
        <img src="<?php echo $item->getImgPaths()[0]; ?>" class="card-img-top" alt="image">
        <div class="card-body">
            <h5 class="card-title"><?php echo $item->getName() ?></h5>
            <span><?php echo "RM".$item->getVarieties()[0]->getPrice() ?></span>
        </div>
    </div>
</div>