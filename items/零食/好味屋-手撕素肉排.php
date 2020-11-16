<?php $upperDirectoryCount = 2; include "../../assets/php/includes/class-auto-loader.inc.php"; //Auto include classes when needed. ?>
<?php $cart = new Cart(); //Must declare first before have any output to continue the session ?>
<?php
$view = new View();
$item = $view->getItem("手撕素肉排");
?>
<?php
if($_SERVER['REQUEST_METHOD']=='POST')
{
    $cartItem = new CartItem($item, 1, $_POST['variety'], "");
    $cart->addItem($cartItem);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>好味屋 手撕素肉排 | Ecolla ε口乐</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="shortcut icon" href="../../assets/images/icon/ecollafavicon.ico">
    <link rel="stylesheet" href="../../assets/vendor/bootstrap-4.5.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/vendor/icofont/icofont.min.css">
    <link rel="stylesheet" href="../../deco.css">
</head>

<body>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="../../assets/vendor/bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>

    <?php $c = $cart; $upperDirectoryCount = 2; include __DIR__."\\..\\..\\block\\header.php"; ?>

    <wrapper class="d-flex flex-column">
        <main class="flex-fill"> <!--put content-->

            <?php $i = $item; include_once __DIR__."\\..\\..\\block\breadcrumb-block.php"; ?>

            <div class="container">
                <!--Grid row-->
                <div class="row">

                    <!--Grid column-->
                    <div class="col-md-6 mb-4">

                        <?php

                        $id = $view->getItemAttr("i_id", "i_name", "手撕素肉排");
                        $imgs = $view->getItemImgs("i_id", $id);
                        $imgList = array();

                        foreach($imgs as $img){
                            array_push($imgList, $img['imgPath']);
                        }
                        include "../../block/carousel-block.php";
                        ?>

                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-md-6 mb-4">

                        <!--Content-->
                        <div class="p-4">

                            <div class="mb-3">
                                <a href="">
                                    <span class="badge purple mr-1">零食</span>
                                </a>
                                <a href="">
                                    <span class="badge blue mr-1">新品</span>
                                </a>
                                <a href="">
                                    <span class="badge red mr-1">畅销</span>
                                </a>
                            </div>

                            <p class="lead">
                                <!-- <span class="mr-1  font-weight-bold">
                                <del>RM 3.00</del>
                            </span> -->
                            <span class="font-weight-bold" style="color:red;">RM 1.50</span>
                        </p>

                        <p class="lead font-weight-bold">好味屋手撕素肉排</p>

                        <form action="" method="post">
                            <div class="row">

                                <div class="col-xs-12 col-sm-4">
                                    <div class="h5">口味：</div>
                                </div>

                                <input id="variety" type="text" name="variety" value="6931754804900" hidden></input>

                                <div class="col-xs-12 col-sm-8 mb-3">
                                    <ol class="list-group">
                                        <li class="list-group-item active">香辣味26g</li>
                                        <li class="list-group-item">黑椒味26g</li>
                                        <li class="list-group-item">山椒味26g</li>
                                        <li class="list-group-item">烧烤味26g</li>
                                        <li class="list-group-item">黑鸭味26g</li>
                                    </ol>
                                </div>

                                <div class="d-flex justify-content-left">
                                    <!-- Default input -->
                                    <div class="col-xs-12 col-sm-8 quantity-button-control">
                                        <button type="button" class="btn btn-primary dropButton btn-sm mx-3 my-3"
                                        disabled>-</button>
                                        <input id="itemQuantity" name="itemQuantity" type="number" class="mx-3 my-3" value="1" style="width: 45px;"
                                        disabled>
                                        <button type="button" class="btn btn-primary addButton btn-sm mx-3 my-3">+</button>
                                    </div>
                                    <button class="btn btn-md my-0 p ml-1" style="color:white; background-color: #3c3e44;" type="submit">加入购物车
                                        <i class="fas fa-shopping-cart ml-1"></i>
                                    </button>
                                </div>

                            </div>

                        </form>

                    </div>
                    <!--Content-->

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->
        </div>
    </main>

    <?php include "../../block/footer.php"; ?>

</wrapper>

<script>
$(document).ready(function(){
    // For the item list to change the active properties
    $(".list-group li").on("click", function () {
        $(".list-group li").removeClass("active");
        $(this).addClass("active");

        if($(".list-group li:nth-child(1)").hasClass("active")){
            $("#variety").val("6931754804900");
        } else if($(".list-group li:nth-child(2)").hasClass("active")){
            $("#variety").val("6931754804917");
        } else if($(".list-group li:nth-child(3)").hasClass("active")){
            $("#variety").val("6931754804924");
        } else if($(".list-group li:nth-child(4)").hasClass("active")){
            $("#variety").val("6931754804931");
        } else if($(".list-group li:nth-child(5)").hasClass("active")){
            $("#variety").val("6931754805655");
        }

    });

    $(".quantity-button-control button").on("click", function () {

        let MAX_COUNT = 10;

        var count = $(this).parent().children('input').val();

        if ($(this).hasClass("addButton")) {
            $(this).parent().children('input').val(++count);

            if ($(this).parent().children('input').val() == MAX_COUNT) {
                $(this).attr('disabled', 'disabled');
                $(this).parent().children('.dropButton').removeAttr('disabled');
            } else {
                $(this).removeAttr('disabled');
                $(this).parent().children('.dropButton').removeAttr('disabled');
            }
        } else if ($(this).hasClass("dropButton")) {
            $(this).parent().children('input').val(--count);

            if ($(this).parent().children('input').val() == 1) {
                $(this).parent().children('.addButton').removeAttr('disabled');
                $(this).attr('disabled', 'disabled');
            } else {
                $(this).parent().children('.addButton').removeAttr('disabled');
                $(this).removeAttr('disabled');
            }
        }

    });

});
</script>

</body>

</html>
