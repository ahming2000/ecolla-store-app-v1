<?php
/* Initialization */
// Standard variable declaration
$upperDirectoryCount = 1;
$title = "登录";
$mode = "admin";

// Auto loader for classes
include "../assets/includes/class-auto-loader.inc.php";

// Database Interaction
$controller = new Controller();

/* Authorization */
if(isset($_POST["login"])){
    if(!empty($_POST["username"]) && !empty($_POST["password"])){
        if($controller->checkUserPassword($_POST["username"], $_POST["password"])){
            setcookie("username", $_POST["username"], time() + (60 * 60 * 24), "/"); // Cookie expire in 1 days (24 hours)
            header("location: index.php");
            die(); //To improve security
        } else{
            echo "Wrong user or password!"."<br>";
        }
    }
}


/* Operation */

?>

<!DOCTYPE html>
<html>

<head><?php include "../assets/includes/stylesheet.inc.php"; ?></head>

<style>
.form_container {margin-top: 100px;}
</style>

<body>

    <?php include "../assets/includes/script.inc.php"; ?>

    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">
            <div class="d-flex justify-content-center form_container">
                <form action="#" method="post">

                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="username" class="form-control" placeholder="Username">
                    </div>

                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" name="login" class="btn btn-danger">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
