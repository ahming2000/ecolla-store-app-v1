<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
    <div class="card">
        <img src="<?php echo $item->getImgPath(); ?>" class="card-img-top" alt="image">
        <div class="card-body">
            <!-- To-do: Item Bandage -->
            <h5 class="card-title"><?php echo $item->getName() ?></h5>
            <span><?php "RM".$item->getPrice() ?></span>
        </div>
    </div>
</div>