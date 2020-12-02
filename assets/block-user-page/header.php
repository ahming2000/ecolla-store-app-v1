<?php
//Set default value // '@' is to ignore the error message on null variable
if (@$upperDirectoryCount == null) $upperDirectoryCount = 0;

//Initial
$SYMBOL = "../";
$upperDirectory = "";
for($i = 0; $i < $upperDirectoryCount; $i++){
    $upperDirectory = $upperDirectory.$SYMBOL;
}
?>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow">
    <div class="container">
        <a class="navbar-brand" href="<?php echo $upperDirectory; ?>index.php">
            <img src="<?php echo $upperDirectory; ?>assets/images/icon/ecolla_icon.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
            ε口乐
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="fa fa-bars"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="<?php echo $upperDirectory; ?>index.php">主页</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo $upperDirectory; ?>item-list.php">所有商品列表</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo $upperDirectory; ?>payment-method.php">付款方式</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo $upperDirectory; ?>about-us.php">关于我们</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo $upperDirectory; ?>order-tracking.php">订单追踪</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo $upperDirectory; ?>cart.php"><i class="icofont-shopping-cart mx-1"></i><span><?php echo $c->getCartCount(); ?></span></a></li>
        </ul>
    </div>
</div>
</nav>

<div style="margin-top: 56px;"></div><!-- To create a margin on the top of the content -->

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
    } else if (getCurentFileName() === "order-tracking.php") {
        $(".navbar-nav li:nth-child(5)").addClass("active");
    }

});

$(document).ready(function() {
    $('.navbar').addClass('navbar-custom');
    // Transition effect for navbar
    $(window).scroll(function() {
        if($(this).scrollTop() > 5) {
            $('.navbar').addClass('navbar-change');
            $('.navbar').removeClass('navbar-custom');
        }
        else {
            $('.navbar').addClass('navbar-custom');
            $('.navbar').removeClass('navbar-change');
        }
    });
});
</script>
