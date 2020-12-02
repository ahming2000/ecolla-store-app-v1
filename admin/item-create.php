<?php $upperDirectoryCount = 1; include "../assets/includes/class-auto-loader.inc.php"; //Auto include all the classes. ?>
<?php if(!isset($_COOKIE["username"])) header("location: login.php"); ?>

    <?php $view = new View(); ?>
    <?php
    if(isset($_POST["submit"])){


        $item = new Item($_POST["name"], $_POST["brand"], $_POST["country"], isset($_POST["isListed"]) ? 1 : 0, 1);
        $v = new Variety($_POST["barcode1"], $_POST["property1"], $_POST["propertyName1"], $_POST["price1"], $_POST["weight1"], $_POST["weightUnit1"], 1.0);
        $v->addInventory(new Inventory($_POST["expireDate1"], $_POST["quantity1"]));
        $item->addVariety($v);
        $item->addCatogory($_POST["catogory"]);

        $controller = new Controller();
        $controller->insertNewItem($item);

        // $newPHPFile = fopen("../items/".str_replace(" ", "-", $item->getName()).".php", "w") or die("Error on creating new php file!");
        // $template = fopen("../items/item-page-template.txt", "r") or die("Error on opening the item php file template!");
        //
        // while(!feof($template)){
        //     $str = fgets($template);
        //
        //     if($str === "<!--Name-->"){
        //         fwrite($newPHPFile, strval($item->getName()));
        //     }
        //
        //     if(UsefulFunction::startsWith($str, "<!--")){
        //         //Implement dynamic information
        //         if(UsefulFunction::startsWith($str, "<!--Catogory-->")){
        //             fwrite($newPHPFile, strtolower($item->getCatogory()));
        //         }
        //         else if(UsefulFunction::startsWith($str, "<!--Name-->")){
        //             fwrite($newPHPFile, $item->getName());
        //         }
        //         else if(UsefulFunction::startsWith($str, "<!--ImgPath-->")){
        //             for($i = 0; $i < sizeof($item->getImgPath()); $i++){
        //                 fwrite($newPHPFile, $item->getImgPath[$i]);
        //             }
        //         }
        //     } else{
        //         fwrite($newPHPFile, $str); //Read from template
        //     }
        // }
        // fclose($template);
        // fclose($newPHPFile);
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <?php $upperDirectoryCount = 1; $title = "创建新商品"; include "../assets/includes/stylesheet-script-declaration.inc.php" ?>
    </head>

    <body>
        <div class="container-sm" style="margin-top: 100px;">

            <?php include_once "../assets/block-admin-page/header.php"; ?>

            <!-- Page content with row class -->
            <div class="row">

                <div class="col-sm-12 col-md-10">
                    <form action="" method="post">
                        <div class="h1">创建新商品</div>

                        <div class="h2" id="step-one">基本资讯</div>
                        <div class="form-row">
                            <!-- Name -->
                            <div class="col-12">
                                <div class="form-row">
                                    <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                                        <label for="name">* 商品名称：</label>
                                    </div>

                                    <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                                        <input type="text" class="form-control" name="name" aria-describedby="name" maxlength="250" required/>
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
                                        <textarea class="form-control" name="description" aria-describedby="description" rows="5" maxlength="3000"></textarea>
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
                                        <input type="text" class="form-control" name="origin" aria-describedby="origin">
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
                                        <input type="text" class="form-control" name="brand" aria-describedby="brand">
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
                                            <div class="col-12 mb-1"><input type="text" class="form-control" name="catogory[0]" aria-describedby="catogory" list="catogoryList" maxlength="20"/></div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- Catogory -->
                            <!-- Add extra catogory button -->
                            <div class="col-12 text-center"><button type="button" class="btn btn-secondary" id="extraCatogory">添加更多类别/标签</button></div>

                            <div class="h2" id="step-two">规格资讯</div>

                            <div class="col-12"><label for="property">规格设定</label></div>
                            <!-- Property Name -->
                            <div class="col-12">
                                <div class="form-row">
                                    <div class="col-xs-2 col-sm-4 col-md-3 col-lg-4 text-sm-left text-md-right mb-3">
                                        <label for="variety-property-name">规格名称：</label>
                                    </div>

                                    <div class="col-xs-10 col-sm-8 col-md-9 col-lg-8 mb-3 text-center">
                                        <input type="text" class="form-control" name="variety-property-name" aria-describedby="variety-property-name" onchange="syncVariety(this)" />
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
                                            <div class="col-12 mb-1"><input type="text" class="form-control variety-property" name="variety[0]['property']" aria-describedby="variety-property" maxlength="100"/></div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- Property -->
                            <!-- Add extra variety button -->
                            <div class="col-12 text-center"><button type="button" class="btn btn-secondary mb-3" id="extraProperty">添加更多规格</button></div>

                            <div class="col-12"><label for="variety-table">规格销售</label></div>
                            <!-- Variety -->
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
                                            <tr>
                                                <td><input type="text" class="form-control variety-property" name="variety[0]['property']" aria-describedby="variety-property" maxlength="100" disabled/></td>
                                                <td><input type="text" class="form-control variety-barcode" name="variety[0]['barcode']" aria-describedby="variety-barcode" maxlength="20" required/></td>
                                                <td><input type="number" class="form-control variety-price" name="variety[0]['price']" aria-describedby="variety-price" maxlength="10" required/></td>
                                                <td><input type="number" class="form-control variety-weight" name="variety[0]['weight']" aria-describedby="variety-weight" maxlength="10" required/></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- Variety -->

                            <div class="col-12"><label for="inventory-table">规格库存</label></div>
                            <!-- Inventory -->
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
                                                <td><input type="text" class="form-control variety-property" name="variety[0]['property']" aria-describedby="variety-property" maxlength="100" disabled/></td>
                                                <td colspan="2">
                                                    <div class="form-row inventory-section-class">
                                                        <input type="number" value="1" id="inventory-count" hidden/>
                                                        <div class="col-6"><input type="date" class="form-control inventory-expire-date mb-1" name="variety[0]['inventory'][0]['expireDate']" aria-describedby="inventory-expire-date" required/></div>
                                                        <div class="col-6"><input type="number" class="form-control inventory-quantity mb-1" name="variety[0]['inventory'][0]['quantity']" aria-describedby="inventory-quantity" required/></div>
                                                    </div>
                                                    <!-- Add extra inventory button -->
                                                    <div class="text-center"><button type="button" class="btn btn-secondary mt-1 extra-inventory-class">添加更多库存</button></div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- Inventory -->

                            <div class="h2">媒体资料</div>

                            <!-- TO-DO: REWORK THIS PART -->

                            <div class="form-group">
                                <label>上传照片</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="imgVariety1" id="imgVariety1">
                                    <label class="custom-file-label" for="imgVariety1" data-browse="上传">规格1：香辣味</label>
                                </div>

                                <div class="img-variety-preview" style="width: 250px; height: 250px;">
                                    展示照片
                                </div>
                            </div>

                            <!-- TO-DO: REWORK THIS PART -->

                        </div><br>

                        <input class="btn btn-primary btn-block" type="submit" value="添加" name="submit">

                    </form>
                </div>

                <!-- Navigation guideline -->
                <div class="col-sm-0 col-md-2">
                    <div style="position: fixed;">
                        <ul class="list-group">
                            <a href="#step-one" class="item-create-step-info list-group-item list-group-item-action active">基本资讯</a>
                            <a href="#step-two" class="item-create-step-info list-group-item list-group-item-action">销售资料</a>
                            <a href="#step-three" class="item-create-step-info list-group-item list-group-item-action">媒体管理</a>
                            <a href="#step-four" class="item-create-step-info list-group-item list-group-item-action">运输资料</a>
                        </ul>
                    </div>
                </div><!-- Navigation guideline -->

            </div><!-- Page content with row class -->

        </div>

        <script src="../assets/js/admin-item-management-page.js"></script>

    </body>
    </html>
