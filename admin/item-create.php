<?php
/* Authorization */
if(!isset($_COOKIE["username"])) header("location: login.php");

/* Initialization */
// Standard variable declaration
$upperDirectoryCount = 1;
$title = "创建新商品";
$mode = "admin";

// Auto loader for classes
include "../assets/includes/class-auto-loader.inc.php";

// Database Interaction
$view = new View();
$controller = new Controller();

/* Operation */
// Submit
if(isset($_POST["submit"])){
    if(!$controller->insertNewItem($_POST["i_name"])){
        $message = "此商品已存在数据库了<br>点击<a href='item-edit.php?itemName=" . $_POST["i_name"] . "'>这里</a>进行编辑";
        $alertType = "alert-warning";
    } else{
        header("location: item-edit.php?itemName=" . $_POST["i_name"]);
    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <?php include "../assets/includes/stylesheet.inc.php"; ?>
</head>

<body>
    <?php include "../assets/includes/script.inc.php"; ?>

    <header><?php include_once "../assets/block-admin-page/header.php"; ?></header>

    <main class="container">

        <div class="row">
            <div class="col-xs-0 col-sm-2"></div>
            <div class="col-xs-12 col-sm-8">
                <div class="alert <?= isset($alertType) ? $alertType : ""; ?>" role="alert">
                    <?= isset($message) ? $message : ""; ?>
                </div>
            </div>
            <div class="col-xs-0 col-sm-2"></div>
        </div>

        <div class="row">
            <div class="col-xs-0 col-sm-2"></div>
            <div class="col-xs-12 col-sm-8">
                <div class="h1 text-center mb-3">请输入商品名字</div>
                <form action="" method="post">
                    <div class="mb-3"><input type="text" class="form-control" name="i_name" aria-describedby="i-name" maxlength="250" value="<?= isset($_POST["i_name"]) ? $_POST["i_name"] : ""; ?>" required/></div>
                    <div class="text-center"><button type="submit" class="btn btn-primary" name="submit">创建</button></div>
                </form>

            </div>
            <div class="col-xs-0 col-sm-2"></div>

        </div>

    </main>

</body>
</html>
