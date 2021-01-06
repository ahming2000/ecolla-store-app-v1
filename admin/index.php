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

// Auto loader for classes
include "../assets/includes/class-auto-loader.inc.php";

// Database Interaction
$view = new View();

//Get item information
$orderList = $view->getAllOrders();

/* Operation */
function updateReportOrder()
{
    foreach ($GLOBALS['orderList'] as $order) {
        if (strtotime(explode(" ", $order->getDateTime())[0]) == strtotime($GLOBALS['t_date'])) {
            array_push($GLOBALS['report_order'], $order);
        }
    }
}

function updateCartItemList()
{
    foreach ($GLOBALS['report_order'] as $o) {
        $tmp_no_clone_cart = $o->getCart()->getCartItems();
        $tmp_cart = array();

        foreach ($tmp_no_clone_cart as $cartItem) {
            array_push($tmp_cart, clone $cartItem);
        }

        if (empty($GLOBALS['cartItems'])) {
            $GLOBALS['cartItems'] = $tmp_cart;
        } else {
            foreach ($tmp_cart as $c) {
                if (duplicateCartItems($c)) {
                    for ($i = 0; $i < count($GLOBALS['cartItems']); $i++) {
                        if ($GLOBALS['cartItems'][$i]->getBarcode() === $c->getBarcode()) {
                            $ori_num = $GLOBALS['cartItems'][$i]->getQuantity();
                            $GLOBALS['cartItems'][$i]->setQuantity($ori_num + $c->getQuantity());
                        }
                    }
                } else {
                    array_push($GLOBALS['cartItems'], $c);
                }
            }
        }
    }
}

function duplicateCartItems($c)
{
    foreach ($GLOBALS['cartItems'] as $cartItem) {
        if ($cartItem->getBarcode() === $c->getBarcode()) {
            return True;
        }
    }
    return False;
}

//colors
$red = array("#FFA07A", "#FA8072", "#CD5C5C", "#DC143C", "#FF0000");
$yellow = array("#FFFACD", "#FFD700", "#FFFF00");
$blue = array("#00BFFF",  "#1E90FF", "#0000FF",  "#0000CD", "#000080");
$green = array("#ADFF2F", "#7CFC00", "#00FF00",  "#00FA9A", "#228B22");
$orange = array("#FFA500", "#FF8C00",  "#FF7F50", "#FF6347", "#FF4500");
$purple = array("#FF00FF", "#EE82EE", "#DA70D6", "#9400D3", "#8B008B");

// $color = array(
//     array("#FFA07A", "#FA8072", "#CD5C5C", "#DC143C", "#FF0000"),
//     array("#00BFFF",  "#1E90FF", "#0000FF",  "#0000CD", "#000080"),
//     array("#ADFF2F", "#7CFC00", "#00FF00",  "#00FA9A", "#228B22"),
//     array("#FFA500", "#FF8C00",  "#FF7F50", "#FF6347", "#FF4500"),
//     array("#FF00FF", "#EE82EE", "#DA70D6", "#9400D3", "#8B008B")
// );

$color = array();

for ($i = 0; $i < 3; $i++) {
    array_push($color, $red[$i], $yellow[$i], $blue[$i], $green[$i], $orange[$i], $purple[$i]);
}

for ($i = 3; $i < 5; $i++) {
    array_push($color, $red[$i], $blue[$i], $green[$i], $orange[$i], $purple[$i]);
}

//update cart items from order
updateReportOrder();
updateCartItemList();

foreach ($cartItems as $cartItem) {
    $total_price += $cartItem->getSubPrice();
    $total_sold += $cartItem->getQuantity();
}

