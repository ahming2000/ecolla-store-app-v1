<?php
/* Authorization */
if(!isset($_COOKIE["username"])) header("location: login.php");
if(!isset($_GET["itemName"])) header("location: item-management.php");

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
if($item == null) header("location: item-management.php");
$i_id = $view->getItemId($item);
$categoryCount = sizeof($item->getCategories());
$propertyCount = sizeof($item->getVarieties());

/* Operation */

// Update data
function updateData($oldItem){

    // Convert file pointer to better array arrangement. Reference: https://www.php.net/manual/en/features.file-upload.multiple.php#53240
    $generalImageListWithDummy = UsefulFunction::reArrayFiles($_FILES["item-image"]);
    // Check list all image into an array
    $generalImageList = array();
    for($i = 0; $i < sizeof($generalImageListWithDummy); $i++){
        if($generalImageListWithDummy[$i]["name"] != "image-upload-alt.png"){
            //Used to rearrage the index for image upload later
            array_push($generalImageList, $generalImageListWithDummy[$i]);
        }
    }

    // Declare into item object
    $newItem = new Item($_POST["i_name"], $_POST["i_desc"], $_POST["i_brand"], $_POST["i_origin"], $_POST["i_property_name"], 0, sizeof($generalImageList), 0); // New item's default value of listing and view count is 0
    // Declare into variety object
    for($i = 0; $i < sizeof($_POST["v"]); $i++){
        if($_POST["v"][$i]["v_property"] != ""){
            $variety = new Variety($_POST["v"][$i]["v_barcode"], $_POST['v'][$i]['v_property'], $_POST["v"][$i]["v_price"], $_POST["v"][$i]["v_weight"], 1.0); //$_POST['v'][$i]["v_discount_rate"]

            for($j = 0; $j < sizeof($_POST["v"][$i]["inv"]); $j++){
                if($_POST["v"][$i]["inv"][$j]["inv_quantity"] != ""){
                    $inventory = new Inventory($_POST["v"][$i]["inv"][$j]["inv_expire_date"], $_POST["v"][$i]["inv"][$j]["inv_quantity"]);
                    $variety->addInventory($inventory); //Add inventory to variety
                }
            }

            $newItem->addVariety($variety); //Add variety to item
        }
    }
    // Declare into catogories array
    if (isset($_POST["category"])){
        for($i = 0; $i < sizeof($_POST["category"]); $i++){
            if($_POST["category"][$i] != ""){
                $newItem->addCategory($_POST["category"][$i]); //Add category to item
            }
        }
    }

    // Update data in database
    $view = new View();
    $controller = new Controller();
    $i_id = $view->getItemId($oldItem);
    if(!$controller->updateItem($oldItem, $newItem, $i_id)) return false;

    die("Break at item-edit.php");

    // General image upload
    for($i = 0; $i < sizeof($generalImageList); $i++){
        $imageFileHandler = new ImageFileHandler($generalImageList[$i], $i, $i_id);
        $imageFileHandler->uploadItemImage();
    }

    // Variety image upload
    $varietyImageList =  UsefulFunction::reArrayFiles($_FILES["variety-image"]);
    for($i = 0; $i < sizeof($varietyImageList); $i++){
        if($varietyImageList[$i]["name"] != "image-upload-alt.png"){
            $imageFileHandler = new ImageFileHandler($varietyImageList[$i], $_POST["v"][$i]["v_barcode"]);
            $imageFileHandler->uploadItemImage();
        }
    }

    return true;
}

// Save only
if(isset($_POST["save"])){
    if(!updateData($item)){
        $message = "数据库更新失败，请联络客服人员！";
        $alertType = "alert-danger";
    } else{
        $message = "保存成功！";
        $alertType = "alert-success";
    }
}

