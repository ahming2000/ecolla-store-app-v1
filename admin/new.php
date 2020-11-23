<?php $upperDirectoryCount = 1; include "../assets/includes/class-auto-loader.inc.php"; //Auto include all the classes. ?>
<?php
    if(isset($_POST["submit"])){
        $varietyCount = 1;

        $item = new Item($_POST["name"], $_POST["brand"], $_POST["country"], $_POST["isListed"]);
        for($i = 0; $i < $varietyCount; $i++){
            //$item->addVariety(new Variety);
        }

        $newPHPFile = fopen("../items/".str_replace(" ", "-", $item->getName()).".php", "w") or die("Error on creating new php file!");
        $template = fopen("../items/item-page-template.txt", "r") or die("Error on opening the item php file template!");

        while(!feof($template)){
            $str = fgets($template);

            if($str === "<!--Name-->"){
                fwrite($newPHPFile, strval($item->getName()));
            }

            if(UsefulFunction::startsWith($str, "<!--")){
                //Implement dynamic information
                if(UsefulFunction::startsWith($str, "<!--Catogory-->")){
                    fwrite($newPHPFile, strtolower($item->getCatogory()));
                }
                else if(UsefulFunction::startsWith($str, "<!--Name-->")){
                    fwrite($newPHPFile, $item->getName());
                }
                else if(UsefulFunction::startsWith($str, "<!--ImgPath-->")){
                    for($i = 0; $i < sizeof($item->getImgPath()); $i++){
                        fwrite($newPHPFile, $item->getImgPath[$i]);
                    }
                }
            } else{
                fwrite($newPHPFile, $str); //Read from template
            }
        }
        fclose($template);
        fclose($newPHPFile);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php $upperDirectoryCount = 1; $title = "创建新商品"; include "../assets/includes/stylesheet-script-declaration.inc.php" ?>
    </head>

    <body>
        <div class="container">
        <div class="h1">创建新商品</div>

            <form action="" method="post">
                <div class="form-row">
                    <div class="col">
                        <label for="country">出产国家</label>
                        <input type="text" class="form-control" name="country" aria-describedby="country" required>
                    </div>
                    <div class="col">
                        <label for="brand">商品品牌</label>
                        <input type="text" class="form-control" name="brand" aria-describedby="brand" required>
                    </div>

                    <div class="col">
                        <label for="name">商品名称</label>
                        <input type="text" class="form-control" name="name" aria-describedby="name" required>
                    </div>


                </div><br>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="isListed" value="" id="listing">
                    <label class="form-check-label" for="listing">
                        上架
                    </label>
                </div><br>

                <div class="form-row" id="catogory">

                    <div class="col-12"><label>商品类别/标签</label></div>
                    <div class="col-sm-12 col-md-6 col-lg-4">

                        <select class="custom-select mb-3">
                            <option selected>打开选单选择类别/标签...</option>
                            <option value="饮料">饮料</option>
                            <option value="小零食">小零食</option>
                        </select>
                    </div>

                </div>

                <button type="button" class="btn btn-secondary mb-3" id="extraCatogory">添加更多类别/标签</button>

                <div class="form-row" id="variety">
                    <div class="col-12"><label for="name">商品规格</label></div>

                    <div class="col-12">

                        <!-- Upload images for specific variety -->

                        <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="row mb-3">
                            <div class="col"><label for="barcode">商品 Barcode</label></div>
                            <div class="col"><input type="text" class="form-control" name="barcode1" aria-describedby="barcode" required></div>
                        </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="row mb-3">
                            <div class="col"><label for="variety">规格</label></div>
                            <div class="col"><input type="text" class="form-control" name="variety1" aria-describedby="variety" required></div>
                        </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="row mb-3">
                            <div class="col"><label for="varietyName">规格名称</label></div>
                            <div class="col"><input type="text" class="form-control" name="varietyName1" aria-describedby="varietyName" required></div>
                        </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="row mb-3">
                            <div class="col"><label for="price">价钱</label></div>
                            <div class="col"><input type="text" class="form-control" name="price1" aria-describedby="price" required></div>
                        </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="row mb-3">
                            <div class="col"><label for="weight">重量/容量</label></div>
                            <div class="col"><input type="text" class="form-control" name="weight1" aria-describedby="weight" required></div>
                        </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="row mb-3">
                            <div class="col"><label for="weightUnit">重量/容量单位</label></div>
                            <div class="col"><input type="text" class="form-control" name="weightUnit1" aria-describedby="weightUnit" required></div>
                        </div>
                        </div>


                    </div>

                </div>

                <button type="button" class="btn btn-secondary mb-3" id="extraVariety">添加更多规格</button>


                <input class="btn btn-primary btn-block" type="submit" value="添加" name="submit">

            </form>
        </div>

        <script>
            $(document).ready(function(){

                var extraCatogoryHTML = "<div class=\"col-sm-12 col-md-6 col-lg-4\"><select class=\"custom-select mb-3\"><option selected>打开选单选择类别/标签...</option><option value=\"饮料\">饮料</option><option value=\"小零食\">小零食</option></select></div>";

                var extraVarietyHTML = "<div class=\"col-6\"><div class=\"col-12 mb-3\"><label for=\"barcode\">商品 Barcode</label><input type=\"text\" class=\"form-control\" name=\"barcode\" aria-describedby=\"barcode\" required></div><div class=\"col-12 mb-3\"><label for=\"variety\">规格</label><input type=\"text\" class=\"form-control\" name=\"variety\" aria-describedby=\"variety\" required></div><div class=\"col-12 mb-3\"><label for=\"varietyName\">规格名称</label><input type=\"text\" class=\"form-control\" name=\"varietyName\" aria-describedby=\"varietyName\" required></div><div class=\"col-12 mb-3\"><label for=\"price\">价钱</label><input type=\"text\" class=\"form-control\" name=\"price\" aria-describedby=\"price\" required></div><div class=\"col-12 mb-3\"><label for=\"weight\">重量/容量</label><input type=\"text\" class=\"form-control\" name=\"weight\" aria-describedby=\"weight\" required></div><div class=\"col-12 mb-3\"><label for=\"weightUnit\">重量/容量单位</label><input type=\"text\" class=\"form-control\" name=\"weightUnit\" aria-describedby=\"weightUnit\" required></div></div>";


                $("#extraCatogory").on("click", function(){
                    $("#catogory").append(extraCatogoryHTML);
                });

                $("#extraVariety").on("click", function(){
                    $("#variety").append(extraVarietyHTML);
                });
            });
        </script>

    </body>
</html>
