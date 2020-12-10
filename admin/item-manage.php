<?php $upperDirectoryCount = 1; include "../assets/includes/class-auto-loader.inc.php"; //Auto include all the classes. ?>
<?php if(!isset($_COOKIE["username"])) header("location: login.php"); $view = new View(); $controller = new Controller(); $itemList = $view->getAllItems(); ?>
    <?php
        if(isset($_POST["deleteButton"])){
            $item = $view->getItem($_POST["name"], $_POST["brand"]);
            if(!$controller->deleteItem($item)){
                UsefulFunction::generateAlert("删除失败");
            } else{
                UsefulFunction::generateAlert("删除成功");
            }
        }

     ?>
<!DOCTYPE html>
<html>

<head><?php $upperDirectoryCount = 1; $title = "商品管理"; include "../assets/includes/stylesheet-script-declaration.inc.php" ?></head>

<body>
    <?php $upperDirectoryCount = 1; include "../assets/block-admin-page/header.php"; ?>

    <div style="margin-top: 100px;"></div>

    <div class="container">
        <div class="h1">商品管理</div>
        <form action="" method="post">
            <div class="row">
                <input type="text" name="name" id="name" value="" hidden/>
                <input type="text" name="brand" id="brand" value="" hidden/>
                <div class="col mb-3"><button onclick="addButtonClicked()" type="button" class="btn btn-primary btn-block" name="addButton" id="addButton">添加商品</button></div>
                <div class="col mb-3"><button onclick="editButtonClicked()" type="button" class="btn btn-primary btn-block" name="editButton" id="editButton" disabled>编辑商品</button></div>
                <div class="col mb-3"><button onclick="deleteButtonClicked()" type="submit" class="btn btn-primary btn-block" name="deleteButton" id="deleteButton" disabled>删除商品</button></div>
            </div>
        </form>



        <table class="table table-bordered" id="item-table">
            <thead>
                <tr>
                    <th scope="col"><input type="checkbox" onclick="selectAll(this)"> 全选</th>
                    <th scope="col">出产国家</th>
                    <th scope="col">品牌</th>
                    <th scope="col">名称</th>
                    <th scope="col">规格名称</th>
                    <th scope="col">Barcode</th>
                    <th scope="col">价格</th>
                    <th scope="col">商品总数量</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($itemList as $item){
                    include "../assets/block-admin-page/manage-item-block.php";
                }
                 ?>
            </tbody>
        </table>

        <script>

        var selectedCount = 0;
        var selectedRowIndex = null;

        function itemCheckBoxClicked(source){

            if(source.checked){
                selectedCount++;
            } else{
                selectedCount--;
            }

            //Check to disable the edit button (Website cannot support multiple item editing)
            if(selectedCount != 1){
                document.getElementById("editButton").setAttribute("disabled", "disabled");
                document.getElementById("deleteButton").setAttribute("disabled", "disabled");
            } else{
                document.getElementById("editButton").removeAttribute("disabled");
                document.getElementById("deleteButton").removeAttribute("disabled");
            }

            //set the row selected
            if(selectedCount == 1){
                //Loop throught the class
                for(var i = 0; i < document.getElementsByClassName('item-check-box').length; i++){
                    if(document.getElementsByClassName('item-check-box')[i].checked){
                        selectedRowIndex = i + 1;
                    }
                }
                var myTable = document.getElementById("item-table");
                document.getElementById("name").value = myTable.rows.item(selectedRowIndex).cells.item(3).innerHTML;
                document.getElementById("brand").value = myTable.rows.item(selectedRowIndex).cells.item(2).innerHTML;
            } else{
                selectedRowIndex = null;
            }

        }

        function selectAll(source) {
            checkboxes = document.getElementsByName('item-check-box');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }

            if(source.checked){
                selectedCount = document.getElementsByClassName('item-check-box').length;
                document.getElementById("editButton").setAttribute("disabled", "disabled");
                document.getElementById("deleteButton").setAttribute("disabled", "disabled");
            } else{
                selectedCount = 0;
                document.getElementById("editButton").setAttribute("disabled", "disabled");
                document.getElementById("deleteButton").setAttribute("disabled", "disabled");
            }
        }


            var myTable = document.getElementById("item-table");

            function untickAll(){
                //Untick all selection
                for(var i = 0; i < document.getElementsByClassName('item-check-box').length; i++){
                    if(document.getElementsByClassName('item-check-box')[i].checked){
                        document.getElementsByClassName('item-check-box')[i].checked = false;
                    }
                }
            }

            function addButtonClicked(){
                untickAll();
                document.location.href = "item-create.php";
            }

            function editButtonClicked(){
                untickAll();
                document.location.href = "item-edit.php?" +
                "itemName=" + myTable.rows.item(selectedRowIndex).cells.item(3).innerHTML + "&" +
                "itemBrand=" + myTable.rows.item(selectedRowIndex).cells.item(2).innerHTML;
            }

            function deleteButtonClicked(){
                untickAll();
            }

        </script>

    </div>
</body>

</html>
