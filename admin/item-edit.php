<?php $upperDirectoryCount = 1; include "../assets/includes/class-auto-loader.inc.php"; //Auto include all the classes. ?>
<?php if(!isset($_COOKIE["username"])) header("location: login.php"); ?>
<!DOCTYPE html>
<html>

<?php

$view = new View();
$item = $view->getItem($_GET["itemName"], $_GET["itemBrand"]);
$item_id = $view->getItemId($item);
if($item == null) die("Error, fail to load parameter");

if(isset($_POST["submit"])){


    // $item = new Item($_POST["name"], $_POST["brand"], $_POST["country"], isset($_POST["isListed"]) ? 1 : 0, 1);
    // $v = new Variety($_POST["barcode1"], $_POST["property1"], $_POST["propertyName1"], $_POST["price1"], $_POST["weight1"], $_POST["weightUnit1"], 1.0);
    // $v->addShelfLife(new ShelfLife($_POST["expireDate1"], $_POST["quantity1"]));
    // $item->addVariety($v);
    // $item->addCatogory($_POST["catogory"]);
    //
    // $controller = new Controller();

}

 ?>

<head><?php $upperDirectoryCount = 1; $title = "编辑 ".$_GET["itemBrand"].'-'.$_GET["itemName"]; include "../assets/includes/stylesheet-script-declaration.inc.php" ?></head>

