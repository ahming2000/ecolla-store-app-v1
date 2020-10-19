<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">
        <img src="../assets/images/icon/ecolla_icon.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
            ε口乐
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">主页</a></li>
                <li class="nav-item"><a class="nav-link" href="item-list.php">所有商品列表</a></li>
                <li class="nav-item"><a class="nav-link" href="payment-method.php">付款方式</a></li>
                <li class="nav-item"><a class="nav-link" href="about-us.php">关于我们</a></li>
                <li class="nav-item"><a class="nav-link" href="cart.php"><i class="icofont-shopping-cart mx-1"></i><span id="cartCount"></span></a></li>
            </ul>
        </div>
    </div>
</nav>

<div style="margin-top: 56px;"></div><!-- To create a margin on the top of the content -->

<?php if($isItemPage) include "../block/breadcrumb-block.php"; ?>

<script>
$(document).ready(function() {

    function getCurentFileName() {
        var pagePathName = $(location).attr('href');
        var fileName = pagePathName.substring(pagePathName.lastIndexOf("/") + 1);
        return fileName;
    }

    if (getCurentFileName() === "index.php") {
        $(".navbar-nav li:nth-child(1)").addClass("active");
    } else if (getCurentFileName() === "item-list.php") {
        $(".navbar-nav li:nth-child(2)").addClass("active");
    } else if (getCurentFileName() === "payment-method.php") {
        $(".navbar-nav li:nth-child(3)").addClass("active");
    } else if (getCurentFileName() === "about-us.php") {
        $(".navbar-nav li:nth-child(4)").addClass("active");
    }

});
</script>