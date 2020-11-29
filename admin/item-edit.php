<?php $upperDirectoryCount = 1; include "../assets/includes/class-auto-loader.inc.php"; //Auto include all the classes. ?>
<?php if(!isset($_COOKIE["username"])) header("location: login.php"); ?>
<!DOCTYPE html>
<html>

<?php

$view = new View();
$_i = $view->getItem($_GET["itemName"], $_GET["itemBrand"]);
if($_i == null) die("Error, fail to load parameter");

if(isset($_POST["submit"])){


    $item = new Item($_POST["name"], $_POST["brand"], $_POST["country"], isset($_POST["isListed"]) ? 1 : 0, 1);
    $v = new Variety($_POST["barcode1"], $_POST["property1"], $_POST["propertyName1"], $_POST["price1"], $_POST["weight1"], $_POST["weightUnit1"], 1.0);
    $v->addShelfLife(new ShelfLife($_POST["expireDate1"], $_POST["quantity1"]));
    $item->addVariety($v);
    $item->addCatogory($_POST["catogory"]);

    $controller = new Controller();

}

 ?>

<head><?php $upperDirectoryCount = 1; $title = "商品管理"; include "../assets/includes/stylesheet-script-declaration.inc.php" ?></head>

<body>
    <?php $upperDirectoryCount = 1; include "../assets/block-admin-page/header.php"; ?>

    <div class="container">
        <div class="h1">更改商品资料</div>

        <form action="" method="post">
            <div class="form-row">
                <div class="col">
                    <label for="country">出产国家</label>
                    <input value="<?php echo $_i->getCountry(); ?>" type="text" class="form-control" name="country" aria-describedby="country" required>
                </div>
                <div class="col">
                    <label for="brand">商品品牌</label>
                    <input value="<?php echo $_i->getBrand(); ?>" type="text" class="form-control" name="brand" aria-describedby="brand" required>
                </div>

                <div class="col">
                    <label for="name">商品名称</label>
                    <input value="<?php echo $_i->getName(); ?>" type="text" class="form-control" name="name" aria-describedby="name" required>
                </div>


            </div><br>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="isListed" value="" id="listing" checked>
                <label class="form-check-label" for="listing">
                    上架
                </label>
            </div><br>

            <div class="form-row" id="catogory">

                <div class="col-12"><label>商品类别/标签</label></div>
                <div class="col-sm-12 col-md-6 col-lg-4">

                    <select name="catogory" class="custom-select mb-3">
                        <option selected>打开选单选择类别/标签...</option>
                        <option value="饮料">饮料</option>
                        <option value="小零食">小零食</option>
                    </select>
                </div>

            </div>

            <button type="button" class="btn btn-secondary mb-3" id="extraCatogory" disabled>添加更多类别/标签</button>

            <div class="form-row" id="variety">


                <div class="col-12">
                    <div class="col-12"><label for="name">商品规格 1</label></div>
                    <!-- Upload images for specific variety -->


                    <div class="row mb-3">
                        <div class="col"><label for="barcode">商品 Barcode</label></div>
                        <div class="col"><input value="<?php echo $_i->getVarieties()[0]->getBarcode(); ?>" type="text" class="form-control" name="barcode1" aria-describedby="barcode" disabled></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col"><label for="property1">规格</label></div>
                        <div class="col"><input value="<?php echo $_i->getVarieties()[0]->getProperty(); ?>" type="text" class="form-control" name="property1" aria-describedby="property1" required></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col"><label for="propertyName1">规格名称</label></div>
                        <div class="col"><input value="<?php echo $_i->getVarieties()[0]->getPropertyName(); ?>" type="text" class="form-control" name="propertyName1" aria-describedby="propertyName1" required></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col"><label for="price">价钱</label></div>
                        <div class="col"><input value="<?php echo $_i->getVarieties()[0]->getPrice(); ?>" type="text" class="form-control" name="price1" aria-describedby="price" required></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col"><label for="weight">重量/容量</label></div>
                        <div class="col"><input value="<?php echo $_i->getVarieties()[0]->getWeight(); ?>" type="text" class="form-control" name="weight1" aria-describedby="weight" required></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col"><label for="weightUnit">重量/容量单位</label></div>
                        <div class="col"><input value="<?php echo $_i->getVarieties()[0]->getWeightUnit(); ?>" type="text" class="form-control" name="weightUnit1" aria-describedby="weightUnit" required></div>
                    </div>
                    <div class="col-12"><label for="name">库存规格 1</label></div>
                    <div class="row mb-3 expireDateForm">
                        <div class="row mr-3">
                            <div class="col"><label for="expireDate1">过期日期</label></div>
                            <div class="col"><input value="<?php echo $_i->getVarieties()[0]->getInventories()[0]->getExpireDate(); ?>" type="date" class="form-control" name="expireDate1" aria-describedby="expireDate1" required></div>
                        </div>
                        <div class="row mr-3">
                            <div class="col"><label for="quantity1">库存</label></div>
                            <div class="col"><input value="<?php echo $_i->getVarieties()[0]->getInventories()[0]->getQuantity(); ?>" type="number" class="form-control" name="quantity1" aria-describedby="quantity1" required></div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary mb-3" id="extraInventory" disabled>添加过期日期</button>

                </div>

            </div>

            <button type="button" class="btn btn-secondary mb-3" id="extraVariety" disabled>添加更多规格</button>


            <input class="btn btn-primary btn-block" type="submit" value="添加" name="submit">

        </form>


    </div>
</body>

</html>
