<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name=viewport content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="../assets/vendor/bootstrap-4.5.2-dist/css/bootstrap.min.css">
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>

<style>
.form_container {margin-top: 100px;}
</style>

<body>
<?php include "block/navigation-bar-admin.php";?>

<div class="container h-100">
<div class="d-flex justify-content-center h-100">
<div class="d-flex justify-content-center form_container">
<form action="#" method="post">
<div class="input-group mb-3">
<div class="input-group-append">
<span class="input-group-text"><i class="fas fa-user"></i></span>
</div>
<input type="text" name="userid" class="form-control" placeholder="Username">
</div>
<div class="input-group mb-2">
<div class="input-group-append">
<span class="input-group-text"><i class="fas fa-key"></i></span>
</div>
<input type="password" name="pw" class="form-control" placeholder="Password">
</div>
<div class="d-flex justify-content-center mt-3">
<button type="submit" name="login_submit" class="btn btn-danger">Login</button>
</div>
</form>
</div>
</div>
</div>

</body>
</html>