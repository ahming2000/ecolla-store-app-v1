<tr>

    <td>
        <?= $order->getOrderId(); ?><br>
        <button type='button' class='btn btn-sm btn-primary' value='<?= "../assets/images/orders/".$order->getOrderId().".jpg"; ?>' onclick='viewReceipt(this)'>查看账单</button>
    </td>

    <td>
        <form action="" method="post">
            <input type="text" name="orderId" value="<?= $order->getOrderId(); ?>" hidden/>
            <input type="text" class="form-control-sm" name="deliveryId" value="<?= $order->getDeliveryId(); ?>" alt="输入运输ID..."/><br>
            <button type="submit" class="btn btn-sm btn-primary" name="updateDeliveryId">更新</button>
        </form>
    </td>

    <td><?= $order->getDateTime(); ?></td>

    <td>
        名字：<?= $order->getCustomer()->getName(); ?><br>
        联系：<?= $order->getCustomer()->getPhoneMMC() . $order->getCustomer()->getPhone(); ?><br>
        地址：<?= $order->getCustomer()->getAddress() . ", " . $order->getCustomer()->getPostalCode() . " " . $order->getCustomer()->getArea() . ", " . $order->getCustomer()->getState(); ?><br>
    </td>

    <td><?php
    $count = 1;
    foreach($order->getCart()->getCartItems() as $cartItem){
        echo "商品 ".$count."：".$cartItem->getItem()->getName()." ";
        echo $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getProperty()."<br>";
        echo "价钱：RM".number_format($cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getPrice() * $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getDiscountRate(), 2);
        echo " x ".$cartItem->getQuantity()."<br>";
        $count++;
    }
    ?></td>

    <td><?php echo "RM".number_format($order->getCart()->getSubtotal() + $order->getCart()->getShippingFee(), 2)." (包含 RM".number_format($order->getCart()->getShippingFee(), 2)." 的运输费）"; ?></td>

    <td></td>
</tr>
