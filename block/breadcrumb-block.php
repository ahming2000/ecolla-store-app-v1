<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../item-list.php">商品列表</a></li>
        <li class="breadcrumb-item">
            <a href="../items-list.php?catogory=<?php echo $itemCatogory; ?>">
                <?php echo $itemCatogory?>
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $itemName ?></li>
    </ol>
</nav>