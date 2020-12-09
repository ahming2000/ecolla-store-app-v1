<?php $upperDirectoryCount = 1;
include "../assets/includes/class-auto-loader.inc.php"; //Auto include classes when needed.
?>
<?php $cart = new Cart(); //Must declare first before have any output to continue the session
?>
<?php
$view = new View();
$item = $view->getItem("维生素功能饮料", "脉动");
$i_id = $view->getItemId($item);

$controller = new Controller();
$controller->addViewCount($item);
?>
<?php

$max_count = 10;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cartItem = new CartItem($item, $_POST['itemQuantity'], $_POST['variety'], "");
    if ($cart->isDuplicated($cartItem)) {

        $cur_count = $_POST['itemQuantity'];
        $existing_item_count = $cart->getSpecificCartItem($_POST['variety'])->getQuantity();

        if ($cur_count + $existing_item_count <= $max_count) // if the existing item count and current count does not exceed max_count
            $cart->editQuantity($_POST['variety'], $cur_count);
        else // This adds item to the max_count since they already added more than 10
            $cart->editQuantity($_POST['variety'], 10 - $existing_item_count);

        //Will work on disabling the add item, or show a notification if existing item count has already exceeded the max value
    } else {
        $cart->addItem($cartItem);
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php $upperDirectoryCount = 1;
    $title = "脉动 维生素功能饮料 | Ecolla ε口乐";
    include "../assets/includes/stylesheet-script-declaration.inc.php" ?>
    <!-- To-do: Meta for google searching -->
</head>

<body>

    <?php $c = $cart;
    $upperDirectoryCount = 1;
    include __DIR__ . "\\..\\assets\\block-user-page\\header.php"; ?>

    <wrapper class="d-flex flex-column">
        <main class="flex-fill">
            <!--put content-->

            <?php $i = $item;
            include_once __DIR__ . "\\..\\assets\\block-user-page\breadcrumb-block.php"; ?>

            <div class="container">
                <!--Grid row-->
                <div class="row">

                    <!--Grid column-->
                    <div class="col-md-6 mb-4">

                        <?php include "../assets/block-user-page/carousel-block-item-page.php"; ?>

                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-md-6 mb-4">

                        <!--Content-->
                        <div class="p-4">

                            <div class="mb-3">
                                <a href="">
                                    <span class="badge purple mr-1">饮料</span>
                                </a>
                                <!-- <a href="">
                                <span class="badge blue mr-1">新品</span>
                            </a> -->
                                <a href="">
                                    <span class="badge red mr-1">畅销</span>
                                </a>
                            </div>

                            <p class="lead">
                                <span class="mr-1  font-weight-bold">
                                    <del>RM 4.80</del>
                                </span>
                                <span class="font-weight-bold" style="color:red;">RM 4.32</span>
                            </p>

                            <p class="lead font-weight-bold">脉动维生素功能饮料</p>

                            <!-- Star Rating System -->
                            <!-- <div class="row">
                                <div class="col-6">
                                    <div class="rating">
                                        <div class="fa fa-star" id="star1" style="color: grey;">
                                        </div>
                                        <div class="fa fa-star" id="star2" style="color: grey;">
                                        </div>
                                        <div class="fa fa-star" id="star3" style="color: grey;">
                                        </div>
                                        <div class="fa fa-star" id="star4" style="color: grey;">
                                        </div>
                                        <div class="fa fa-star" id="star5" style="color: grey;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    Rating: <span id="rate_points">0.00</span> / 5.00
                                </div>
                            </div><br> -->

                            <form action="" method="post">
                                <div class="row">

                                    <div class="col-xs-12 col-sm-4">
                                        <div class="h5">口味：</div>
                                    </div>

                                    <input id="variety" type="text" name="variety" value="6902538004045" hidden></input>

                                    <div class="col-xs-12 col-sm-8">
                                        <ol class="list-group">
                                            <?php
                                            for ($i = 0; $i < sizeof($item->getVarieties()); $i++) {
                                                echo '<li class="list-group-item';
                                                if ($i == 0) echo ' active';
                                                echo '">' . $item->getVarieties()[$i]->getProperty() . '</li>';
                                            }
                                            ?>
                                        </ol>
                                    </div>

                                </div><br>


                                <div class="d-flex justify-content-left">
                                    <!-- Default input -->
                                    <div class="col-xs-12 col-sm-8 quantity-button-control">
                                        <button type="button" class="btn btn-primary dropButton btn-sm mx-3 my-3" disabled>-</button>
                                        <input id="itemQuantity" name="itemQuantity" type="number" class="mx-3 my-3" value="1" style="width: 45px;">
                                        <button type="button" class="btn btn-primary addButton btn-sm mx-3 my-3">+</button>
                                    </div>
                                    <button class="btn btn-md my-0 p ml-1" style="color:white; background-color: #3c3e44;" type="submit">加入购物车
                                        <i class="fas fa-shopping-cart ml-1"></i>
                                    </button>

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

        <?php $upperDirectoryCount = 1;
        include "../assets/block-user-page/footer.php"; ?>

    </wrapper>

    <script>
        $(document).ready(function() {
            // For the item list to change the active properties
            $(".list-group li").on("click", function() {
                $(".list-group li").removeClass("active");
                $(this).addClass("active");

                <?php
                for ($i = 0; $i < sizeof($item->getVarieties()); $i++) {
                    if ($i != 0) {
                        echo "else ";
                    }

                    echo "if ($('.list-group li:nth-child(".($i + 1).
                    ")').hasClass('active')) $('#variety').val('".$item->getVarieties()[$i]->getBarcode().
                    "');";

                }
                ?>
            });

            $(".quantity-button-control button").on("click", function() {

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

            //Star-Rating System
            let flag = [0, 0, 0, 0, 0, 0];

            for (let i = 1; i <= 5; i++) {
                $(`#star${i}`).hover(e => {
                    for (let k = i; k >= 1; k--) {
                        if (flag[k] == 0){
                            $(`#star${k}`).css("color", "orange");
                            $("#rate_points").html(`${parseInt(i).toFixed(2)}`);
                        }
                    }
                }, e => {
                    for (let k = i; k >= 1; k--) {
                        if (flag[k] == 0){
                            $(`#star${k}`).css("color", "grey");
                            $("#rate_points").html("0.00");
                        }
                    }
                });

                $(`#star${i}`).on("click", e => {
                    reset();
                    for (let k = i; k >= 1; k--) {
                        $(`#star${k}`).css("color", "orange");
                        flag[k] = 1;
                    }
                    $("#rate_points").html(`${parseInt(i).toFixed(2)}`);
                });
            }

            function reset() {
                for (let i = 1; i <= 5; i++) {
                    flag[i] = 0;
                    $(`#star${i}`).css("color", "grey");
                }
            }

        });
    </script>
</body>

</html>
