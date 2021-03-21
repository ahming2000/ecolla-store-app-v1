<?php

/*  A few variable needed to declare first before include this pagination block
1. $upperDirectory : Retrieve global content need to get depth of the directories
2. $cart : Need to retrieve cart count to display the cart icon correctly
*/

//Set default value // '@' is to ignore the error message on null variable
if (@$upperDirectoryCount == null) $upperDirectoryCount = 0;

//Initial
$SYMBOL = "../";
$upperDirectory = "";
for($i = 0; $i < $upperDirectoryCount; $i++){
    $upperDirectory = $upperDirectory.$SYMBOL;
}

if (isset($_POST['changeLang'])){
    $cart->resetCart();
    header("location: " . $_POST['redirectLink']);
}

?>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow">
    <div class="container">
        <a class="navbar-brand" href="<?= $upperDirectory; ?>index.php">
            <img src="<?= $upperDirectory; ?>assets/images/icon/ecolla_icon.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
            εcolla
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="<?= $upperDirectory; ?>index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $upperDirectory; ?>item-list.php">All Item</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $upperDirectory; ?>payment-method.php">Payment Method</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $upperDirectory; ?>about-us.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $upperDirectory; ?>order-tracking.php">Order Tracking</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $upperDirectory; ?>cart.php"><i class="icofont-shopping-cart mx-1"></i><span><?= $cart->getCartCount(); ?></span></a></li>
                <?php if(UsefulFunction::getCurrentURL() !== "/EcollaWebsite/en/items") : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            EN
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <form action="" method="post">
                                <input type="text" name="redirectLink" value="<?= "../" . substr($_SERVER['PHP_SELF'], 18, strlen($_SERVER['PHP_SELF'])) ?>" hidden/>
                                <input type="submit" name="changeLang" value="CH" class="dropdown-item"/>
                            </form>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

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
    } else if (getCurentFileName() === "cart.php") {
        $(".navbar-nav li:nth-child(6)").addClass("active");
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
