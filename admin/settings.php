<?php
/* Authorization */
if(!isset($_COOKIE["username"])) header("location: login.php");

/* Initialization */
// Standard variable declaration
$upperDirectoryCount = 1;
$title = "网站设定";
$mode = "admin";

// Auto loader for classes
include "../assets/includes/class-auto-loader.inc.php";

// Database Interaction
$view = new View();
$controller = new Controller();

/* Operation */
if(isset($_POST["save-order-id-prefix"])){
    $controller->setOrderIdPrefix($_POST["order-id-prefix"]);
    UsefulFunction::generateAlert("更改成功！");
    header("refresh: 0"); //Refresh page immediately
}

if(isset($_POST["change-password"])){
    if($controller->checkUserPassword($_COOKIE["username"], $_POST["old-password"])){
        if($_POST["new-password"] != $_POST["confirm-password"]){
            $message = "新密码与确认密码不吻合！";
        } else{
            if($controller->changePassword($_COOKIE["username"], $_POST["new-password"])){
                $message = "更改成功！";
            }
        }
    } else{
        $message = "旧密码错误！";
    }

    UsefulFunction::generateAlert($message);
    header("refresh: 0"); //Refresh page immediately
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
        <div class="h1">设定</div>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">

                <div class="h3">账号设定</div>
                <form action="" method="post">
                    <div class="form-row">
                        <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                            <label>旧密码：</label>
                        </div>

                        <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                            <input type="password" class="form-control" name="old-password" required />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                            <label>新密码：</label>
                        </div>

                        <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                            <input type="password" class="form-control" name="new-password" required />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                            <label>确认密码：</label>
                        </div>

                        <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                            <input type="password" class="form-control" name="confirm-password" required />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary" name="change-password">更改密码</button>
                        </div>
                    </div>

                </form>


                <div class="h3">订单设定</div>
                <form action="" method="post">
                    <div class="form-row">
                        <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                            <label>订单开头设定：</label>
                        </div>

                        <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                            <input type="text" class="form-control" name="order-id-prefix" maxlength="10" value="<?= $view->getOrderIdPrefix(); ?>" required />
                        </div>

                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary" name="save-order-id-prefix">保存订单开头</button>
                        </div>
                    </div>
                </form>





            </div>
            <div class="col-2"></div>

        </div>


    </main>

</body>
</html>
