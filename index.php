<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title>Ecolla ε口乐零食店官网</title>
        <link rel="stylesheet" href="assets/vendor/bootstrap-4.5.2-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/vendor/icofont/icofont.min.css">
        <link rel="shortcut icon" href="assets/images/icon/ecollafavicon.ico">
    </head>
    <body>
        <!-- Important Thing To Declare -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="assets/vendor/bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>        
        <?php include "assets/php/classes.php"; ?>

        <?php include "block/header.php"; ?>

        <!-- Advertisement -->
        <section class="my-3">
            <?php
                // ***1920 x 540 pixels picture is needed for advertisement!!!***
                $imgList = array("assets/images/ads/ads1.jpg", "assets/images/ads/ads2.jpg", "assets/images/ads/ads3.jpg", "assets/images/ads/ads4.jpg");
                include "block/carousel-block.php"; 
            ?>
        </section>

        
        <!-- Hot Sells Items -->
        <div class="container my-3">
        <div class="card">
        <div class="card-body"><p>Hi</p></div>
        
        </div>
            
        </div>

        <?php include "block/footer.php"; ?>

        

        <script>
            $(document).ready(function(){

                $("#cartCount").html("0");

            });
        </script>
    
    </body>
</html>