function generate_itemPage_php_header(item_name, brand) {
    return `<?php $upperDirectoryCount = 1;
    include "../assets/includes/class-auto-loader.inc.php"; //Auto include classes when needed. 
    ?>
    <?php $cart = new Cart(); //Must declare first before have any output to continue the session 
    ?>
    <?php
    $view = new View();
    $item = $view->getItem("${item_name}", "${brand}");
    $i_id = $view->getItemId($item);
    ?>
    <?php
    
    $max_count = 10;
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $cartItem = new CartItem($item, $_POST['itemQuantity'], $_POST['variety'], "");
        if ($cart->isDuplicated($cartItem)) {
    
            $cur_count = $_POST['itemQuantity'];
            $existing_item_count = $cart->getSpecificCartItem($_POST['variety'])->getQuantity();
    
            if($cur_count + $existing_item_count <= $max_count) // if the existing item count and current count does not exceed max_count
                $cart->editQuantity($_POST['variety'], $cur_count);
            else // This adds item to the max_count since they already added more than 10
                $cart->editQuantity($_POST['variety'], 10 - $existing_item_count);
    
            //Will work on disabling the add item, or show a notification if existing item count has already exceeded the max value
        } else {
            $cart->addItem($cartItem);
        }
    }
    ?>`;
}

function generate_script() {
    return `
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
                $(\`#star\${i}\`).hover(e => {
                    for (let k = i; k >= 1; k--) {
                        if (flag[k] == 0){
                            $(\`#star\${k}\`).css("color", "orange");
                            $("#rate_points").html(\`\${parseInt(i).toFixed(2)}\`);
                        }
                    }
                }, e => {
                    for (let k = i; k >= 1; k--) {
                        if (flag[k] == 0){
                            $(\`\#star\${k}\`).css("color", "grey");
                            $("#rate_points").html("0.00");
                        }
                    }
                });

                $(\`#star\${i}\`).on("click", e => {
                    reset();
                    for (let k = i; k >= 1; k--) {
                        $(\`#star\${k}\`).css("color", "orange");
                        flag[k] = 1;
                    }
                    $("#rate_points").html(\`\${parseInt(i).toFixed(2)}\`);
                });
            }

            function reset() {
                for (let i = 1; i <= 5; i++) {
                    flag[i] = 0;
                    $(\`#star\${i}\`).css("color", "grey");
                }
            }

        });
    </script>
    `;
}

function generate_itemPage_html_head(item_name, brand) {
    return `
    <head>
        <?php $upperDirectoryCount = 1;
        $title = "${brand} ${item_name} | Ecolla ε口乐";
        include "../assets/includes/stylesheet-script-declaration.inc.php" ?>
        <!-- To-do: Meta for google searching -->
    </head>
    `;
}

function generate_itemPage_wrapper_header(item_name, brand, pricePerItem, itemType) {
    return `<wrapper class="d-flex flex-column">
    <main class="flex-fill">
        <!--put content-->

        <?php $i = $item;
        include_once __DIR__ . "\\\\..\\\\assets\\\\block-user-page\\\\breadcrumb-block.php"; ?>

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
                                <span class="badge purple mr-1">${itemType}</span>
                            </a>
                             <!-- <a href="">
                                <span class="badge blue mr-1">新品</span>
                            </a> -->
                            <a href="">
                                <span class="badge red mr-1">畅销</span>
                            </a>
                        </div>

                        <p class="lead">
                            <!-- <span class="mr-1  font-weight-bold">
                            <del>RM 3.00</del>
                        </span> -->
                            <span class="font-weight-bold" style="color:red;">RM ${parseFloat(pricePerItem).toFixed(2)}</span>
                        </p>

                        <p class="lead font-weight-bold">${brand}${item_name}</p>`;
}

function generate_categories() {
    let start = `<div class="col-xs-12 col-sm-8"><ol class="list-group">`, end = `</ol></div>`,
        php_loop = `<?php
    for($i = 0; $i < sizeof($item->getVarieties()); $i++){
        echo '<li class="list-group-item';
        if($i == 0) echo ' active';
        echo '">'.$item->getVarieties()[$i]->getProperty().'</li>';
    }
     ?>`;

    return start + php_loop + end;
}

function generate_form_html(barcode) {
    let start = ` <form action="" method="post">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
                            <div class="h5">口味：</div>
                        </div>
                    <input id="variety" type="text" name="variety" value="${barcode}" hidden></input>`,
        end = `
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
    </form>`;

    return start + generate_categories() + end;
}

function generate_ItemPage_wrapper_footer() {
    return `
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
    `;
}

function generate_star_rating_system(){
    return ` <!-- Star Rating System -->
    <div class="row">
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
    </div><br>`;
}

function generate_itemPage_wrapper(item_name, brand, pricePerItem, barcode, itemType) {
    return generate_itemPage_wrapper_header(item_name, brand, pricePerItem, itemType)
        + generate_star_rating_system()
        + generate_form_html(barcode)
        + generate_ItemPage_wrapper_footer();
}

function generate_itemPage_body(item_name, brand, pricePerItem, barcode, itemType){
    let start = `<body>
    
    <?php $c = $cart;
    $upperDirectoryCount = 1;
    include __DIR__ . "\\\\..\\\\assets\\\\block-user-page\\\\header.php"; ?>`,
    end = "</body>";

    return start + generate_itemPage_wrapper(item_name, brand, pricePerItem, barcode, itemType) + generate_script() + end;
}

function generate_itemPage_html(item_name, brand, pricePerItem, barcode, itemType) {
    let start = "<!DOCTYPE html><html>", end = "</html>";
    return start + generate_itemPage_html_head(item_name, brand) + generate_itemPage_body(item_name, brand, pricePerItem, barcode, itemType) + end;
}


function itemPage_html_string(item_name, brand, pricePerItem, barcode, itemType) {
    return generate_itemPage_php_header(item_name, brand) + generate_itemPage_html(item_name, brand, pricePerItem, barcode, itemType);
}


// "手撕素肉排", "好味屋", 1.5, "6931754804900", "零食"
// "鹌鹑蛋","湖湘贡",1.2,"6941025700084", "零食"
// "维生素功能饮料", "脉动", 4.32, "6902538004045", "饮料"

// console.log(itemPage_html_string("手撕素肉排", "好味屋", 1.5, "6931754804900", "零食"));
// console.log(itemPage_html_string("鹌鹑蛋","湖湘贡",1.2,"6941025700084"));
// console.log(itemPage_html_string("维生素功能饮料", "脉动", 4.32, "6902538004045", "饮料"));