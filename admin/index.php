<?php
/* Authorization */
if (!isset($_COOKIE["username"])) {
    header("location: login.php");
}

/* Initialization */
// Standard variable declaration
$upperDirectoryCount = 1;
$mode = "admin";
$title = "管理员主页";

$t_date = date('Y-m-d');
$cartItems = array(); //This cart Item list is for pie chart only, (maybe graph too)
$report_order = array(); // array for orders transacted on specific day
$total_sold = 0;
$total_price = 0;

//For Line Chart
//To get this week item counts
$week_cart_quantity = array();
$week_dates = array();

// Auto loader for classes
include "../assets/includes/class-auto-loader.inc.php";

// Database Interaction
$view = new View();

//Get item information
$orderList = $view->getAllOrders();

/* Operation */
function updateReportOrder(&$report_arr, &$dates)
{
    foreach ($GLOBALS['orderList'] as $order) {
        if (strtotime(explode(" ", $order->getDateTime())[0]) == strtotime($dates)) {
            array_push($report_arr, $order);
        }
    }
}

function updateWeekCartNDates(&$week_cart_quantity, &$week_dates)
{
    $week_dates = array();
    for ($i = -3; $i < 4; $i++) {
        array_push($week_dates, date('Y-m-d', strtotime($GLOBALS['t_date'] . ' ' . $i . ' day')));
    }

    for ($i = 0; $i < 7; $i++) {
        //initialize temporary report and cartItem List
        $tmp_report = array();
        $tmp_cartItems = array();
        $tmp_total_sold = 0;

        updateReportOrder($tmp_report, $week_dates[$i]);

        if (empty($tmp_report)) {
            array_push($week_cart_quantity, $tmp_total_sold);
            continue;
        }

        updateCartItemList($tmp_report, $tmp_cartItems);

        foreach ($tmp_cartItems as $cartItem) {
            $tmp_total_sold += $cartItem->getQuantity();
        }

        array_push($week_cart_quantity, $tmp_total_sold);
    }
}

function updateCartItemList($report_arr, &$cartItem_list)
{
    foreach ($report_arr as $o) {
        $tmp_no_clone_cart = $o->getCart()->getCartItems();
        $tmp_cart = array();

        foreach ($tmp_no_clone_cart as $cartItem) {
            array_push($tmp_cart, clone $cartItem);
        }

        if (empty($cartItem_list)) {
            $cartItem_list = $tmp_cart;
        } else {
            foreach ($tmp_cart as $c) {
                if (duplicateCartItems($cartItem_list, $c)) {
                    for ($i = 0; $i < count($cartItem_list); $i++) {
                        if ($cartItem_list[$i]->getBarcode() === $c->getBarcode()) {
                            $ori_num = $cartItem_list[$i]->getQuantity();
                            $cartItem_list[$i]->setQuantity($ori_num + $c->getQuantity());
                        }
                    }
                } else {
                    array_push($cartItem_list, $c);
                }
            }
        }
    }
}

function duplicateCartItems($cartItem_list, $c)
{
    foreach ($cartItem_list as $cartItem) {
        if ($cartItem->getBarcode() === $c->getBarcode()) {
            return True;
        }
    }
    return False;
}

//update cart items from order
updateReportOrder($report_order, $t_date);
updateCartItemList($report_order, $cartItems);

foreach ($cartItems as $cartItem) {
    $total_price += $cartItem->getSubPrice();
    $total_sold += $cartItem->getQuantity();
}

//Generate This Week Total Quantity
updateWeekCartNDates($week_cart_quantity, $week_dates);

