<tr>

    <td><?php echo $order["o_date_time"]; ?></td>

    <td><?php
    echo "名字：".$order["customer"]["c_name"]."<br>";
    echo "联系：".$order["customer"]["c_phone"]."<br>";
    echo "地址：".$order["customer"]["c_address"].", ".$order["customer"]["c_postcode"]." ".$order["customer"]["c_city"].", ".$order["customer"]["c_state"]."<br>";
     ?></td>

    <td><?php
    $count = 1;
    foreach($order["cartItems"] as $cartItem){
        echo "商品 ".$count."：".$cartItem["i_country"].$cartItem["i_brand"].$cartItem["i_name"]." ".$cartItem["v_property"]."<br>";
        echo "价钱：RM".number_format($cartItem["v_price"] * $cartItem["v_discountRate"], 2)." x ".$cartItem["quantity"]."<br>";
        $count++;
    }

    ?></td>

    <td><?php echo $order["o_item_count"] ?></td>
    <td><?php echo "RM".$order["o_subtotal"] ?></td>
</tr>