// Save and list
if(isset($_POST["list"])){
    $message = "";

    if(!updateData($item)){
        $message = "数据库更新失败，请联络客服人员！";
    } else{
        $message = "保存成功！";
    }

    $listingErrorMessage = $controller->list($_POST["i_name"]);

    if($listingErrorMessage) UsefulFunction::createItemPage($_POST["markup"]);

    $message = $message . $listingErrorMessage;
    $alertType = "alert-warning";
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

            <div class="col-12">
                <div class="alert <?= isset($alertType) ? $alertType : ""; ?>" role="alert">
                    <?= isset($message) ? $message : ""; ?>
                </div>
            </div>

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
                                    <input type="text" class="form-control" name="i_name" aria-describedby="i-name" maxlength="250" value="<?= $item->getName(); ?>" required/>
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
                                    <input type="text" class="form-control" name="i_origin" aria-describedby="i-origin" value="<?= $item->getOrigin(); ?>"/>
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
                                    <input type="text" class="form-control" name="i_brand" aria-describedby="i-brand" value="<?= $item->getBrand(); ?>"/>
                                </div>
                            </div>
                        </div><!-- Brand -->
                        <!-- Category -->
                        <div class="col-12">
                            <!-- Current category list -->
                            <datalist id="category-list">
                                <?php foreach($view->getCategoryList() as $category) : ?>
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
                                                <div class="col-11 mb-1 mr-0 pr-0"><input type="text" class="form-control" name="category[0]" aria-describedby="category" list="category-list" maxlength="20"/></div>
                                                <div class="col-1 mb-1 ml-0 pl-0"><button type="button" class="btn default-color white-text btn-sm remove-button px-3 py-1">X</button></div>
                                            </div>
                                        <?php else : ?>
                                            <?php for($i = 0; $i < $categoryCount; $i++) : ?>
                                                <div class="row">
                                                    <div class="col-11 mb-1 mr-0 pr-0"><input type="text" class="form-control" name="category[<?= $i; ?>]" aria-describedby="category" list="category-list" maxlength="20" value="<?= $item->getCategories()[$i]; ?>"/></div>
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
                                    <input type="text" class="form-control" name="i_property_name" aria-describedby="i-property-name" value="<?= $item->getPropertyName(); ?>"/>
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
                                                <div class="col-11 mb-1 mr-0 pr-0"><input type="text" class="form-control v-property" name="v[0][v_property]" aria-describedby="v-property" maxlength="100"/></div>
                                                <div class="col-1 mb-1 ml-0 pl-0"><button type="button" class="btn default-color white-text btn-sm remove-button property-remove-button px-3 py-1">X</button></div>
                                            </div>
                                        <?php else : ?>
                                            <?php for($i = 0; $i < $propertyCount; $i++) : ?>
                                                <div class="row">
                                                    <div class="col-11 mb-1 mr-0 pr-0"><input type="text" class="form-control v-property" name="v[<?= $i; ?>][v_property]" aria-describedby="v-property" maxlength="100" value="<?= $item->getVarieties()[$i]->getProperty(); ?>"/></div>
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
                                        <?php if($propertyCount == 0) : ?>
                                            <tr>
                                                <td><input type="text" class="form-control v-property-view" disabled/></td>
                                                <td><input type="text" class="form-control" name="v[0][v_barcode]" aria-describedby="v-barcode" maxlength="20"/></td>
                                                <td><input type="number" step="0.01" min="0" class="form-control" name="v[0][v_price]" aria-describedby="v-price" maxlength="10"/></td>
                                                <td><input type="number" step="0.001" min="0" class="form-control" name="v[0][v_weight]" aria-describedby="v-weight" maxlength="10"/></td>
                                            </tr>
                                        <?php else : ?>
                                            <?php for($i = 0; $i < $propertyCount; $i++) : ?>
                                                <tr>
                                                    <td><input type="text" class="form-control v-property-view" value="<?= $item->getVarieties()[$i]->getProperty(); ?>" disabled/></td>
                                                    <td><input type="text" class="form-control" name="v[<?= $i; ?>][v_barcode]" aria-describedby="v-barcode" maxlength="20" value="<?= $item->getVarieties()[$i]->getBarcode(); ?>"/></td>
                                                    <td><input type="number" step="0.01" min="0" class="form-control" name="v[<?= $i; ?>][v_price]" aria-describedby="v-price" maxlength="10" value="<?= $item->getVarieties()[$i]->getPrice(); ?>"/></td>
                                                    <td><input type="number" step="0.001" min="0" class="form-control" name="v[<?= $i; ?>][v_weight]" aria-describedby="v-weight" maxlength="10" value="<?= $item->getVarieties()[$i]->getWeight(); ?>"/></td>
                                                </tr>
                                            <?php endfor; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- Variety -->

                        <!-- Inventory -->
                        <div class="col-12"><label>规格库存</label></div>
                        <div class="col-12 mb-3">
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
                                        <?php if($propertyCount == 0) : ?>
                                            <tr>
                                                <td><input type="text" class="form-control v-property-view" disabled/></td>
                                                <td colspan="2">
                                                    <div class="variety-inventory-table-section">
                                                        <div class="row">
                                                            <div class="col-5"><input type="date" class="form-control mb-1" name="v[0][inv][0][inv_expire_date]" aria-describedby="inv-expire-date"/></div>
                                                            <div class="col-5"><input type="number" min="0" class="form-control mb-1" name="v[0][inv][0][inv_quantity]" aria-describedby="inv-quantity"/></div>
                                                            <div class="col-1 mb-1 ml-0 pl-0"><button type="button" class="btn default-color white-text btn-sm remove-button px-3 py-1">X</button></div>
                                                        </div>
                                                    </div>
                                                    <!-- Add extra inventory button -->
                                                    <div class="text-center"><button type="button" class="btn btn-secondary mt-1 extra-inventory-button">添加更多库存</button></div>
                                                </td>
                                            </tr>
                                        <?php else : ?>
                                            <?php for($i = 0; $i < $propertyCount; $i++) : ?>
                                                <tr>
                                                    <td><input type="text" class="form-control v-property-view"  value="<?= $item->getVarieties()[$i]->getProperty(); ?>" disabled/></td>
                                                    <td colspan="2">
                                                        <div class="variety-inventory-table-section">
                                                            <?php $currentIventoryCount = sizeof($item->getVarieties()[$i]->getInventories()); ?>
                                                            <?php if ($currentIventoryCount == 0) : ?>
                                                                <div class="row">
                                                                    <div class="col-5"><input type="date" class="form-control mb-1" name="v[<?= $i; ?>][inv][0][inv_expire_date]" aria-describedby="inv-expire-date"/></div>
                                                                    <div class="col-5"><input type="number" min="0" class="form-control mb-1" name="v[<?= $i; ?>][inv][0][inv_quantity]" aria-describedby="inv-quantity"/></div>
                                                                    <div class="col-1 mb-1 ml-0 pl-0"><button type="button" class="btn default-color white-text btn-sm remove-button px-3 py-1">X</button></div>
                                                                </div>
                                                            <?php else : ?>
                                                                <?php for($j = 0; $j < $currentIventoryCount; $j++) : ?>
                                                                    <div class="row">
                                                                        <div class="col-5"><input type="date" class="form-control mb-1" name="v[<?= $i; ?>][inv][<?= $j; ?>][inv_expire_date]" aria-describedby="inv-expire-date" value="<?= $item->getVarieties()[$i]->getInventories()[$j]->getExpireDate(); ?>"/></div>
                                                                        <div class="col-5"><input type="number" min="0" class="form-control mb-1" name="v[<?= $i; ?>][inv][<?= $j; ?>][inv_quantity]" aria-describedby="inv-quantity" value="<?= $item->getVarieties()[$i]->getInventories()[$j]->getQuantity(); ?>"/></div>
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
                            </div>
                        </div><!-- Inventory -->

                        <div class="h2" id="step-three">媒体管理</div>

                        <div class="col-12 mb-3">

                            <div class="form-row general-image-section">

                                <div class="col-12"><label>基本照片</label></div>

                                <!-- Cover picture (0.jpg) -->
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[0]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="<?= file_exists("../assets/images/items/$i_id/0.jpg") ? "../assets/images/items/$i_id/0.jpg" : "../assets/images/alt/image-upload-alt.png"; ?>"/>
                                        <div style="text-align: center;">封面</div>
                                    </label>
                                </div><!-- Cover picture (0.jpg) -->

                                <!-- Cover picture (1.jpg) -->
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[1]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="<?= file_exists("../assets/images/items/$i_id/1.jpg") ? "../assets/images/items/$i_id/1.jpg" : "../assets/images/alt/image-upload-alt.png"; ?>"/>
                                        <div style="text-align: center;">照片 1</div>
                                    </label>
                                </div><!-- Cover picture (1.jpg) -->

                                <!-- Cover picture (2.jpg) -->
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[2]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="<?= file_exists("../assets/images/items/$i_id/2.jpg") ? "../assets/images/items/$i_id/2.jpg" : "../assets/images/alt/image-upload-alt.png"; ?>"/>
                                        <div style="text-align: center;">照片 2</div>
                                    </label>
                                </div><!-- Cover picture (2.jpg) -->

                                <!-- Cover picture (3.jpg) -->
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[3]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="<?= file_exists("../assets/images/items/$i_id/3.jpg") ? "../assets/images/items/$i_id/3.jpg" : "../assets/images/alt/image-upload-alt.png"; ?>"/>
                                        <div style="text-align: center;">照片 3</div>
                                    </label>
                                </div><!-- Cover picture (3.jpg) -->

                                <!-- Cover picture (4.jpg) -->
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[4]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="<?= file_exists("../assets/images/items/$i_id/4.jpg") ? "../assets/images/items/$i_id/4.jpg" : "../assets/images/alt/image-upload-alt.png"; ?>"/>
                                        <div style="text-align: center;">照片 4</div>
                                    </label>
                                </div><!-- Cover picture (4.jpg) -->

                                <!-- Cover picture (5.jpg) -->
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[5]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="<?= file_exists("../assets/images/items/$i_id/5.jpg") ? "../assets/images/items/$i_id/5.jpg" : "../assets/images/alt/image-upload-alt.png"; ?>"/>
                                        <div style="text-align: center;">照片 5</div>
                                    </label>
                                </div><!-- Cover picture (5.jpg) -->

                                <!-- Cover picture (6.jpg) -->
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[6]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="<?= file_exists("../assets/images/items/$i_id/6.jpg") ? "../assets/images/items/$i_id/6.jpg" : "../assets/images/alt/image-upload-alt.png"; ?>"/>
                                        <div style="text-align: center;">照片 6</div>
                                    </label>
                                </div><!-- Cover picture (6.jpg) -->

                                <!-- Cover picture (7.jpg) -->
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[7]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="<?= file_exists("../assets/images/items/$i_id/7.jpg") ? "../assets/images/items/$i_id/7.jpg" : "../assets/images/alt/image-upload-alt.png"; ?>"/>
                                        <div style="text-align: center;">照片 7</div>
                                    </label>
                                </div><!-- Cover picture (7.jpg) -->

                                <!-- Cover picture (8.jpg) -->
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                    <label>
                                        <input type="file" name="item-image[8]" class="image-file-selector" style="display:none;"/>
                                        <img class="img-fluid image-preview" src="<?= file_exists("../assets/images/items/$i_id/8.jpg") ? "../assets/images/items/$i_id/8.jpg" : "../assets/images/alt/image-upload-alt.png"; ?>"/>
                                        <div style="text-align: center;">照片 8</div>
                                    </label>
                                </div><!-- Cover picture (8.jpg) -->

                            </div>

                        </div>

                        <!-- Variety image section -->
                        <div class="col-12 mb-3">



                            <div class="form-row" id="variety-image-section">
                                <div class="col-12"><label>规格照片<label></div>
                                <?php if ($propertyCount == 0) : ?>
                                    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                        <label>
                                            <input type="file" name="variety-image[0]" class="image-file-selector" style="display:none;"/>
                                            <img class="img-fluid image-preview" src="../assets/images/alt/image-upload-alt.png"/>
                                            <div style="text-align: center;" class="variety-property-caption"></div>
                                        </label>
                                    </div>
                                <?php else : ?>
                                    <?php for($i = 0; $i < $propertyCount; $i++) : ?>
                                        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                            <label>
                                                <input type="file" name="variety-image[<?= $i; ?>]" class="image-file-selector" style="display:none;"/>
                                                <?php $b = $item->getVarieties()[$i]->getBarcode(); ?>
                                                <img class="img-fluid image-preview" src="<?= file_exists("../assets/images/items/$i_id/$b.jpg") ? "../assets/images/items/$i_id/$b.jpg" : "../assets/images/alt/image-upload-alt.png"; ?>"/>
                                                <div style="text-align: center;" class="variety-property-caption"><?= $item->getVarieties()[$i]->getProperty(); ?></div>
                                            </label>
                                        </div>
                                    <?php endfor; ?>
                                <?php endif; ?>
                            </div>

                        </div><!-- Variety image section -->

                        <div class="col-12 text-center mb-3">
                            <input class="btn btn-primary mr-2" type="submit" value="保存" name="save" style="width: 200px">
                            <input class="btn btn-primary" type="submit" value="保存并上架" name="list" style="width: 200px">
                        </div>

                    </div>

                    <input type="text" name="markup" value="empty" id="markup" hidden/>

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

    <script src="../assets/js/item-page-generator.js"></script>

    <script src="../assets/js/admin-item-management-page.js"></script>

</body>
</html>
