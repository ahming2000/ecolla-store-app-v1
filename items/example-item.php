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
    <script src="assets/vendor/bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>        
    
    <?php include __DIR__."\\..\\block\\header.php"; ?>

    <wrapper class="d-flex flex-column">
    <main class="flex-fill"> <!--put content-->

    <section class="mb-5">
    
    </section>
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">商品列表</a></li>
                <li class="breadcrumb-item">
                    <a href="#">Catogory</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">ItemName</li>
            </ol>

        </nav>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                <div class="col-xs-0 col-sm-0 col-md-0 col-lg-12">
                    <?php
                        $imgList = array("");
                        include "../block/carousel-block.php";
                    ?>
                </div>
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
            </div>
        </div>

        <div class="col-12">
        </div>

        <div class="row">
        </div>
    </div>

    </main>

    <?php include "../block/footer.php"; ?>

</wrapper> 
</body>

</html>