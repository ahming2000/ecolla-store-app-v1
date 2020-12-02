<?php $upperDirectoryCount = 1; include "../assets/includes/class-auto-loader.inc.php"; //Auto include all the classes. ?>
<?php

if(isset($_COOKIE["username"])){
    echo "<br><br><br><br>"."<h3>Login successfull!</h3>"."<br>"."<a href=\"logout.php\">Logout</a>";
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


    </div>
</body>

</html>
