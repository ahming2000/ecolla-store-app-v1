<?php include "assets/php/includes/class-auto-loader.inc.php"; //Auto include classes when needed. ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Ecolla ε口乐零食店官网</title>
        <!-- To-do: Meta for google searching -->
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <link rel="shortcut icon" href="assets/images/icon/ecollafavicon.ico">
        <link rel="stylesheet" href="assets/vendor/bootstrap-4.5.2-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/vendor/icofont/icofont.min.css">
        <link rel="stylesheet" href="deco.css">
        
    </head>
    <body>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="assets/vendor/bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
        <script src='https://kit.fontawesome.com/a076d05399.js'></script>
            
        <?php include "block/header.php"; ?>
       
    <wrapper class="d-flex flex-column">
    <main class="flex-fill"> <!--put content-->

        <!-- Advertisement -->
        <section class="ads-carousel">
            <?php
                // ***1920 x 540 pixels picture is needed for advertisement!!!***
                $imgList = array("assets/images/ads/ads1.jpg", "assets/images/ads/ads2.jpg", "assets/images/ads/ads3.jpg", "assets/images/ads/ads4.jpg");
                include "block/carousel-block.php"; 
            ?>
        </section>
        
        <!-- Hot Sells Items -->
        <section class="section-itemcarousel">
            <div class="container rounded mt-4 p-2">
            <h1 class="hotsell">热卖中</h1>
        
            </div>
        </section>

    </main>

        <section>
        <?php include "block/footer.php"; ?>
        </section>
        
        <script>
            $(document).ready(function(){

                $("#cartCount").html("0");

            });
        </script>
    
    </wrapper>
    </body>
</html>