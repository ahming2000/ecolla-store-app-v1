<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>购物车 | Ecolla ε口乐</title>
    </head>
    <body>
        <!-- Important Thing To Declare -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="assets/vendor/bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>        
        <?php include "assets/php/classes.php"; ?>

        <?php include "navigation-bar.php"; ?>
        <div>
            <div class="cart-list"></div>
            <?php include "order-summary.php";//This will be a form that submit with cartItem Object ?>
        </div>
        <?php include "footer.php"; ?>

    </body>
</html>
