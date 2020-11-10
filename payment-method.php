<?php include "assets/php/includes/class-auto-loader.inc.php"; //Auto include all the classes. ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title>Ecolla ε口乐零食店官网</title>
        <link rel="stylesheet" href="assets/vendor/bootstrap-4.5.2-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/vendor/icofont/icofont.min.css">
        <link rel="stylesheet" href="deco.css">
        <link rel="shortcut icon" href="assets/images/icon/ecollafavicon.ico">
    </head>
    <body>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="assets/vendor/bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>  
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>

    <?php include "block/header.php"; ?>
    
<wrapper class="d-flex flex-column">
<main class="flex-fill"> <!--put content-->
<div class="container">
    <h1 class="mt-4 mb-3">付款方式</h1>
    <p>这是我们能接受的付款通道</p>
    <div class="row shadow p-3 m-2 mx-auto">
        <div class="col-6 col-md-3 col-sm-6">
            <img src="assets/images/icon/pay-cash.png" alt="image" height="100" width="100">
        </div>
        <div class="col-6 col-md-9 col-sm-6 pt-4">
            <h5>cash</h5>
        </div>
    </div>
        
    <div class="row shadow p-3 m-2 mx-auto">
        <div class="col-6 col-md-3 col-sm-6">
            <img src="assets/images/icon/pay-boost.jpg" alt="image" height="100" width="100">
        </div>
        <div class="col-6 col-md-9 col-sm-6 pt-4">
            <h5>boost</h5>
        </div>
    </div>

    <div class="row shadow p-3 m-2 mx-auto">
        <div class="col-6 col-md-3 col-sm-6">
            <img src="assets/images/icon/pay-tnc.jpg" alt="image" height="100" width="100">
        </div>
        <div class="col-6 col-md-9 col-sm-6 pt-4">
            <h5>touch 'n go</h5>
        </div>
    </div>

    <div class="row shadow p-3 m-2 mx-auto">
        <div class="col-6 col-md-3 col-sm-6">
            <img src="assets/images/icon/pay-fpx.jpeg" alt="image" height="100" width="100">
        </div>
        <div class="col-6 col-md-9 col-sm-6 pt-4">
            <h5>online banking</h5>
        </div>
    </div>
</div>

</main>
    <section>
    <?php include "block/footer.php"; ?>
    </section>

    </wrapper>
    </body>
</html>