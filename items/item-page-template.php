<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?php echo "$item->getName()" ?> | Ecolla ε口乐</title>
</head>

<body>
    <!-- Important Class Declaration -->
    <?php include "../assets/php/classes.php"; ?>

    <?php include "../block/header.php"; ?>



    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../item-list.php">商品列表</a></li>
                <li class="breadcrumb-item">
                    <a href="../items-list.php?catogory=<?php echo strtolower($item->getCatogory()) ?>">
                        <?php echo strtolower($item->getCatogory()) ?>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $item->getName(); ?></li>
            </ol>

        </nav>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                <!-- Item Picture Carousel -->
                <div class="col-xs-0 col-sm-0 col-md-0 col-lg-12">
                    <!-- Picture Selection for the Carousel -->
                </div>
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                <!-- Item Description -->
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>

</body>

</html>