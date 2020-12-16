<div class="col-12 mb-3">
    <div class="row">
        <?php foreach($item->getCatogories() as $catogory) : ?>
            <a href="../item-list.php?catogory=<?= $catogory; ?>">
                <span class="badge badge-pill secondary-color mr-1 p-2"><?= $catogory; ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>
