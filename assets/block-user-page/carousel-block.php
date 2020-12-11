<?php
/*  Variable require for this block
    1. $imgList

    Adjustable variable
    1. $carouselTimeInterval (Default: "10000") (Value unit in miliseconds)
    2. $carouselId (Default: "carousel-block")
    3. $upperDirectoryCount (Default: "")

 */

 //Set default value // '@' is to ignore the error message on null variable
 if (@$upperDirectoryCount == null) $upperDirectoryCount = 0;
 if (@$carouselTimeInterval == null) $carouselTimeInterval = "10000";
 if (@$carouselId == null) $carouselId = "imgSlide";

 //Exception Error Handling
 if (@$imgList == null) die("Carousel block error: Image(s) data is missing!");

 //Initial
 $SYMBOL = "../";
 $upperDirectory = "";
 for($i = 0; $i < $upperDirectoryCount; $i++){
     $upperDirectory = $upperDirectory.$SYMBOL;
 }
 ?>

<div id="<?= $carouselId ?>" class="carousel slide m-0" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php for($i = 0; $i < sizeof($imgList); $i++) : ?>
        <li data-target='#<?= $carouselId ?>' data-slide-to='<?= $i ?>' <?= $i == 0 ? "class='active'" : ""; ?>></li>
        <?php endfor; ?>
        <!-- Original Pattern: <li data-target="#imgSlide" data-slide-to="{slide index}"></li> -->
    </ol>

    <div class="carousel-inner">
        <?php for($i = 0; $i < sizeof($imgList); $i++) : ?>
        <div class="carousel-item <?= $i == 0 ? "active" : ""; ?>">
            <img class='d-block w-100' src='<?= $imgList[$i] ?>' data-interval='<?= $carouselTimeInterval ?>'>
        </div>
        <?php endfor; ?>
        <!--
        <div class="carousel-item">
            <img class="d-block w-100" src={img directory} data-interval="10000">
        </div>
         -->
    </div>

    <a class="carousel-control-prev" href="#<?= $carouselId ?>" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#<?= $carouselId ?>" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
