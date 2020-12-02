<?php $upperDirectoryCount = 1; include "../assets/includes/class-auto-loader.inc.php"; //Auto include classes when needed. ?>
<?php $cart = new Cart(); //Must declare first before have any output to continue the session ?>
<?php
$view = new View();
$item = $view->getItem("鹌鹑蛋", "湖湘贡");
$i_id = $view->getItemId($item);
?>
<?php
if($_SERVER['REQUEST_METHOD']=='POST')
{
    $cartItem = new CartItem($item, $_POST['itemQuantity'], $_POST['variety'], "");
    $cart->addItem($cartItem);
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php $upperDirectoryCount = 1; $title = "湖湘贡 鹌鹑蛋 | Ecolla ε口乐"; include "../assets/includes/stylesheet-script-declaration.inc.php" ?>
    <!-- To-do: Meta for google searching -->
</head>

<body>

    <?php $c = $cart; $upperDirectoryCount = 1; include __DIR__."\\..\\assets\\block-user-page\\header.php"; ?>

    <wrapper class="d-flex flex-column">
        <main class="flex-fill"> <!--put content-->

            <?php $i = $item; include_once __DIR__."\\..\\assets\\block-user-page\breadcrumb-block.php"; ?>

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
                                    <span class="badge purple mr-1">零食</span>
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
                        <span class="font-weight-bold" style="color:red;">RM 1.20</span>
                    </p>

                    <p class="lead font-weight-bold">湖湘贡鹌鹑蛋</p>

                    <form action="" method="post">
                        <div class="row">

                            <div class="col-xs-12 col-sm-4">
                                <div class="h5">口味：</div>
                            </div>

                            <input id="variety" type="text" name="variety" value="6941025700084" hidden></input>

                            <div class="col-xs-12 col-sm-8">
                                <ol class="list-group">
                                    <li class="list-group-item active">香辣20g</li>
                                    <li class="list-group-item">盐焗20g</li>
                                    <li class="list-group-item">卤蛋20g</li>
                                    <li class="list-group-item">泡辣20g</li>
                                </ol>
                            </div>

                        </div><br>


                        <div class="d-flex justify-content-left">
                            <!-- Default input -->
                            <div class="col-xs-12 col-sm-8 quantity-button-control">
                                <button type="button" class="btn btn-primary dropButton btn-sm mx-3 my-3"
                                disabled>-</button>
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

<?php $upperDirectoryCount = 1; include "../assets/block-user-page/footer.php"; ?>

</wrapper>

<script>
$(document).ready(function(){
    // For the item list to change the active properties
    $(".list-group li").on("click", function () {
        $(".list-group li").removeClass("active");
        $(this).addClass("active");

        if($(".list-group li:nth-child(1)").hasClass("active")){
            $("#variety").val("6941025700084");
        } else if($(".list-group li:nth-child(2)").hasClass("active")){
            $("#variety").val("6941025700138");
        } else if($(".list-group li:nth-child(3)").hasClass("active")){
            $("#variety").val("6941025701074");
        } else if($(".list-group li:nth-child(4)").hasClass("active")){
            $("#variety").val("6941025702019");
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