if (isset($_POST["report_date"])) {
    $cartItems = array();
    $report_order = array();
    $total_sold = 0;
    $total_price = 0;
    $t_date = $_POST["report_date"];
    updateReportOrder();
    updateCartItemList();
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

        /*Primary colors: Red, Orange, Yellow, Green, Blue, Purple, Indigo*/
        /*Red: #FFA07A, #FA8072, #CD5C5C, #DC143C, #FF0000 */
        /*Orange: #FFA500, #FF8C00,  #FF7F50, #FF6347, #FF4500 */
        /*Yellow: #FFFACD, #FFD700, #FFFF00 */
        /*Green:  #ADFF2F, #7CFC00, #00FF00,  #00FA9A, #228B22  */
        /*Blue: #00BFFF,  #1E90FF, #0000FF,  #0000CD, #000080 */
        /*Indigo: */
        /*Purple:  #FF00FF, #EE82EE, #DA70D6, #9400D3, #8B008B */
        .piechart {
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background-image: conic-gradient(<?php
                                                $cur_deg = 0;
                                                $str = "";
                                                for ($i = 0; $i < count($cartItems); $i++) {
                                                    $str .= $color[$i] . " " . $cur_deg . "deg ";
                                                    $cur_deg += $cartItems[$i]->getQuantity() / $total_sold * 360;
                                                    $str .= $cur_deg . "deg,";
                                                }

                                                echo substr($str, '0', '-1');

                                                ?>);
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script>
        $(function() {
            let t_date = new Date(<?php echo strtotime($t_date) ?> * 1000);
            $("#date_").val(t_date.toLocaleDateString('en-CA'));
            $("#date_").change(e => {
                $("#form_report_date").submit();
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
        <div class="text-center h1">Today Sales report</div>
        <!--Add a function where you can sort by monthly daily or annual sales report -->
        <hr style="height:2.5px;border:none;color:#333;background-color:#333;" />

        <form method="POST" action="../admin/index.php" id="form_report_date">
            <div class="row text-center h4">
                <div class="col-4">Date: <input type="date" name="report_date" id="date_" max="<?php echo date('Y-m-d') ?>" />
                </div>
                <div class="col-4">Total Sales Revenue: RM <?php echo $total_price; ?></div>
                <div class="col-4">Total number of items sold: <?php echo $total_sold; ?></div>
            </div>
        </form>

        <div class="row">
            <div class="col-8 p-3">
                <div class="border border-success" style="height: 475px;">
                    <div class="bg-success h2 text-center" style="color: white;">Pie Chart</div>
                    <div class="d-flex justify-content-center align-items-center pt-1">
                        <div class="piechart"></div>
                    </div>
                </div>
            </div>
            <div class="col-4 p-3">
                <div class="border border-success" style="height: 475px;">
                    <!--Legend for pie chart-->
                    <div class="px-3 text-center">

                        <div class="row bg-success">
                            <div class="col">
                                <div class="h3" style="color: white;">Legend</div>
                            </div>
                        </div>

                        <div class="row table-success">
                            <div class="col-2">CCode</div>
                            <div class="col-4">Name</div>
                            <div class="col-3">Variety</div>
                            <div class="col-2">Count</div>
                        </div>
                        <?php
                            for ($i = 0; $i < count($cartItems); $i++) {
                                $str = "<div class='row'>"; 
                                $color_str = "<div class='col-2'>
                                    <div style='width: 30px; height: 30px; background-color: " . $color[$i] . "'></div>
                                </div>";
                                $name_str = "<div class='col-4'>" . $cartItems[$i]->getItem()->getName() . "</div>";
                                $variety_str = "<div class='col-3'>" . $cartItems[$i]->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getProperty() . "</div>";
                                $count_str = "<div class='col-2'>" . $cartItems[$i]->getQuantity() . "</div>";
                                $str .= $color_str . $name_str . $variety_str . $count_str . "</div>";
                                echo $str;
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <table class="table text-center border border-dark">
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

    <div class="container">
        <br>
        <?php
        if (isset($message)) {
            echo $message;
        }

        ?>
    </div>
</body>

<!--<div> <?php
            // $str = "<tr>";
            // for ($i = 0; $i < count($cartItems); $i++) {
            //     if ($i % $limit == 0 && $i != 0) {
            //         $str .= "</tr><tr>";
            //     }
            //     $str .= "<td style='font-size: 20px;background-color: " . $color[$i] . "'>" . $cartItems[$i]->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getProperty() . "</td>";
            // }
            // echo substr($str, '0', '-5');
            ?></div> -->

</html>