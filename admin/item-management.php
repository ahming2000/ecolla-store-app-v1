<?php
/* Authorization */
if(!isset($_COOKIE["username"])) header("location: login.php");

/* Initialization */
// Standard variable declaration
$upperDirectoryCount = 1;
$title = "商品管理";
$mode = "admin";

// Auto loader for classes
include "../assets/includes/class-auto-loader.inc.php";

// Database Interaction
$view = new View();
$controller = new Controller();

//Get item information
$itemList = $view->getAllItems();

/* Operation */

if(isset($_POST["deleteButton"])){
    $item = $view->getItem($_POST["name"], $_POST["brand"]);
    if(!$controller->deleteItem($item)){
        UsefulFunction::generateAlert("删除失败");
    } else{
        UsefulFunction::generateAlert("删除成功");
        header("refresh: 0"); //Refresh page immediately
    }
}

if(isset($_POST['list'])){
    $controller = new Controller();
    $controller->changeListStatus($_POST['name'], $_POST['brand']);
    header("refresh: 0");
}

if(isset($_POST['edit'])){
    header("location: item-edit.php?itemName=" . $_POST['name'] . "&itemBrand=" . $_POST['brand']);
}

?>

<!DOCTYPE html>
<html>

<head><?php include "../assets/includes/stylesheet.inc.php"; ?></head>

<body>

    <?php include "../assets/includes/script.inc.php"; ?>

    <header><?php include "../assets/block-admin-page/header.php"; ?></header>

    <div style="margin-top: 100px;"></div>

    <div class="container">
        <div class="h1">商品管理</div>
        <form action="" method="post" id="action-form">
            <div class="row">
                <input type="text" name="name" id="selectedName" value="" hidden/>
                <input type="text" name="brand" id="selectedBrand" value="" hidden/>
                <div class="col mb-3"><button onclick="addButtonClicked()" type="button" class="btn btn-primary btn-block" name="addButton" id="addButton">添加商品</button></div>
                <div class="col mb-3"><button onclick="editButtonClicked()" type="button" class="btn btn-primary btn-block" name="editButton" id="editButton" disabled>编辑商品</button></div>
                <div class="col mb-3"><button onclick="deleteButtonClicked()" type="submit" class="btn btn-primary btn-block" name="deleteButton" id="deleteButton" disabled>删除商品</button></div>
            </div>
        </form>



        <table class="table table-bordered" id="item-table">
            <thead>
                <tr>
                    <th scope="col"><input type="checkbox" onclick="selectAll(this)"></th>
                    <th scope="col">名称</th>
                    <th scope="col">规格</th>
                    <th scope="col">货号</th>
                    <th scope="col">价格</th>
                    <th scope="col">数量</th>
                    <th scope="col">销售</th>
                    <th scope="col">操作</th>
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
                // Must use [0] to get first class selected
                document.getElementById("selectedName").value = source.parentNode.getElementsByClassName("infoBoxItemName")[0].value;
                document.getElementById("selectedBrand").value = source.parentNode.getElementsByClassName("infoBoxItemBrand")[0].value;
            } else{
                selectedRowIndex = null;
                document.getElementById("selectedName").value = "";
                document.getElementById("selectedBrand").value = "";
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
                document.getElementById("selectedName").value = "";
                document.getElementById("selectedBrand").value = "";
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
            "itemName=" + document.getElementById("selectedName").value + "&" +
            "itemBrand=" + document.getElementById("selectedBrand").value;
        }

        function deleteButtonClicked(){
            untickAll();
        }

        </script>

    </div>
</body>

</html>
