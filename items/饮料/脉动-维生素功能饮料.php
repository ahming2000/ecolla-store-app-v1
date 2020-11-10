<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>脉动 维生素功能饮料 | Ecolla ε口乐</title>
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

    <?php include __DIR__."\\..\\..\\block\\header.php"; ?>

    <wrapper class="d-flex flex-column">
    <main class="flex-fill"> <!--put content-->

    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../../item-list.php">商品列表</a></li>
                <li class="breadcrumb-item">
                    <a href="#">饮料</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">脉动 维生素功能饮料</li>
            </ol>

        </nav>
        </div>

        <div class="container">
 <!--Grid row-->
 <div class="row">

<!--Grid column-->
<div class="col-md-6 mb-4">

<?php
include __DIR__."\\..\\..\\assets\\php\\classes\\View.class.php";
$view = new View();
$id = $view->getItemAttr("i_id", "i_name", "维生素功能饮料");
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

    <div class="row">

        <div class="col-xs-12 col-sm-4">
            <div class="h5">口味：</div>
        </div>

        <div class="col-xs-12 col-sm-8">
            <ol class="list-group">
                <li class="list-group-item active" id="normalSelected">青柠600ml</li>
                <li class="list-group-item" id="spicySelected">水蜜桃600ml</li>
                <li class="list-group-item" id="bothSelected">芒果600ml</li>
                <li class="list-group-item" id="bothSelected">仙人掌青橘600ml</li>
                <li class="list-group-item" id="bothSelected">竹子青提500ml</li>
                <li class="list-group-item" id="bothSelected">卡曼橘500ml</li>
            </ol>
        </div>

    </div><br>


    <form class="d-flex justify-content-left">
      <!-- Default input -->
      <div class="col-xs-12 col-sm-8 quantity-button-control">
          <button type="button" class="btn btn-primary dropButton btn-sm mx-3 my-3"
          disabled>-</button>
          <input id="itemQuantity" type="number" class="mx-3 my-3" value="1" style="width: 45px;"
          disabled>
          <button type="button" class="btn btn-primary addButton btn-sm mx-3 my-3">+</button>
      </div>
      <button class="btn btn-md my-0 p ml-1" style="color:white; background-color: #3c3e44;" type="submit">加入购物车
        <i class="fas fa-shopping-cart ml-1"></i>
      </button>

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
