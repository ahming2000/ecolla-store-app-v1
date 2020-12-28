<div class="col-12 mb-3">
    <div class="row">
        <?php foreach($item->getCategories() as $category) : ?>
            <a href="../item-list.php?category=<?= $category; ?>">
                <span class="badge badge-pill secondary-color mr-1 p-2"><?= $category; ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>
