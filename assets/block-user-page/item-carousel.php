<div class="item">
    <div class="card">
        <a href="items/<?= $item->getName(); ?>.php">
            <img class="card-img-top" src="assets/images/items/<?= $view->getItemId($item); ?>/0.jpg">
        </a>
        <div class="card-body">
            <h5 class="card-title"><?= $item->getName();  ?></h5>
            <p class="card-text text-muted">RM<?= number_format($item->getVarieties()[0]->getPrice(), 2); ?></p>
        </div>
    </div>
</div>
