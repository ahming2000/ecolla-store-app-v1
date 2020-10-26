<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> | Ecolla ε口乐</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="shortcut icon" href="../assets/images/icon/ecollafavicon.ico">
    <link rel="stylesheet" href="../assets/vendor/bootstrap-4.5.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/icofont/icofont.min.css">
    <link rel="stylesheet" href="../deco.css">
</head>

<body>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="../assets/vendor/bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>        
    
    <?php include __DIR__."\\..\\block\\header.php"; ?>

    <wrapper class="d-flex flex-column">
    <main class="flex-fill"> <!--put content-->

    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">商品列表</a></li>
                <li class="breadcrumb-item">
                    <a href="#">Catogory</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">ItemName</li>
            </ol>

        </nav>
        </div>

        <div class="container">
 <!--Grid row-->
 <div class="row">

<!--Grid column-->
<div class="col-md-6 mb-4">
    
<?php
// ***1920 x 540 pixels picture is needed for advertisement!!!***
$imgList = array("../assets/images/ads/item-example-1.jpg", "../assets/images/ads/item-example-2.jpg", "../assets/images/ads/item-example-3.jpg");
include "../block/carousel-block.php"; 
?>

</div>
<!--Grid column-->

<!--Grid column-->
<div class="col-md-6 mb-4">

  <!--Content-->
  <div class="p-4">

    <div class="mb-3">
      <a href="">
        <span class="badge purple mr-1">Category 2</span>
      </a>
      <a href="">
        <span class="badge blue mr-1">New</span>
      </a>
      <a href="">
        <span class="badge red mr-1">Bestseller</span>
      </a>
    </div>

    <p class="lead">
      <span class="mr-1  font-weight-bold">
        <del>RM 3.00</del>
      </span>
      <span class="font-weight-bold" style="color:red;">RM 2.00</span>
    </p>

    <p class="lead font-weight-bold">卫龙 小辣棒</p>

    <p>这里什么都没有</p>

    <form class="d-flex justify-content-left">
      <!-- Default input -->
      <input type="number" value="1" aria-label="Search" class="form-control" style="width: 100px">
      <button class="btn btn-md my-0 p ml-1" style="color:white; background-color: #3c3e44;" type="submit">Add to cart
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

    <?php include "../block/footer.php"; ?>

</wrapper> 
</body>

</html>