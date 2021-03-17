<div class="container border border-secondary">
    <div id="order_item_list">
        <?php


        for ($i = 0; $i < sizeof($cartList); $i++) {
            $cartItem = $cartList[$i];
            $totalWeight = $cartItem->getQuantity() * $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getWeight();
            $subPrice = $cartItem->getSubPrice();

            echo "<div class=\"row\">
                <div class=\"cl1\"><img class='receipt-image' src=\"assets/images/items/" . $view->getItemId($cartItem->getItem()) . "/0.jpg\"></div>
                <div class=\"cl2 text-center \"><b class='item_txt1'>" . $cartItem->getItem()->getName() . "</b></div>
                <div class=\"cl2 text-center \"><b class='item_txt1'>" . $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getProperty() . "</b></div>

                <div class='cl3'></div>
                <div class='cl3'></div>

                <div class='cl3 text-center'><b class='item_txt2'>" . $cartItem->getQuantity() . "</b></div>
                <div class='cl3 text-center'><b class='item_txt2'>*</b></div>
                <div class='cl4 text-center'><b class='item_txt2'>RM" . $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getPrice() . " =</b></div>
                <div class=\"cl4 text-right\"><b class='item_txt2'>RM<span id=\"t_price\">" . number_format($cartItem->getSubPrice(), 2, '.', '') . "</span></b></div>
                </div>";

            //backup
            // echo "<div class=\"row\" style=\"height: 100px\">
            // <div class=\"col-1 p-1\"><img src=\"assets/images/items/" . $view->getItemId($cartItem->getItem()) . "/0.png\" style=\"height: 90px; width: auto;\"></div>
            //     <div class=\"col-3 pt-3\"><b style=\"font-size: 26px;\">" . $cartItem->getItem()->getBrand() . " " . $cartItem->getItem()->getName() . "</b></div>
            //     <div class=\"col-1 pt-4\"><b style=\"font-size: 15px;\">" . $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getProperty() . "</b></div>
            //     <div class=\"col-1 pt-4\"><b style=\"font-size: 20px;\">" . $totalWeight . "kg</b></div>

            //     <div class=\"col-1 pt-3\"></div>

            //     <div class=\"col-3 pt-3\"><b style=\"font-size: 32px; float: right;\">" . $cartItem->getQuantity() . " * RM" . $subPrice . " = </b></div>
            //     <div class=\"col-2 pt-3\"><b style=\"font-size: 32px;float: right;\">RM<span id=\"t_price\">" . number_format($cartItem->getSubPrice(), 2, '.', '') . "</span></b></div>
            // </div>";
        }
        ?>
    </div>
    <div class="row">
        <div style="width: 55%"></div>
        <div class="cl11 text-center"><b class='item_txt3'>Subtotal</b></div>
        <div class="cl12 text-center"><b class='item_txt3' style="float: right;">RM<span id="t_price"><?php echo number_format($cart->getSubtotal(), 2, '.', '')  ?></span></b></div>
    </div>
    <div class="row">
        <div style="width: 55%"></div>
        <div class="cl11 text-center"><b class='item_txt3'>Shipping Fee </b></div>
        <div class="cl12 text-center"><b class='item_txt3' style="float: right;">RM<span id="t_price"><?php echo number_format($cart->getShippingFee(), 2, '.', '')  ?></span></b></div>
    </div>
    <div class="row" style="width:auto;height:5px;background-color: black;"></div>
    <div class="row">
        <div style="width: 55%"></div>
        <div class="cl11 text-center"><b class='item_txt3'>Total </b></div>
        <div class="cl12 text-center"><b class='item_txt3' style="float: right;">RM<span id="t_price"><?php $total = $cart->getSubtotal() + $cart->getShippingFee();
                                                                                                        echo number_format($total, 2, '.', ''); ?></span></b></div>
    </div>
</div>
