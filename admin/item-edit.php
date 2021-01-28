<?php
/* Authorization */
if (!isset($_COOKIE["username"])) header("location: login.php");
if (!isset($_GET["itemName"])) header("location: item-management.php");

/* Initialization */
// Standard variable declaration
$upperDirectoryCount = 1;
$title = "修改属性：" . $_GET["itemName"];
$mode = "admin";

// Auto loader for classes
include "../assets/includes/class-auto-loader.inc.php";

// Database Interaction
$view = new View();
$controller = new Controller();

//Get item information
$item = $view->getItem($_GET["itemName"]);
if ($item == null) header("location: item-management.php");
$i_id = $view->getItemId($item);
$categoryCount = sizeof($item->getCategories());
$propertyCount = sizeof($item->getVarieties());

/* Operation */

// Update data
function updateData($oldItem)
{

    // Convert file pointer to better array arrangement. Reference: https://www.php.net/manual/en/features.file-upload.multiple.php#53240
    $generalImageList = UsefulFunction::reArrayFiles($_FILES["item-image"]);
    $varietyImageList =  UsefulFunction::reArrayFiles($_FILES["variety-image"]);

    $generalImageCount = 0;
    foreach ($generalImageList as $g) {
        if ($g["name"] != "" and $g["name"] != "image-upload-alt.png") {
            $generalImageCount++;
        }
    }

    // Declare into item object
    $newItem = new Item($_POST["i_name"], $_POST["i_desc"], $_POST["i_brand"], $_POST["i_origin"], $_POST["i_property_name"], 0, $generalImageCount, 0); // New item's default value of listing and view count is 0

    // Declare into variety object
    if (isset($_POST["v"])) {

        $_POST["v"] = UsefulFunction::arrayIndexRearrage($_POST["v"]); //Rearrange array index for make sure all element is looped
        for ($i = 0; $i < sizeof($_POST["v"]); $i++) {

            if (isset($_POST["v"][$i]["v_property"]) and $_POST["v"][$i]["v_property"] != "" and isset($_POST["v"][$i]["v_barcode"]) and $_POST["v"][$i]["v_barcode"] != "") {

                $price = $_POST["v"][$i]["v_price"] == null ? 0.0 : $_POST["v"][$i]["v_price"];
                $discountedPrice = $_POST['v'][$i]["v_discounted_price"] == null ? $price : $_POST['v'][$i]["v_discounted_price"];
                $discountRate = $discountedPrice / $price ;

                $variety = new Variety($_POST["v"][$i]["v_barcode"], $_POST['v'][$i]['v_property'], $price, $_POST["v"][$i]["v_weight"] == null ? 0.0 : $_POST["v"][$i]["v_weight"], $discountRate);

                if (isset($_POST["v"][$i]["inv"])) {

                    $_POST["v"][$i]["inv"] = UsefulFunction::arrayIndexRearrage($_POST["v"][$i]["inv"]); //Rearrange array index for make sure all element is looped
                    for ($j = 0; $j < sizeof($_POST["v"][$i]["inv"]); $j++) {
                        if ($_POST["v"][$i]["inv"][$j]["inv_quantity"] != "" and isset($_POST["v"][$i]["inv"][$j]["inv_quantity"])) {
                            $inventory = new Inventory($_POST["v"][$i]["inv"][$j]["inv_expire_date"] == null ? date("Y-m-d") : $_POST["v"][$i]["inv"][$j]["inv_expire_date"], $_POST["v"][$i]["inv"][$j]["inv_quantity"]);
                            $variety->addInventory($inventory); //Add inventory to variety
                        }
                    }
                }

                $newItem->addVariety($variety); //Add variety to item
            }
        }

        $hasSamePrice = true;

        if (isset($_POST["v"][0]["v_property"]) and $_POST["v"][0]["v_property"] != ""){
            // Check all variety has same price
            $firstPrice = $newItem->getVarieties()[0]->getPrice();
            foreach($newItem->getVarieties() as $v){
                if($v->getPrice() != $firstPrice){
                    $hasSamePrice = false;
                    break;
                }
            }
        }

    }

    // Declare into catogories array
    if (isset($_POST["category"])) {
        for ($i = 0; $i < sizeof($_POST["category"]); $i++) {
            if ($_POST["category"][$i] != "" and isset($_POST["category"][$i])) {
                $newItem->addCategory($_POST["category"][$i]); //Add category to item
            }
        }
    }

    // Declare into wholesales array
    if(isset($_POST["w"]) and isset($_POST["v"]) and $hasSamePrice) {



        $_POST["w"] = UsefulFunction::arrayIndexRearrage($_POST["w"]); //Rearrange array index for make sure all element is looped


        if ($_POST["w"][0]["w_min"] != "" and isset($_POST["w"][0]["w_min"])){ // Make sure first min is not empty

            // Set min using min from first row
            $min = $_POST["w"][0]["w_min"];

            for($i = 0; $i < sizeof($_POST["w"]); $i++){
                if($_POST["w"][$i]["w_price"] != "" and isset($_POST["w"][$i]["w_price"])){
                    // Add wholesale to item
                    $discountRate = $_POST["w"][$i]["w_price"] / $_POST["v"][0]["v_price"];

                    if(array_key_exists("w_max", $_POST["w"][$i])){
                        if($_POST["w"][$i]["w_max"] == "" or $i == sizeof($_POST["w"])){
                            $newItem->addWholesale(new Wholesale($min, null, $discountRate));
                            break; // If the max is null, it will treat this as the last row to insert
                        } else{
                            $newItem->addWholesale(new Wholesale($min, $_POST["w"][$i]["w_max"], $discountRate));
                        }
                    } else{
                        $newItem->addWholesale(new Wholesale($min, null, $discountRate));
                        break; // If the max is existed in the row, it will treat this as the last row to insert
                    }

                    // Update min with current min from current row
                    $min = $_POST["w"][$i]["w_max"] + 1;
                }
            }

        }
    }

    // Update data in database
    $view = new View();
    $controller = new Controller();
    $i_id = $view->getItemId($oldItem);
    if (!$controller->updateItem($oldItem, $newItem, $i_id)) return false;

    // General image upload
    $imageFileHandler = new ImageFileHandler($generalImageList, $i_id);
    $imageFileHandler->uploadItemGeneralImage();

    // Variety image upload
    $oldBarcodeList = array();
    foreach ($oldItem->getVarieties() as $v) {
        array_push($oldBarcodeList, $v->getBarcode());
    }

    $newBarcodeList = array();
    foreach ($_POST["v"] as $v) {
        array_push($newBarcodeList, $v["v_barcode"]);
    }

    $imageFileHandler = new ImageFileHandler($varietyImageList, $i_id);
    $imageFileHandler->uploadItemVarietyImage($oldBarcodeList, $newBarcodeList);

    return true;
}

