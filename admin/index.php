<?php $upperDirectoryCount = 1; include "../assets/includes/class-auto-loader.inc.php"; //Auto include all the classes. ?>
<?php

if(isset($_COOKIE["username"])){
    $message =  "<h3>登陆成功！</h3>"."<br>"."<a href=\"logout.php\">点击登出</a>";
} else{
    header("location: login.php");
}

?>
<!DOCTYPE html>
<html>

<head><?php $upperDirectoryCount = 1; $title = "管理员主页"; include "../assets/includes/stylesheet-script-declaration.inc.php" ?></head>

<body>
    <?php $upperDirectoryCount = 1; include "../assets/block-admin-page/header.php"; ?>

    <div class="container">
        <br>
        <?php
            if(isset($message)){
                echo $message;
            }

         ?>

    </div>
</body>

</html>
