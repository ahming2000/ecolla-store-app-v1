<?php include "assets/php/includes/class-auto-loader.inc.php"; //Auto include all the classes. ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title>商品列表 | Ecolla ε口乐</title>
        <link rel="stylesheet" href="assets/vendor/bootstrap-4.5.2-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/vendor/icofont/icofont.min.css">
        <link rel="stylesheet" href="deco.css">
        <link rel="shortcut icon" href="assets/images/icon/ecollafavicon.ico">
    </head>
    <body>
        <!-- Important Thing To Declare -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="assets/vendor/bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
        <script src='https://kit.fontawesome.com/a076d05399.js'></script>        
        
        <?php include "block/header.php"; ?>
        
    <wrapper class="d-flex flex-column">
    <main class="flex-fill">

        <div class="container">
            <div class="row">
            
                <?php
                    $view = new View();
                    $itemList = $view->getAllItems(); //Important!! Need to take the data from the database!!!
                    
                    foreach($itemList as $i){
                        $item = $i;
                        include "block/item-block.php";    
                    }
                    
                ?>

            </div>
        </div>
        
    </main>

        <section>
        <?php include "block/footer.php"; ?>
        </section>

        <script>
            $(document).ready(function(){

                $("#cartCount").html("0"); //Temporary, Need to retrieve from the php session

            });
        </script>
    
    </wrapper>
    </body>
</html>


