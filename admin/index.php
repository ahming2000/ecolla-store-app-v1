<?php
/* Authorization */
if (isset($_COOKIE["username"])) {
    // $message =  "<h3>登陆成功！</h3>" . "<br>" . "<a href=\"logout.php\">点击登出</a>";
    $message =  "<a href=\"logout.php\">点击登出</a>";
} else {
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
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script>
        $(function() {
            let t_date = new Date(<?php echo strtotime($t_date) ?> * 1000);
            $("#date_").val(t_date.toLocaleDateString('en-CA'));
            $("#date_").change(e => {
                $("#form_report_date").submit();
            });

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
                if(empty($report_order)){
                    echo "console.log('Unfortunately, there is no report to generate as there are no sales made in this period.');";
                    echo "$('#pie_chart_table').remove();";
                } else {
                    echo "$('#no_sales').remove();";
                }
            ?>
        });
    </script>
</head>

<body>

    <?php include "../assets/includes/script.inc.php"; ?>

    <header><?php include "../assets/block-admin-page/header.php"; ?></header>

    <br /><br /><br />

    <!--Daily report -->
    <div class="container">
        <div class="bg-secondary h1 text-center" style="color: white;">Daily Sales report</div>
        <hr style="height:2.5px;border:none;color:#333;background-color:#333;" />

        <form method="POST" action="../admin/index.php" id="form_report_date">
            <div class="row text-center h4">
                <div class="col-4">Date: <input type="date" name="report_date" id="date_" max="<?php echo date('Y-m-d') ?>" />
                </div>
                <div class="col-4">Total Sales Revenue: RM <?php echo $total_price; ?></div>
                <div class="col-4">Total number of items sold: <?php echo $total_sold; ?></div>
            </div>
        </form>
    </div>

    <div class="container" id="pie_chart_table">
        <div class="bg-success h1 text-center" style="color: white;">Pie Chart</div>
        <div id="pie_chart" style="height: 400px; width: 100%;"></div>

        <table class="table text-center border border-dark mt-2">
            <thead>
                <tr class="bg-danger" style="color: white;">
                    <th></th>
                    <th>Name</th>
                    <th>Variety</th>
                    <th>Barcode</th>
                    <th>Count</th>
                    <th>Price Per Item</th>
                    <th>Total Price</th>
                    <th>Time Purchased</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tmp = 0;
                foreach ($report_order as $o) {
                    echo "<tr class='table-danger'>" .
                        "<td colspan='8'>" . $o->getOrderId() . "</td>" .
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
        <div class="h2 text-center">Unfortunately, there are no sales transaction for today...</div>
    </div>

    <div class="container">
        <div class="bg-primary h1 text-center" style="color: white;">Weekly Sales report</div>
        <div id="line_chart" style="height: 400px; width: 100%;"></div>
    </div>

    <div class="container">
        <br>
        <?php
        if (isset($message)) {
            echo $message;
        }

        ?>
    </div>
</body>

</html>