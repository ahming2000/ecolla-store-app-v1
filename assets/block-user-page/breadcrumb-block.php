<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../../item-list.php">商品列表</a></li>
            <li class="breadcrumb-item">
                <a href="../../items-list.php?catogory=<?php echo $i->getCatogory(); ?>">
                    <?php echo $i->getCatogory(); ?>
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $i->getBrand()." ".$i->getName(); ?></li>
        </ol>
    </nav>
</div>