<body>
    <?php include_once "../assets/block-admin-page/header.php"; ?>

    <div class="container-sm" style="margin-top: 100px;">

        <!-- Page content with row class -->
        <div class="row">

            <div class="col-sm-12 col-md-10">
                <form action="" method="post">
                    <div class="h1">修改商品属性</div>

                    <div class="h2" id="step-one">基本资讯</div>
                    <div class="form-row">
                        <!-- Name -->
                        <div class="col-12">
                            <div class="form-row">
                                <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                                    <label for="name">* 商品名称：</label>
                                </div>

                                <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                                    <input type="text" class="form-control" name="name" aria-describedby="name" maxlength="250" value="<?php echo $item->getName(); ?>" required/>
                                </div>
                            </div>
                        </div><!-- Name -->
                        <!-- Description -->
                        <div class="col-12">
                            <div class="form-row">
                                <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                                    <label for="name">商品描述：</label>
                                </div>

                                <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                                    <textarea class="form-control" name="description" aria-describedby="description" rows="5" maxlength="3000" value="<?php echo $item->getDescription(); ?>"></textarea>
                                </div>
                            </div>
                        </div><!-- Description -->
                        <!-- Origin -->
                        <div class="col-12">
                            <div class="form-row">
                                <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                                    <label for="origin">出产地：</label>
                                </div>

                                <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                                    <input type="text" class="form-control" name="origin" aria-describedby="origin" value="<?php echo $item->getOrigin(); ?>">
                                </div>
                            </div>
                        </div><!-- Origin -->
                        <!-- Brand -->
                        <div class="col-12">
                            <div class="form-row">
                                <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                                    <label for="brand">商品品牌：</label>
                                </div>

                                <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                                    <input type="text" class="form-control" name="brand" aria-describedby="brand" value="<?php echo $item->getBrand(); ?>">
                                </div>
                            </div>
                        </div><!-- Brand -->
                        <!-- Catogory -->
                        <div class="col-12">
                            <!-- Current catogory list -->
                            <datalist id="catogoryList">
                                <?php
                                foreach($view->getCatogoryList() as $catogory){
                                    echo '<option value="'.$catogory["cat_name"].'">'.$catogory["cat_name"].'</option>';
                                }
                                ?>
                            </datalist><!-- Current catogory list -->

                            <div class="form-row">
                                <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                                    <label for="brand">商品类别/标签：</label>
                                </div>

                                <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                                    <div class="row" id="catogory-section">
                                        <?php
                                            for($i = 0; $i < sizeof($item->getCatogories()); $i++){
                                                echo "<div class=\"col-12 mb-1\"><input type=\"text\" class=\"form-control\" name=\"catogory[".$i."]\" aria-describedby=\"catogory\" list=\"catogoryList\" maxlength=\"20\" value=\"".$item->getCatogories()[$i]."\"/></div>";
                                            }
                                         ?>
                                    </div>
                                </div>
                            </div>
                        </div><!-- Catogory -->
                        <!-- Add extra catogory button -->
                        <div class="col-12 text-center"><button type="button" class="btn btn-secondary" id="extraCatogory">添加更多类别/标签</button></div>

                        <div class="h2" id="step-two">规格资讯</div>

                        <!-- Property Name -->
                        <div class="col-12"><label for="property">规格设定</label></div>
                        <div class="col-12">
                            <div class="form-row">
                                <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                                    <label for="variety-property-name">规格名称：</label>
                                </div>

                                <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                                    <input type="text" class="form-control" name="variety-property-name" aria-describedby="variety-property-name" value="<?php echo $item->getVarieties()[0]->getPropertyName(); ?>"/>
                                </div>
                            </div>
                        </div><!-- Property Name -->
                        <!-- Property -->
                        <div class="col-12">
                            <div class="form-row">
                                <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                                    <label for="variety-property">选择：</label>
                                </div>

                                <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                                    <div class="row" id="property-section">
                                        <?php
                                            for($i = 0; $i < sizeof($item->getVarieties()); $i++){
                                                echo "<div class=\"col-12 mb-1\"><input type=\"text\" class=\"form-control variety-property-main\" name=\"variety[".$i."]['property']\" aria-describedby=\"variety-property\" maxlength=\"100\" value=\"".$item->getVarieties()[$i]->getProperty()."\"/></div>";
                                            }
                                         ?>
                                    </div>
                                </div>
                            </div>
                        </div><!-- Property -->
                        <!-- Add extra variety button -->
                        <div class="col-12 text-center"><button type="button" class="btn btn-secondary mb-3" id="extraProperty">添加更多规格</button></div>

                        <!-- Variety -->
                        <div class="col-12"><label for="variety-table">规格销售</label></div>
                        <div class="col-12 mb-3">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">选择</th>
                                            <th scope="col">商品货号</th>
                                            <th scope="col">价格(RM)</th>
                                            <th scope="col">重量(kg)</th>
                                        </tr>
                                    </thead>

                                    <tbody id="variety-section">
                                        <?php
                                            for($i = 0; $i < sizeof($item->getVarieties()); $i++){
                                                echo "<tr>".
                                                    "<td><input type=\"text\" class=\"form-control variety-property\" name=\"variety[".$i."]['property']\" aria-describedby=\"variety-property\" maxlength=\"100\" value=\"".$item->getVarieties()[$i]->getProperty()."\" disabled/></td>" .
                                                    "<td><input type=\"text\" class=\"form-control variety-barcode\" name=\"variety[".$i."]['barcode']\" aria-describedby=\"variety-barcode\" maxlength=\"20\" value=\"".$item->getVarieties()[$i]->getBarcode()."\" required/></td>".
                                                    "<td><input type=\"number\" class=\"form-control variety-price\" name=\"variety[".$i."]['price']\" aria-describedby=\"variety-price\" maxlength=\"10\" value=\"".$item->getVarieties()[$i]->getPrice()."\" required/></td>".
                                                    "<td><input type=\"number\" class=\"form-control variety-weight\" name=\"variety[".$i."]['weight']\" aria-describedby=\"variety-weight\" maxlength=\"10\" value=\"".$item->getVarieties()[$i]->getWeight()."\" required/></td>".
                                                    "</tr>";
                                            }
                                         ?>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- Variety -->

                        <!-- Inventory -->
                        <div class="col-12"><label for="inventory-table">规格库存</label></div>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">选择</th>
                                            <th scope="col">过期日期</th>
                                            <th scope="col">数量</th>
                                        </tr>
                                    </thead>

                                    <tbody id="inventory-table-section">
                                        <?php
                                            for($i = 0; $i < sizeof($item->getVarieties()); $i++){
                                                echo "<tr>" .
                                                    "<td><input type=\"text\" class=\"form-control variety-property\" name=\"variety[".$i."]['property']\" aria-describedby=\"variety-property\" maxlength=\"100\" value=\"".$item->getVarieties()[$i]->getProperty()."\" disabled/></td>" .
                                                    "<td colspan=\"2\">" .
                                                        "<div class=\"form-row inventory-section-class\">";
                                                        $j = 0;
                                                        for($j = 0; $j < sizeof($item->getVarieties()[$j]->getInventories()); $j++){
                                                            echo "<div class=\"col-6\"><input type=\"date\" class=\"form-control inventory-expire-date mb-1\" name=\"variety[".$i."]['inventory'][".$j."]['expireDate']\" aria-describedby=\"inventory-expire-date\" value=\"".$item->getVarieties()[$i]->getInventories()[$j]->getExpireDate()."\" required/></div>" .
                                                            "<div class=\"col-6\"><input type=\"number\" class=\"form-control inventory-quantity mb-1\" name=\"variety[".$i."]['inventory'][".$j."]['quantity']\" aria-describedby=\"inventory-quantity\" value=\"".$item->getVarieties()[$i]->getInventories()[$j]->getQuantity()."\" required/></div>";
                                                        }
                                                        echo "<input type=\"number\" value=\"".$j."\" class=\"inventory-count\" hidden/>";



                                                        echo "</div>" .
                                                        "<!-- Add extra inventory button -->" .
                                                        "<div class=\"text-center\"><button type=\"button\" class=\"btn btn-secondary mt-1 extra-inventory-class\">添加更多库存</button></div>" .
                                                    "</td>" .
                                                "</tr>";
                                            }

                                         ?>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- Inventory -->

                        <div class="h2" id="step-three">媒体管理</div>

                        <div class="col-12">

                            <div class="h3">基本照片</div>

                            <div class="form-row general-image-section">

                                <!-- Cover picture (0.jpg) -->
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[0]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="<?php
                                            if(file_exists("../assets/images/items/".$item_id."/0.jpg")){
                                                echo "../assets/images/items/".$item_id."/0.jpg";
                                            } else {
                                                    echo "../assets/images/alt/image-upload-alt.png";
                                                }
                                         ?>"/>
                                        <div style="text-align: center;">封面</div>
                                    </label>
                                </div>
                                <!-- Cover picture (0.jpg) -->

                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[1]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="<?php
                                            if(file_exists("../assets/images/items/".$item_id."/1.jpg")){
                                                echo "../assets/images/items/".$item_id."/1.jpg";
                                            } else {
                                                    echo "../assets/images/alt/image-upload-alt.png";
                                                }
                                         ?>"/>
                                        <div style="text-align: center;">照片 1</div>
                                    </label>
                                </div>

                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[1]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="<?php
                                            if(file_exists("../assets/images/items/".$item_id."/2.jpg")){
                                                echo "../assets/images/items/".$item_id."/2.jpg";
                                            } else {
                                                    echo "../assets/images/alt/image-upload-alt.png";
                                                }
                                         ?>"/>
                                        <div style="text-align: center;">照片 2</div>
                                    </label>
                                </div>

                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[1]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="<?php
                                            if(file_exists("../assets/images/items/".$item_id."/3.jpg")){
                                                echo "../assets/images/items/".$item_id."/3.jpg";
                                            } else {
                                                    echo "../assets/images/alt/image-upload-alt.png";
                                                }
                                         ?>"/>
                                        <div style="text-align: center;">照片 3</div>
                                    </label>
                                </div>

                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[1]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="<?php
                                            if(file_exists("../assets/images/items/".$item_id."/4.jpg")){
                                                echo "../assets/images/items/".$item_id."/4.jpg";
                                            } else {
                                                    echo "../assets/images/alt/image-upload-alt.png";
                                                }
                                         ?>"/>
                                        <div style="text-align: center;">照片 4</div>
                                    </label>
                                </div>

                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[1]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="<?php
                                            if(file_exists("../assets/images/items/".$item_id."/5.jpg")){
                                                echo "../assets/images/items/".$item_id."/5.jpg";
                                            } else {
                                                    echo "../assets/images/alt/image-upload-alt.png";
                                                }
                                         ?>"/>
                                        <div style="text-align: center;">照片 5</div>
                                    </label>
                                </div>

                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[1]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="<?php
                                            if(file_exists("../assets/images/items/".$item_id."/6.jpg")){
                                                echo "../assets/images/items/".$item_id."/6.jpg";
                                            } else {
                                                    echo "../assets/images/alt/image-upload-alt.png";
                                                }
                                         ?>"/>
                                        <div style="text-align: center;">照片 6</div>
                                    </label>
                                </div>

                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[1]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="<?php
                                            if(file_exists("../assets/images/items/".$item_id."/7.jpg")){
                                                echo "../assets/images/items/".$item_id."/7.jpg";
                                            } else {
                                                    echo "../assets/images/alt/image-upload-alt.png";
                                                }
                                         ?>"/>
                                        <div style="text-align: center;">照片 7</div>
                                    </label>
                                </div>

                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[1]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="<?php
                                            if(file_exists("../assets/images/items/".$item_id."/8.jpg")){
                                                echo "../assets/images/items/".$item_id."/8.jpg";
                                            } else {
                                                    echo "../assets/images/alt/image-upload-alt.png";
                                                }
                                         ?>"/>
                                        <div style="text-align: center;">照片 8</div>
                                    </label>
                                </div>

                            </div>

                        </div>

                        <!-- Variety image section -->
                        <div class="col-12">

                            <div class="h3">规格照片</div>

                            <div class="form-row" id="variety-image-section">
                                <?php
                                    for($i = 0; $i < sizeof($item->getVarieties()); $i++){
                                        echo "<div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2\">" .
                                            "<label>" .
                                                "<input type=\"file\" name=\"variety[".$i."]['image']\" class=\"image-file-selector\" style=\"display:none;\"/>" .
                                                "<img class=\"img-fluid image-preview\" src=\"";
                                                if(file_exists("../assets/images/items/".$item_id."/".$item->getVarieties()[$i]->getBarcode().".jpg")){
                                                    echo "../assets/images/items/".$item_id."/".$item->getVarieties()[$i]->getBarcode().".jpg";
                                                } else{
                                                    echo "../assets/images/alt/image-upload-alt.png";
                                                }
                                                echo "\"/>" .
                                                "<div style=\"text-align: center;\" class=\"variety-property-caption\"></div>" .
                                            "</label>" .
                                        "</div>";
                                    }

                                 ?>


                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="variety[0]['image']" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="../assets/images/alt/image-upload-alt.png"/>
                                        <div style="text-align: center;" class="variety-property-caption"></div>
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="col-12">

                        </div><!-- Variety image section -->

                        <div class="col-12 text-center mb-3"><input class="btn btn-primary" type="submit" value="修改商品属性" name="submit" style="width: 200px"></div>

                    </div>



                </form>
            </div>

            <!-- Navigation guideline -->
            <div class="col-sm-0 col-md-2">
                <div style="position: fixed;" id="menu-list">
                    <ul class="list-group">
                        <a href="#step-one" id="step-one-link" class="item-create-step-info list-group-item list-group-item-action active">基本资讯</a>
                        <a href="#step-two" id="step-two-link" class="item-create-step-info list-group-item list-group-item-action">销售资料</a>
                        <a href="#step-three" id="step-three-link" class="item-create-step-info list-group-item list-group-item-action">媒体管理</a>
                    </ul>
                </div>
            </div><!-- Navigation guideline -->

        </div><!-- Page content with row class -->

    </div>

    <script src="../assets/js/admin-item-management-page.js"></script>

</body>

</html>
