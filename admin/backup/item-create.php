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
function saveData(){

    // Convert file pointer to better array arrangement. Reference: https://www.php.net/manual/en/features.file-upload.multiple.php#53240
    $generalImageListWithNull = UsefulFunction::reArrayFiles($_FILES["item-image"]);
    // Check list all image into an array
    $generalImageList = array();
    for($i = 0; $i < sizeof($generalImageListWithNull); $i++){
        if($generalImageListWithNull[$i]["name"] != null){
            //Used to rearrage the index for image upload later
            array_push($generalImageList, $generalImageListWithNull[$i]);
        }
    }

    // Declare into item object
    $item = new Item($_POST["i_name"], $_POST["i_description"], $_POST["i_brand"], $_POST["i_origin"], $_POST["i_property_name"], 0, sizeof($generalImageList), 0); // New item's default value of listing and view count is 0
    // Declare into variety object
    for($i = 0; $i < sizeof($_POST["v"]); $i++){
        if($_POST["v"][$i]["v_property"] != ""){
            $variety = new Variety($_POST["v"][$i]["v_barcode"], $_POST['v'][0]['v_property'], $_POST["v"][$i]["v_price"], $_POST["v"][$i]["v_weight"], $_POST['v'][$i]["v_discount_rate"]);

            for($j = 0; $j < sizeof($_POST["v"][$i]["inv"]); $j++){
                if($_POST["v"][$i]["inv"][$j]["inv_quantity"] != ""){
                    $inventory = new Inventory($_POST["v"][$i]["inv"][$j]["inv_expire_date"], $_POST["v"][$i]["inv"][$j]["inv_quantity"]);
                    $variety->addInventory($inventory); //Add inventory to variety
                }
            }

            $item->addVariety($variety); //Add variety to item
        }
    }
    // Declare into catogories array
    for($i = 0; $i < sizeof($_POST["catogory"]); $i++){
        if($_POST["catogory"][$i] != ""){
            $item->addCatogory($_POST["catogory"][$i]); //Add catogory to item
        }
    }

    // Insert into database first to get item_id
    $controller->insertNewItem($item);
    $i_id = $view->getItemId($item);

    // General image upload
    for($i = 0; $i < sizeof($generalImageList); $i++){
        UsefulFunction::uploadItemImage($generalImageList[$i], $i_id, $i, "crop");
    }

    // Variety image upload
    $varietyImageList =  UsefulFunction::reArrayFiles($_FILES["variety-image"]);
    for($i = 0; $i < sizeof($varietyImageList); $i++){
        if($varietyImageList[$i]["name"] != null){
            UsefulFunction::uploadItemImage($varietyImageList[$i], $i_id, $_POST["variety"][$i]["barcode"], "crop");
        }
    }
    return $item;
}

if(isset($_POST["save"])){

    $item = saveData();
    UsefulFunction::generateAlert("商品保存成功！");
    header("location: item-edit.php?itemName=".$_POST["i_name"]."&itemBrand=".$_POST["i_brand"]);

}

