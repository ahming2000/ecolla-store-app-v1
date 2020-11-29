<?php $upperDirectoryCount = 1; include "../assets/includes/class-auto-loader.inc.php"; //Auto include all the classes. ?>
<?php
    $controller = new Controller();

    if(isset($_POST["login"])){
        if(!empty($_POST["username"]) && !empty($_POST["password"])){
            $count = $controller->checkUserPassword($_POST["username"], $_POST["password"]);
            if($count > 0){
                setcookie("username", $_POST["username"], time() + 7200, "/admin/");
                header("location: index.php");
            } else{
                echo "Wrong user or password!"."<br>";
            }
        }
    }

?>

<!DOCTYPE html>
<html>

<head><?php $upperDirectoryCount = 1; $title = "登录"; include "../assets/includes/stylesheet-script-declaration.inc.php" ?></head>

<style>
.form_container {margin-top: 100px;}
</style>

<body>


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
