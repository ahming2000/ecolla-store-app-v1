<?php
/* Authorization */
if (!isset($_COOKIE["username"])) header("location: login.php");

/* Initialization */
// Standard variable declaration
$upperDirectoryCount = 1;
$title = "订单管理";
$mode = "admin";

// Auto loader for classes
include "../assets/includes/class-auto-loader.inc.php";

// Database Interaction
$view = new View();
$controller = new Controller();

//Get order information
// Calculate value for pagination
$MAX_ITEMS = $view->getMaxManageContent();
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$page = is_numeric($page) ? $page : 0 ; // Avoid non number value in url
$start = ($page - 1) * $MAX_ITEMS;

//Get item information
$date = isset($_GET['date']) ? $_GET['date'] : "";
$ids = $view->orderManagementFilter($date);
$itemCount = sizeof($ids);
$totalPage = ceil($itemCount / $MAX_ITEMS);

$orderList = array();
for($i = $start; $i < $start + $MAX_ITEMS; $i++){
    if(isset($ids[$i])){
        $orderList[] = $view->getOrder($ids[$i]);
    }
}

/* Operation */
if (isset($_POST["updateDeliveryId"])) {
    $controller->updateDeliveryId($_POST["orderId"], $_POST["deliveryId"]);
    UsefulFunction::generateAlert("已更新订单 " . $_POST["orderId"] . " 的运输ID为 " . $_POST["deliveryId"]);
    header("refresh: 0"); //Refresh page immediately
}

if (isset($_POST["refundDestroy"])) {
    if ($controller->orderRefund($_POST["orderId"])) {
        UsefulFunction::generateAlert("订单已成功退款并报销！");
    } else {
        UsefulFunction::generateAlert("订单必须要是待处理状态！");
    }
    header("refresh: 0"); //Refresh page immediately
}

if (isset($_POST["refundOnly"])) {
    if ($controller->orderUnbuy($_POST["orderId"])) {
        UsefulFunction::generateAlert("订单已成功退款！");
    } else {
        UsefulFunction::generateAlert("订单必须要是待处理状态！");
    }
    header("refresh: 0"); //Refresh page immediately
}

if (isset($_POST["adjustOrder"])) {
}

?>

<!DOCTYPE html>
<html>

<head>
    <?php include "../assets/includes/stylesheet.inc.php"; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

    <!--Load Table functions from admin_table.js-->
    <script src="../assets/js/admin_table.js"></script>

    <script>
        function hide_col_phone(table_col) {
            // To hide 运送ID column
            hide_col_full('运送ID', table_col);

            // To hide 顾客资料 column
            hide_col_full('顾客资料', table_col);

            // To hide 订单物品 column
            hide_col_full('订单物品', table_col);

            // To hide 销售额 column
            hide_col_full('销售额', table_col);
        }

        function hide_col_ipad(table_col) {
            // To hide 运送ID column
            hide_col_full('运送ID', table_col);

            // To hide 订单物品 column
            hide_col_full('订单物品', table_col);

            // To hide 销售额 column
            hide_col_full('销售额', table_col);
        }

        $(function() {
            let table_col = get_table_col();
            generate_detail_html(table_col);

            if ($(window).width() <= 600) {
                //For phone
                hide_col_phone(table_col);
            } else if ($(window).width() > 600 && $(window).width() < 900) {
                //For Ipad default width and phone side-view
                hide_col_ipad(table_col);
            } else {
                //For Desktop
            }

            //check viewport (Idk how to do this in css)
            $(window).resize("on", e => {

                show_col_all(table_col);

                if ($(window).width() <= 600) {
                    //For phone
                    hide_col_phone(table_col);
                } else if ($(window).width() > 600 && $(window).width() < 900) {
                    //For Ipad default width and phone side-view
                    hide_col_ipad(table_col);
                } else {
                    //For Desktop
                }
            });

            //Show details
            let detail_flag = false;
            $("#detail_btn").on("click", e => {
                (detail_flag == true) ? $("#detail_board").css("display", "none"): $("#detail_board").css("display", "block");
                detail_flag = !detail_flag;
            });

            //Show or hide table columns
            $("#detail_board input:checkbox").change(function() {
                let tble = table_col[$(this).attr('name')],
                    ind = tble.ind;
                (tble.flag == true) ? hide_col(ind): show_col(ind);
                tble.flag = !tble.flag;
            });
        });
    </script>
</head>

<body>

    <?php include "../assets/includes/script.inc.php"; ?>

    <header><?php include "../assets/block-admin-page/header.php"; ?></header>

    <main class="container">

        <div class="h1">订单查看</div>

        <div class="row mb-3">
            <div class="col-6">
                <form action="" method="get">

                    <div class="form-row">
                        <div class="col-10">
                            <!-- Item searching -->
                            <input type="date" class="form-control" maxlength="20" name="date" value="<?= isset($_GET["date"]) ? $_GET["date"] : ""; ?>" />
                        </div>
                        <div class="col-2">
                            <input type="submit" class="btn btn-primary p-2 mt-0" value="搜索"/>
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-6">
                <nav>
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?= $page == 1 ? "disabled" : ""; ?>">
                            <a class="page-link" id="previous-page-button" <?= $page == 1 ? "tabindex='1' aria-disabled='true'" : ""; ?>>上一页</a>
                        </li>

                        <?php for($i = 1; $i <= $totalPage; $i++) : ?>
                            <li class="page-item <?= $page == $i ? "active" : ""; ?>" value="<?= $i; ?>"><a class="page-link page-number-link"><?= $i; ?></a></li>
                        <?php endfor; ?>

                        <li class="page-item<?= $page == $totalPage ? " disabled" : ""; ?>">
                            <a class="page-link" id="next-page-button" <?= $page == $totalPage ? "tabindex='1' aria-disabled='true'" : ""; ?>>下一页</a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>

        <!--Details-->
        <div class="d-flex justify-content-end mt-2">
            <div style="position: relative;">
                <button id="detail_btn" class="btn-sm btn-primary">&#9660; 详情</button>
                <div id="detail_board" style="height: 240px; width: 150px; background-color: white; display: none;position: absolute; z-index: 2; right: 0px;">
                </div>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table class="table table-bordered mt-2">
                <thead>
                    <tr>
                        <th scope="col">订单详情</th>
                        <th scope="col">运送ID</th>
                        <th scope="col">顾客资料</th>
                        <th scope="col">订单物品</th>
                        <th scope="col">销售额</th>
                        <th scope="col">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($orderList as $order) {
                        include "../assets/block-admin-page/manage-order-block.php";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </main>

    <script>
        function viewReceipt(source) {
            let url = source.value;
            window.open(url, 'Image', 'width=400px,height=400px,resizable=1');
        }

        $(document).ready(function(){

            $("#previous-page-button").on("click", function(){
                window.location.href = "order-management.php?<?= isset($_GET["date"]) ? "date=" . $_GET["date"] . "&" : ""; ?>page=<?= ($page - 1) ?>";
            });

            $("#next-page-button").on("click", function(){
                window.location.href = "order-management.php?<?= isset($_GET["date"]) ? "date=" . $_GET["date"] . "&" : ""; ?>page=<?= ($page + 1) ?>";
            });

            $(".page-number-link").on("click", function(e){
                window.location.href = "order-management.php?<?= isset($_GET["date"]) ? "date=" . $_GET["date"] . "&" : ""; ?>page=" + $(this).parent().val();
            });
        });
    </script>
</body>

</html>