if (isset($_POST["report_date"])) {
    $cartItems = array();
    $report_order = array();
    $week_cart_quantity = array();
    $week_dates = array();
    $total_sold = 0;
    $total_price = 0;
    $t_date = $_POST["report_date"];
    updateReportOrder($report_order, $t_date);
    updateCartItemList($report_order, $cartItems);
    updateWeekCartNDates($week_cart_quantity, $week_dates);
    foreach ($cartItems as $cartItem) {
        $total_price += $cartItem->getSubPrice();
        $total_sold += $cartItem->getQuantity();
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <?php include "../assets/includes/stylesheet.inc.php"; ?>

    <style>
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /*Displays total sales, total item and date in report */
        .report_info_txt {
            font-size: 12px;
        }

        /*Deafult for pie-chart and line-chart */
        #pie_chart,
        #line_chart {
            height: 200px;
        }

        /* For Phone-side View */
        @media only screen and (min-width: 600px) {
            .report_info_txt {
                font-size: 16px;
            }

            #pie_chart,
            #line_chart {
                height: 300px;
            }
        }

        /* For Ipad Default View */
        @media only screen and (min-width: 768px) {
            .report_info_txt {
                font-size: 16px;
            }
        }

        /* For Desktop Default View */
        @media only screen and (min-width: 1024px) {

            #pie_chart,
            #line_chart {
                height: 400px;
            }
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    <!--Load generate html function from admin_index_generate_html.js -->
    <script src="../assets/js/admin_index_generate_html.js"></script>

    <!--Load Table functions from admin_table.js-->
    <script src="../assets/js/admin_table.js"></script>

    <script>
        //convert php value to javascript
        const date_ = (new Date()).toLocaleDateString('en-CA');
        const price_ = <?php echo $total_price; ?>;
        const sold_ = <?php echo $total_sold; ?>;

        function update_date() {
            let t_date = new Date(<?php echo strtotime($t_date) ?> * 1000);
            $("#date_").val(t_date.toLocaleDateString('en-CA'));
            $("#date_").change(e => {
                $("#form_report_date").submit();
            });
        }

        //Table functions - show or hide table columns
        function increase_colspan() {
            let colspan = parseInt($('.orderId_td').attr('colspan'));
            $('.orderId_td').attr('colspan', colspan + 1);
        }

        function decrease_colspan() {
            let colspan = parseInt($('.orderId_td').attr('colspan'));
            $('.orderId_td').attr('colspan', colspan - 1);
        }

        function hide_col_phone(table_col) {
            // To hide barcode column
            hide_col_full('Barcode', table_col);
            decrease_colspan();

            // To hide price Per Item column
            hide_col_full('Price Per Item', table_col);
            decrease_colspan();

            // To hide time purchased column
            hide_col_full('Time Purchased', table_col);
            decrease_colspan();
        }

        function hide_col_ipad(table_col) {
            // To hide barcode column
            hide_col_full('Barcode', table_col);
            decrease_colspan();
        }

        $(function() {
            let table_col = get_table_col(1);
            generate_detail_html(table_col);

            if ($(window).width() <= 600) {
                //For phone
                $("#in_form").append(generate_report_info_phone(date_, price_, sold_));
                hide_col_phone(table_col);
                $("#weekly_title_cnt").append(generate_week_title_phone());
            } else if ($(window).width() > 600 && $(window).width() < 900) {
                //For Ipad default width and phone side-view
                $("#in_form").append(generate_report_info_ipad(date_, price_, sold_));
                hide_col_ipad(table_col);
                $("#weekly_title_cnt").append(generate_week_title_default());
            } else {
                //For Desktop
                $("#in_form").append(generate_report_info_desktop(date_, price_, sold_));
                $("#weekly_title_cnt").append(generate_week_title_default());
            }

            update_date();

            let line_chart = new CanvasJS.Chart("line_chart", {
                exportEnabled: true,
                animationEnabled: true,
                theme: "light2",
                axisX: {
                    interlacedColor: "#F0F8FF"
                },
                data: [{
                    type: "line",
                    indexLabelFontSize: 16,
                    dataPoints: [
                        <?php
                        $str = "";
                        for ($i = 0; $i < 7; $i++) {
                            $str .= "{ y: " . $week_cart_quantity[$i] . ", ";
                            $str .= "label: '" . $week_dates[$i] . "' },";
                        }
                        echo substr($str, '0', '-1');
                        ?>
                    ]
                }]
            });

            let pie_chart = new CanvasJS.Chart("pie_chart", {
                exportEnabled: true,
                animationEnabled: true,
                legend: {
                    cursor: "pointer"
                },
                data: [{
                    type: "pie",
                    showInLegend: true,
                    toolTipContent: "{name}: <strong>{y}%</strong>",
                    indexLabel: "{name} - {y}%",
                    dataPoints: [
                        <?php
                        $str = "";
                        for ($i = 0; $i < count($cartItems); $i++) {
                            $name_str = $cartItems[$i]->getItem()->getName() . ' ' .  $cartItems[$i]->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getProperty();
                            $percentage = $cartItems[$i]->getQuantity() / $total_sold * 100.00;
                            $str .= "{ y: " . $percentage . ", ";
                            $str .= "name: '" . $name_str . "' },";
                        }
                        echo substr($str, '0', '-1');
                        ?>
                    ]
                }]
            });

            pie_chart.render();
            line_chart.render();

            <?php
            if (empty($report_order)) {
                echo "$('#pie_chart_table').remove();";
            } else {
                echo "$('#no_sales').remove();";
            }
            ?>

            //check viewport (Idk how to do this in css)
            $(window).resize("on", e => {

                $("#in_form_").remove();
                $("#weekly_").remove();

                for(let tble in table_col){
                    if (!table_col[tble].flag){
                        increase_colspan();
                    }
                }
                show_col_all(table_col);

                if ($(window).width() <= 600) {
                    //For phone
                    $("#in_form").append(generate_report_info_phone(date_, price_, sold_));
                    hide_col_phone(table_col);
                    $("#weekly_title_cnt").append(generate_week_title_phone());
                } else if ($(window).width() > 600 && $(window).width() < 900) {
                    //For Ipad default width and phone side-view
                    $("#in_form").append(generate_report_info_ipad(date_, price_, sold_));
                    hide_col_ipad(table_col);
                    $("#weekly_title_cnt").append(generate_week_title_default());
                } else {
                    //For computers default width
                    $("#in_form").append(generate_report_info_desktop(date_, price_, sold_));
                    $("#weekly_title_cnt").append(generate_week_title_default());
                }
                update_date();
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

    <br /><br /><br />

    <!--Daily report -->
    <div class="container">
        <div class="bg-secondary h1 text-center" style="color: white;">每日销售报告</div>
        <hr style="height:2.5px;border:none;color:#333;background-color:#333;" />

        <form method="POST" action="../admin/index.php" id="form_report_date">
            <div id="in_form">
            </div>
        </form>
    </div>

    <div class="container mt-2" id="pie_chart_table">
        <div class="bg-success h1 text-center" style="color: white;">图表</div>

        <div id="pie_chart" style="width: 100%;"></div>

        <div class="d-flex justify-content-end mt-2">
            <div style="position: relative;">
                <button id="detail_btn" class="btn-sm btn-danger">&#9660; 详情</button>
                <div id="detail_board" style="height: 240px; width: 150px; background-color: white; display: none;position: absolute; z-index: 2; right: 0px;">
                </div>
            </div>
        </div>

        <table class="table text-center border border-dark mt-2" style="width: 100%;">
            <thead>
                <tr class="bg-danger" style="color: white;">
                    <th></th>
                    <th>商品名称</th>
                    <th>规格选择</th>
                    <th>规格货号</th>
                    <th>数量</th>
                    <th>单件商品价格</th>
                    <th>总价格</th>
                    <th>购买时间</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tmp = 0;
                foreach ($report_order as $o) {
                    echo "<tr class='table-danger'>" .
                        "<td colspan='8' class='orderId_td'>" . $o->getOrderId() . "</td>" .
                        "</tr>";

                    $tmp_cart = $o->getCart()->getCartItems();
                    foreach ($tmp_cart as $cartItem) {
                        echo
                        "<tr>" .
                            "<th scope='row'>" . ++$tmp . "</th>" .
                            "<td>" . $cartItem->getItem()->getName() . "</td>" .
                            "<td>" . $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getProperty()  . "</td>" .
                            "<td>" . $cartItem->getBarcode() . "</td>" .
                            "<td>" . $cartItem->getQuantity() . "</td>" .
                            "<td>" . "RM" . number_format($cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getPrice() * $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getDiscountRate(), 2) . "</td>" .
                            "<td>" . "RM" . number_format($cartItem->getSubPrice(), 2) . "</td>" .
                            "<td>" . explode(" ", $o->getDateTime())[1] . "</td>" .
                            "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="container" id="no_sales">
        <div class="h2 text-center">目前暂无任何销售...</div>
    </div>

    <div class="container mb-5">
        <div id="weekly_title_cnt"></div>
        <div id="line_chart" style="width: 100%;"></div>
    </div>

</body>

</html>