// Listing button clicked
if(isset($_POST['list'])){

    $item = saveData();
    if(UsefulFunction::checkListingCondition($item)){
        $obj = json_decode($_POST['mini_database']);
        UsefulFunction::createPHPFile($_POST["name"], $_POST["brand"], $obj);
        // To-do: set is_listed attribute to 1 in database
        UsefulFunction::generateAlert("商品保存成功，商品已上架！");
        header("location: item-edit.php?itemName=".$_POST["name"]."&itemBrand=".$_POST["brand"]);
    } else{
        UsefulFunction::generateAlert("商品资料没有达到上架的条件！");
        header("location: item-edit.php?itemName=".$_POST["name"]."&itemBrand=".$_POST["brand"]);
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

        <!-- Page content with row class -->
        <div class="row">

            <div class="col-sm-12 col-md-10">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="h1">创建新商品</div>

                    <div class="h2" id="step-one">基本资讯</div>
                    <div class="form-row">
                        <!-- Name -->
                        <div class="col-12">
                            <div class="form-row">
                                <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                                    <label><span style="color: red;">*</span> 商品名称：</label>
                                </div>

                                <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                                    <input type="text" class="form-control" name="i_name" aria-describedby="i-name" maxlength="250" required/>
                                </div>
                            </div>
                        </div><!-- Name -->
                        <!-- Description -->
                        <div class="col-12">
                            <div class="form-row">
                                <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                                    <label>商品描述：</label>
                                </div>

                                <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                                    <textarea class="form-control" name="i_description" aria-describedby="i-description" rows="5" maxlength="3000"></textarea>
                                </div>
                            </div>
                        </div><!-- Description -->
                        <!-- Origin -->
                        <div class="col-12">
                            <div class="form-row">
                                <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                                    <label>出产地：</label>
                                </div>

                                <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                                    <input type="text" class="form-control" name="i_origin" aria-describedby="i-origin"/>
                                </div>
                            </div>
                        </div><!-- Origin -->
                        <!-- Brand -->
                        <div class="col-12">
                            <div class="form-row">
                                <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                                    <label><span style="color: red;">*</span> 商品品牌：</label>
                                </div>

                                <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                                    <input type="text" class="form-control" name="i_brand" aria-describedby="i-brand" required/>
                                </div>
                            </div>
                        </div><!-- Brand -->
                        <!-- Catogory -->
                        <div class="col-12">
                            <!-- Current catogory list -->
                            <datalist id="catogory-list">
                                <?php foreach($view->getCatogoryList() as $catogory) : ?>
                                    <option value="<?= $catogory["cat_name"]; ?>"><?= $catogory["cat_name"]; ?></option>
                                <?php endforeach; ?>
                            </datalist><!-- Current catogory list -->

                            <div class="form-row">
                                <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                                    <label>商品类别/标签：</label>
                                </div>

                                <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                                    <div class="row" id="catogory-section">
                                        <div class="col-12 mb-1"><input type="text" class="form-control" name="catogory[0]" aria-describedby="catogory" list="catogory-list" maxlength="20"/></div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- Catogory -->
                        <!-- Add extra catogory button -->
                        <div class="col-12 text-center"><button type="button" class="btn btn-secondary" id="extra-catogory-button">添加更多类别/标签</button></div>

                        <div class="h2" id="step-two">规格资讯</div>

                        <!-- Property Name -->
                        <div class="col-12"><label>规格设定</label></div>
                        <div class="col-12">
                            <div class="form-row">
                                <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                                    <label>规格名称：</label>
                                </div>

                                <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                                    <input type="text" class="form-control" name="i_property_name" aria-describedby="i-property-name" />
                                </div>
                            </div>
                        </div><!-- Property Name -->
                        <!-- Property -->
                        <div class="col-12">
                            <div class="form-row">
                                <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                                    <label>选择：</label>
                                </div>

                                <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                                    <div class="row" id="property-section">
                                        <div class="col-12 mb-1"><input type="text" class="form-control v-property" name="v[0][v_property]" aria-describedby="v-property" maxlength="100"/></div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- Property -->
                        <!-- Add extra variety button -->
                        <div class="col-12 text-center"><button type="button" class="btn btn-secondary mb-3" id="extra-property-button">添加更多规格</button></div>

                        <!-- Variety -->
                        <div class="col-12"><label>规格销售</label></div>
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

                                    <tbody id="variety-table-section">
                                        <tr>
                                            <td><input type="text" class="form-control v-property-view" disabled/></td>
                                            <td><input type="text" class="form-control" name="v[0][v_barcode]" aria-describedby="v-barcode" maxlength="20"/></td>
                                            <td><input type="number" step="0.01" min="0" class="form-control" name="v[0][v_price]" aria-describedby="v-price" maxlength="10"/></td>
                                            <td><input type="number" step="0.001" min="0" class="form-control" name="v[0][v_weight]" aria-describedby="v-weight" maxlength="10"/></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- Variety -->

                        <!-- Inventory -->
                        <div class="col-12"><label>规格库存</label></div>
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
                                        <tr>
                                            <td><input type="text" class="form-control v-property-view" disabled/></td>
                                            <td colspan="2">
                                                <div class="form-row variety-inventory-table-section">
                                                    <input type="number" value="1" class="inventory-count" hidden/>
                                                    <div class="col-6"><input type="date" class="form-control mb-1" name="v[0][inv][0][inv_expire_date]" aria-describedby="inv-expire-date"/></div>
                                                    <div class="col-6"><input type="number" min="0" class="form-control mb-1" name="v[0][inv][0][inv_quantity]" aria-describedby="inv-quantity"/></div>
                                                </div>
                                                <!-- Add extra inventory button -->
                                                <div class="text-center"><button type="button" class="btn btn-secondary mt-1 extra-inventory-button">添加更多库存</button></div>
                                            </td>
                                        </tr>
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
                                        <img class="img-fluid image-preview" src="../assets/images/alt/image-upload-alt.png"/>
                                        <div style="text-align: center;">封面</div>
                                    </label>
                                </div><!-- Cover picture (0.jpg) -->

                                <!-- Cover picture (1.jpg) -->
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[1]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="../assets/images/alt/image-upload-alt.png"/>
                                        <div style="text-align: center;">照片 1</div>
                                    </label>
                                </div><!-- Cover picture (1.jpg) -->

                                <!-- Cover picture (2.jpg) -->
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[2]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="../assets/images/alt/image-upload-alt.png"/>
                                        <div style="text-align: center;">照片 2</div>
                                    </label>
                                </div><!-- Cover picture (2.jpg) -->

                                <!-- Cover picture (3.jpg) -->
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[3]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="../assets/images/alt/image-upload-alt.png"/>
                                        <div style="text-align: center;">照片 3</div>
                                    </label>
                                </div><!-- Cover picture (3.jpg) -->

                                <!-- Cover picture (4.jpg) -->
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[4]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="../assets/images/alt/image-upload-alt.png"/>
                                        <div style="text-align: center;">照片 4</div>
                                    </label>
                                </div><!-- Cover picture (4.jpg) -->

                                <!-- Cover picture (5.jpg) -->
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[5]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="../assets/images/alt/image-upload-alt.png"/>
                                        <div style="text-align: center;">照片 5</div>
                                    </label>
                                </div><!-- Cover picture (5.jpg) -->

                                <!-- Cover picture (6.jpg) -->
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[6]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="../assets/images/alt/image-upload-alt.png"/>
                                        <div style="text-align: center;">照片 6</div>
                                    </label>
                                </div><!-- Cover picture (6.jpg) -->

                                <!-- Cover picture (7.jpg) -->
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[7]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="../assets/images/alt/image-upload-alt.png"/>
                                        <div style="text-align: center;">照片 7</div>
                                    </label>
                                </div><!-- Cover picture (7.jpg) -->

                                <!-- Cover picture (8.jpg) -->
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[8]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="../assets/images/alt/image-upload-alt.png"/>
                                        <div style="text-align: center;">照片 8</div>
                                    </label>
                                </div><!-- Cover picture (8.jpg) -->

                            </div>

                        </div>

                        <!-- Variety image section -->
                        <div class="col-12">

                            <div class="h3">规格照片</div>

                            <div class="form-row" id="variety-image-section">
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="variety-image[0]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="../assets/images/alt/image-upload-alt.png"/>
                                        <div style="text-align: center;" class="variety-property-caption"></div>
                                    </label>
                                </div>
                            </div>

                        </div><!-- Variety image section -->

                        <div class="col-12 text-center mb-3">
                            <input class="btn btn-primary mr-2" type="submit" value="创建并保存" name="save" style="width: 200px">
                            <input class="btn btn-primary" type="submit" value="创建并上架" name="list" style="width: 200px">
                        </div>

                    </div>


                    <input type="text" name="mini_database" value="empty" hidden id="mini_db" />
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

    </main>

    <script src="../assets/js/admin-item-management-page.js"></script>
    <script src="../assets/js/itemPage_generate.js"></script>
    <script>
    $(function() {
        $("form").on("submit", e => {
            let name = $('input[name=name]').val() || "", brand = $('input[name=brand]').val() || "",
            type = $("input[name^='catogory']").eq(0).val() || "", barcode = $(`input[name="variety[0][barcode]"]`).val() || "",
            price = $(`input[name="variety[0][price]"]`).val();
            let obj = {
                name: $('input[name=name]').val() || "",
                brand: $('input[name=brand]').val() || "",
                type: $("input[name^='catogory']").eq(0).val() || "",
                barcode:  $(`input[name="variety[0][barcode]"]`).val() || "",
                price: $(`input[name="variety[0][price]"]`).val() || "",
                html_markup: itemPage_html_string(name, brand, price, barcode, type)
            }

            let obj_str = JSON.stringify(obj);

            $("input[name=mini_database]").val(obj_str);
        });
    });
    </script>

</body>
</html>