// Save only
if (isset($_POST["save"])) {
    if (!updateData($item)) {
        $message = "商品保存失败！商品可能没有在数据库，或者货号重叠！";
    } else {
        $message = "保存成功！";
    }
    UsefulFunction::generateAlert($message);
    header("refresh: 0"); //Refresh page immediately
}

// Save and list
if (isset($_POST["list"])) {
    $message = "";

    if (!updateData($item)) {
        $message = "商品保存失败！商品可能没有在数据库，或者货号重叠！\\n";
    } else {
        $message = "保存成功！\\n";
    }

    $listingErrorMessage = $controller->list($_POST["i_name"]);

    if ($listingErrorMessage == null) {
        if (UsefulFunction::createItemPage(json_decode($_POST["markup"]))) {
            $message = $message . "上架成功！\\n";
        } else {
            die("创建商品页面失败<br>错误代码：Error on php fwrite function.");
        }
    }

    $message = $message . $listingErrorMessage;

    UsefulFunction::generateAlert($message);
    header("refresh: 0"); //Refresh page immediately
}

// Reset view count
if (isset($_POST["reset-view-count-button"])) {
    $controller->resetViewCount($i_id);
    UsefulFunction::generateAlert("重置浏览次数成功！");
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

        <!-- Page content with row class -->
        <div class="row">

            <div class="col-sm-12 col-md-10">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="h1">商品属性编辑</div>

                    <div class="h2" id="step-one">基本资讯</div>
                    <div class="form-row">
                        <!-- Name -->
                        <div class="col-12">
                            <div class="form-row">
                                <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                                    <label>商品名称：</label>
                                </div>

                                <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                                    <input type="text" class="form-control" name="i_name" aria-describedby="i-name" maxlength="250" value="<?= $item->getName(); ?>" required />
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
                                    <textarea class="form-control" name="i_desc" aria-describedby="i-description" rows="5" maxlength="3000"><?= $item->getDescription(); ?></textarea>
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
                                    <input type="text" class="form-control" name="i_origin" aria-describedby="i-origin" value="<?= $item->getOrigin(); ?>" />
                                </div>
                            </div>
                        </div><!-- Origin -->
                        <!-- Brand -->
                        <div class="col-12">
                            <div class="form-row">
                                <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                                    <label>商品品牌：</label>
                                </div>

                                <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                                    <input type="text" class="form-control" name="i_brand" aria-describedby="i-brand" value="<?= $item->getBrand(); ?>" />
                                </div>
                            </div>
                        </div><!-- Brand -->
                        <!-- Category -->
                        <div class="col-12">
                            <!-- Current category list -->
                            <datalist id="category-list">
                                <?php foreach ($view->getCategoryList() as $category) : ?>
                                    <option value="<?= $category["cat_name"]; ?>"><?= $category["cat_name"]; ?></option>
                                <?php endforeach; ?>
                            </datalist><!-- Current category list -->

                            <div class="form-row">
                                <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                                    <label>商品类别/标签：</label>
                                </div>

                                <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                                    <div id="category-section">
                                        <?php if ($categoryCount == 0) : ?>
                                            <div class="row">
                                                <div class="col-11 mb-1 mr-0 pr-0"><input type="text" class="form-control" name="category[0]" aria-describedby="category" list="category-list" maxlength="20" /></div>
                                                <div class="col-1 mb-1 ml-0 pl-0"><button type="button" class="btn default-color white-text btn-sm remove-button px-3 py-1">X</button></div>
                                            </div>
                                        <?php else : ?>
                                            <?php for ($i = 0; $i < $categoryCount; $i++) : ?>
                                                <div class="row">
                                                    <div class="col-11 mb-1 mr-0 pr-0"><input type="text" class="form-control" name="category[<?= $i; ?>]" aria-describedby="category" list="category-list" maxlength="20" value="<?= $item->getCategories()[$i]; ?>" /></div>
                                                    <div class="col-1 mb-1 ml-0 pl-0"><button type="button" class="btn default-color white-text btn-sm remove-button px-3 py-1">X</button></div>
                                                </div>
                                            <?php endfor; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div><!-- Category -->
                        <!-- Add extra category button -->
                        <div class="col-12 text-center"><button type="button" class="btn btn-secondary" id="extra-category-button">添加更多类别/标签</button></div>

                        <div class="h2" id="step-two">规格资讯</div>

                        <!-- Property Name -->
                        <div class="col-12"><label>规格设定</label></div>
                        <div class="col-12">
                            <div class="form-row">
                                <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                                    <label>规格名称：</label>
                                </div>

                                <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                                    <input type="text" class="form-control" name="i_property_name" aria-describedby="i-property-name" value="<?= $item->getPropertyName(); ?>" />
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
                                    <div id="property-section">
                                        <?php if ($propertyCount == 0) : ?>
                                            <div class="row">
                                                <div class="col-11 mb-1 mr-0 pr-0"><input type="text" class="form-control v-property" name="v[0][v_property]" aria-describedby="v-property" maxlength="100" /></div>
                                                <div class="col-1 mb-1 ml-0 pl-0"><button type="button" class="btn default-color white-text btn-sm remove-button property-remove-button px-3 py-1">X</button></div>
                                            </div>
                                        <?php else : ?>
                                            <?php for ($i = 0; $i < $propertyCount; $i++) : ?>
                                                <div class="row">
                                                    <div class="col-11 mb-1 mr-0 pr-0"><input type="text" class="form-control v-property" name="v[<?= $i; ?>][v_property]" aria-describedby="v-property" maxlength="100" value="<?= $item->getVarieties()[$i]->getProperty(); ?>" /></div>
                                                    <div class="col-1 mb-1 ml-0 pl-0"><button type="button" class="btn default-color white-text btn-sm remove-button property-remove-button px-3 py-1">X</button></div>
                                                </div>
                                            <?php endfor; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div><!-- Property -->
                        <!-- Add extra variety button -->
                        <div class="col-12 text-center"><button type="button" class="btn btn-secondary mb-3" id="extra-property-button">添加更多规格</button></div>

                        <!-- Variety -->
                        <div class="col-12"><label>规格销售</label></div>
                        <div class="col-12 mb-3" style="overflow-x: scroll;">
                            <table class="table table-bordered" style="width: 900px;">
                                <thead>
                                    <tr>
                                        <th scope="col">选择</th>
                                        <th scope="col">商品货号</th>
                                        <th scope="col">价格(RM)</th>
                                        <th scope="col">重量(kg)</th>
                                        <th scope="col">折扣价钱</th>
                                    </tr>
                                </thead>

                                <tbody id="variety-table-section">
                                    <?php if ($propertyCount == 0) : ?>
                                        <tr>
                                            <td><input type="text" class="form-control v-property-view" disabled /></td>
                                            <td><input type="text" class="form-control" name="v[0][v_barcode]" aria-describedby="v-barcode" maxlength="20" /></td>
                                            <td><input type="number" step="0.01" min="0" class="form-control v-price" name="v[0][v_price]" aria-describedby="v-price"/></td>
                                            <td><input type="number" step="0.001" min="0" class="form-control" name="v[0][v_weight]" aria-describedby="v-weight"/></td>
                                            <td><input type="number" step="0.01" min="0" class="form-control v-discounted-price" name="v[0][v_discount_price]" aria-describedby="v-discounted-price"/></td>
                                        </tr>
                                    <?php else : ?>
                                        <?php for ($i = 0; $i < $propertyCount; $i++) : ?>
                                            <tr>
                                                <td><input type="text" class="form-control v-property-view" value="<?= $item->getVarieties()[$i]->getProperty(); ?>" disabled /></td>
                                                <td><input type="text" class="form-control" name="v[<?= $i; ?>][v_barcode]" aria-describedby="v-barcode" maxlength="20" value="<?= $item->getVarieties()[$i]->getBarcode(); ?>" /></td>
                                                <td><input type="number" step="0.01" min="0" class="form-control v-price" name="v[<?= $i; ?>][v_price]" aria-describedby="v-price" value="<?= number_format($item->getVarieties()[$i]->getPrice(), 2, '.', ''); ?>" /></td>
                                                <td><input type="number" step="0.001" min="0" class="form-control" name="v[<?= $i; ?>][v_weight]" aria-describedby="v-weight" value="<?=  number_format($item->getVarieties()[$i]->getWeight(), 3, '.', ''); ?>" /></td>
                                                <td><input type="number" step="0.01" min="0" max="<?= $item->getVarieties()[$i]->getPrice(); ?>" class="form-control v-discounted-price" name="v[<?= $i; ?>][v_discounted_price]" aria-describedby="v-discounted-price" value="<?= number_format($item->getVarieties()[$i]->getPrice() * $item->getVarieties()[$i]->getDiscountRate(), 2, '.', ''); ?>" /></td>
                                            </tr>
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div><!-- Variety -->

                        <!-- Inventory -->
                        <div class="col-12"><label>规格库存</label></div>
                        <div class="col-12 mb-3" style="overflow-x: scroll;">
                            <table class="table table-bordered" style="width: 900px;">
                                <thead>
                                    <tr>
                                        <th scope="col">选择</th>
                                        <th scope="col">过期日期</th>
                                        <th scope="col">数量</th>
                                    </tr>
                                </thead>

                                <tbody id="inventory-table-section">
                                    <?php if ($propertyCount == 0) : ?>
                                        <tr>
                                            <td><input type="text" class="form-control v-property-view" disabled /></td>
                                            <td colspan="2">
                                                <div class="variety-inventory-table-section">
                                                    <div class="row">
                                                        <div class="col-6"><input type="date" class="form-control mb-1" name="v[0][inv][0][inv_expire_date]" aria-describedby="inv-expire-date" /></div>
                                                        <div class="col-5"><input type="number" min="0" class="form-control mb-1" name="v[0][inv][0][inv_quantity]" aria-describedby="inv-quantity" /></div>
                                                        <div class="col-1 mb-1 ml-0 pl-0"><button type="button" class="btn default-color white-text btn-sm remove-button px-3 py-1">X</button></div>
                                                    </div>
                                                </div>
                                                <!-- Add extra inventory button -->
                                                <div class="text-center"><button type="button" class="btn btn-secondary mt-1 extra-inventory-button">添加更多库存</button></div>
                                            </td>
                                        </tr>
                                    <?php else : ?>
                                        <?php for ($i = 0; $i < $propertyCount; $i++) : ?>
                                            <tr>
                                                <td><input type="text" class="form-control v-property-view" value="<?= $item->getVarieties()[$i]->getProperty(); ?>" disabled /></td>
                                                <td colspan="2">
                                                    <div class="variety-inventory-table-section">
                                                        <?php $currentIventoryCount = sizeof($item->getVarieties()[$i]->getInventories()); ?>
                                                        <?php if ($currentIventoryCount == 0) : ?>
                                                            <div class="row">
                                                                <div class="col-6"><input type="date" class="form-control mb-1" name="v[<?= $i; ?>][inv][0][inv_expire_date]" aria-describedby="inv-expire-date" /></div>
                                                                <div class="col-5"><input type="number" min="0" class="form-control mb-1" name="v[<?= $i; ?>][inv][0][inv_quantity]" aria-describedby="inv-quantity" /></div>
                                                                <div class="col-1 mb-1 ml-0 pl-0"><button type="button" class="btn default-color white-text btn-sm remove-button px-3 py-1">X</button></div>
                                                            </div>
                                                        <?php else : ?>
                                                            <?php for ($j = 0; $j < $currentIventoryCount; $j++) : ?>
                                                                <div class="row">
                                                                    <div class="col-6"><input type="date" class="form-control mb-1" name="v[<?= $i; ?>][inv][<?= $j; ?>][inv_expire_date]" aria-describedby="inv-expire-date" value="<?= $item->getVarieties()[$i]->getInventories()[$j]->getExpireDate(); ?>" /></div>
                                                                    <div class="col-5"><input type="number" min="0" class="form-control mb-1" name="v[<?= $i; ?>][inv][<?= $j; ?>][inv_quantity]" aria-describedby="inv-quantity" value="<?= $item->getVarieties()[$i]->getInventories()[$j]->getQuantity(); ?>" /></div>
                                                                    <div class="col-1 mb-1 ml-0 pl-0"><button type="button" class="btn default-color white-text btn-sm remove-button px-3 py-1">X</button></div>
                                                                </div>
                                                            <?php endfor; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <!-- Add extra inventory button -->
                                                    <div class="text-center"><button type="button" class="btn btn-secondary mt-1 extra-inventory-button">添加更多库存</button></div>
                                                </td>
                                            </tr>
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div><!-- Inventory -->

                        <!-- Wholesale -->
                        <div class="col-12 wholesale-section"><label>批发价管理（单件规格折扣后的规格将无视此设定）</label></div>
                        <div class="col-12 mb-3 wholesale-section" style="overflow-x: scroll;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">开始数量</th>
                                        <th scope="col">结束数量</th>
                                        <th scope="col">价格(RM)</th>
                                        <th scope="col">操作</th>
                                    </tr>
                                </thead>

                                <tbody id="wholesale-table-section">
                                    <?php $wholesaleCount = sizeof($item->getWholesales()); ?>
                                    <?php if ($wholesaleCount == 0) : ?>
                                        <tr>
                                            <td><input type="number" class="form-control mb-1 w-min" min="1" name="w[0][w_min]" aria-describedby="w-min"/></td>
                                            <td><input type="number" class="form-control mb-1 w-max" min="1" name="w[0][w_max]" aria-describedby="w-max" disabled/></td>
                                            <td><input type="number" class="form-control mb-1 w-price" step="0.01" min="0.01" name="w[0][w_price]" aria-describedby="w-price"/></td>
                                            <td><button type="button" class="btn default-color white-text btn-sm remove-button wholesale-remove-button px-3 py-1">X</button></td>
                                        </tr>
                                    <?php else : ?>
                                        <?php $maxPrice = $item->getVarieties()[0]->getPrice(); ?>
                                        <?php for($i = 0; $i < $wholesaleCount; $i++) : ?>
                                            <?php $discountedPrice = number_format($item->getVarieties()[0]->getPrice() * $item->getWholesales()[$i]->getDiscountRate(), 2, '.', ''); ?>
                                            <tr>
                                                <td><input type="number" class="form-control mb-1 w-min" min="1" name="w[<?= $i; ?>][w_min]" aria-describedby="w-min" value="<?= $item->getWholesales()[$i]->getMin(); ?>" <?= $i != 0 ? "disabled" : ""; ?>/></td>
                                                <td><input type="number" class="form-control mb-1 w-max" min="<?= $item->getWholesales()[$i]->getMin(); ?>" name="w[<?= $i; ?>][w_max]" aria-describedby="w-max" value="<?= $item->getWholesales()[$i]->getMax(); ?>" <?= ($i == ($wholesaleCount - 1)) ? "disabled" : ""; ?>/></td>
                                                <td><input type="number" class="form-control mb-1 w-price" step="0.01" min="0.01" max="<?= $maxPrice ?>" name="w[<?= $i; ?>][w_price]" aria-describedby="w-price" value="<?= $discountedPrice ?>"/></td>
                                                <td><button type="button" class="btn default-color white-text btn-sm remove-button wholesale-remove-button px-3 py-1" <?= $i != $wholesaleCount - 1 ? "disabled" : ""; ?>>X</button></td>
                                            </tr>
                                            <?php $maxPrice = $discountedPrice; ?>
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <!-- Add extra wholesales button -->
                            <div class="text-center"><button type="button" class="btn btn-secondary mt-1" id="extra-wholesale-button">添加更多批发价</button></div>
                        </div><!-- Wholesale -->

                        <div class="h2" id="step-three">媒体管理</div>

                        <style>
                            .img-upload-container {
                                position: relative;
                                width: 100%;
                                max-width: 400px;
                            }

                            .img-upload-overlay {
                                position: absolute;
                                top: 0;
                                bottom: 0;
                                left: 0;
                                right: 0;
                                height: 100%;
                                width: 100%;
                                opacity: 0;
                                transition: .3s ease;
                                background-color: grey;
                            }


                            .img-upload-container:hover .img-upload-overlay {
                                opacity: 1.0;
                            }

                            .icofont-ui-delete:hover .icofont-edit:hover {
                                color: #eee;
                            }

                            .img-upload-overlay-icon {
                                color: white;
                                transform: translate(-50%, -50%);
                                -ms-transform: translate(-50%, -50%);
                                text-align: center;
                            }

                            .remove-img-button {
                                font-size: 20px;
                                position: absolute;
                                top: 50%;
                                right: 15%;
                            }

                            .edit-img-button {
                                font-size: 20px;
                                position: absolute;
                                top: 50%;
                                left: 30%;
                            }
                        </style>

                        <div class="col-12 mb-3">

                            <div class="form-row general-image-section">

                                <div class="col-12"><label>基本照片</label></div>

                                <!-- Cover picture (0.jpg) -->
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <input type="file" name="item-image[0]" class="image-file-selector" style="display:none;" />
                                    <figure class="figure">
                                        <div class="img-upload-container">
                                            <img class="img-fluid image-preview" src="<?= file_exists("../assets/images/items/$i_id/0.jpg") ? "../assets/images/items/$i_id/0.jpg" : "../assets/images/alt/image-upload-alt.png"; ?>" />
                                            <div class="img-upload-overlay">
                                                <div class="img-upload-overlay-icon edit-img-button" title="Upload Image" onclick="uploadImage(this)">
                                                    <i class="icofont-edit"></i>
                                                </div>
                                                <div class="img-upload-overlay-icon remove-img-button" title="Remove Image" onclick="removeImage(this)">
                                                    <i class="icofont-ui-delete"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <figcaption class="figure-caption text-center">封面</figcaption>
                                    </figure>
                                </div><!-- Cover picture (0.jpg) -->

                                <!-- General picture -->
                                <?php for ($i = 1; $i <= 8; $i++) : ?>
                                    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                        <input type="file" name="item-image[<?= $i; ?>]" class="image-file-selector" style="display:none;" />
                                        <figure class="figure">
                                            <div class="img-upload-container">
                                                <img class="img-fluid image-preview" src="<?= file_exists("../assets/images/items/$i_id/$i.jpg") ? "../assets/images/items/$i_id/$i.jpg" : "../assets/images/alt/image-upload-alt.png"; ?>" />
                                                <div class="img-upload-overlay">
                                                    <div class="img-upload-overlay-icon edit-img-button" title="Upload Image" onclick="uploadImage(this)">
                                                        <i class="icofont-edit"></i>
                                                    </div>
                                                    <div class="img-upload-overlay-icon remove-img-button" title="Remove Image" onclick="removeImage(this)">
                                                        <i class="icofont-ui-delete"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <figcaption class="figure-caption text-center">照片 <?= $i ?></figcaption>
                                        </figure>
                                    </div><?php endfor; ?>
                                <!-- General picture -->

                            </div>

                        </div>

                        <!-- Variety image section -->
                        <div class="col-12 mb-3">

                            <div class="form-row" id="variety-image-section">
                                <div class="col-12"><label>规格照片<label></div>
                                <?php if ($propertyCount == 0) : ?>
                                    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                        <input type="file" name="variety-image[0]" class="image-file-selector" style="display:none;" />
                                        <figure class="figure">
                                            <div class="img-upload-container">
                                                <img class="img-fluid image-preview" src="../assets/images/alt/image-upload-alt.png" />
                                                <div class="img-upload-overlay">
                                                    <div class="img-upload-overlay-icon edit-img-button" title="Upload Image" onclick="uploadImage(this)">
                                                        <i class="icofont-edit"></i>
                                                    </div>
                                                    <div class="img-upload-overlay-icon remove-img-button" title="Remove Image" onclick="removeImage(this)">
                                                        <i class="icofont-ui-delete"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <figcaption class="figure-caption text-center">照片 <?= $i ?></figcaption>
                                        </figure>
                                    </div>
                                <?php else : ?>
                                    <?php for ($i = 0; $i < $propertyCount; $i++) : ?>
                                        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                            <input type="file" name="variety-image[<?= $i; ?>]" class="image-file-selector" style="display:none;" />
                                            <figure class="figure">
                                                <div class="img-upload-container">
                                                    <?php $b = $item->getVarieties()[$i]->getBarcode(); ?>
                                                    <img class="img-fluid image-preview" src="<?= file_exists("../assets/images/items/$i_id/$b.jpg") ? "../assets/images/items/$i_id/$b.jpg" : "../assets/images/alt/image-upload-alt.png"; ?>" />
                                                    <div class="img-upload-overlay">
                                                        <div class="img-upload-overlay-icon edit-img-button" title="Upload Image" onclick="uploadImage(this)">
                                                            <i class="icofont-edit"></i>
                                                        </div>
                                                        <div class="img-upload-overlay-icon remove-img-button" title="Remove Image" onclick="removeImage(this)">
                                                            <i class="icofont-ui-delete"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <figcaption class="figure-caption text-center variety-property-caption"><?= $item->getVarieties()[$i]->getProperty(); ?></figcaption>
                                            </figure>
                                        </div>
                                    <?php endfor; ?>
                                <?php endif; ?>
                            </div>

                        </div><!-- Variety image section -->




                        <div classs="col-12 mb-3">
                            <div class="row">
                                <div class="h2" id="step-four">其他商品设定</div><br>
                                <div class="col-12">
                                    <div class="mx-auto">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">设定名称</th>
                                                    <th scope="col">数值</th>
                                                    <th scope="col">操作</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td>商品浏览次数</td>
                                                    <td><input type="text" class="form-control form-control-sm" value="<?= $item->getViewCount(); ?>" disabled /></td>
                                                    <td><button type="submit" class="btn btn-primary btn-sm" name="reset-view-count-button">重置</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>


                        </div>

                        <div class="col-12 text-center mb-3">
                            <input class="btn btn-primary mr-2" type="submit" value="保存" name="save" style="width: 200px">
                            <input class="btn btn-primary" type="submit" value="保存并上架" name="list" style="width: 200px">
                        </div>

                    </div>

                    <input type="text" name="markup" value="empty" id="markup" hidden />

                </form>
            </div>

            <!-- Navigation guideline -->
            <div class="col-sm-0 col-md-2">
                <div style="position: fixed;" id="menu-list">
                    <ul class="list-group text-center">
                        <a href="#step-one" id="step-one-link" class="item-create-step-info list-group-item list-group-item-action active">基本资讯</a>
                        <a href="#step-two" id="step-two-link" class="item-create-step-info list-group-item list-group-item-action">销售资料</a>
                        <a href="#step-three" id="step-three-link" class="item-create-step-info list-group-item list-group-item-action">媒体管理</a>
                        <a href="#step-four" id="step-four-link" class="item-create-step-info list-group-item list-group-item-action">其他商品设定</a>
                    </ul>
                </div>
            </div><!-- Navigation guideline -->

        </div><!-- Page content with row class -->

    </main>

    <script src="../assets/js/item-page-generator.js"></script>

    <script src="../assets/js/admin-item-management-page.js"></script>

</body>

</html>
