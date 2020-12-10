<tr>

    <td>
        <?= $order->getOrderId(); ?><br>
        <button type='button' class='btn btn-sm btn-primary' value='<?= "../assets/images/orders/".$order->getOrderId().".jpg"; ?>' onclick='viewReceipt(this)'>查看账单</button>
    </td>

    <td><?php echo $order->getDateTime(); ?></td>

    <td><?php
    echo "名字：".$order->getCustomer()->getName()."<br>";
    echo "联系：".$order->getCustomer()->getPhoneMMC().$order->getCustomer()->getPhone()."<br>";
    echo "地址：".$order->getCustomer()->getAddress()."<br>";
     ?></td>

    <td><?php
    $count = 1;
    foreach($order->getCart()->getCartItems() as $cartItem){
        echo "商品 ".$count."：".$cartItem->getItem()->getOrigin().$cartItem->getItem()->getBrand().$cartItem->getItem()->getName()." ";
        echo $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getProperty()."<br>";
        echo "价钱：RM".number_format($cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getPrice() * $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getDiscountRate(), 2);
        echo " x ".$cartItem->getQuantity()."<br>";
        $count++;
    }

    ?></td>

    <td><?php echo $order->getCart()->getCartCount() ?></td>
    <td><?php echo "RM".number_format($order->getCart()->getSubtotal(), 2)." (包含 RM".number_format($order->getCart()->getShippingFee(), 2)." 的运输费）"; ?></td>
</tr>
