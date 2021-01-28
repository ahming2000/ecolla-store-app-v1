<tr>

    <td>
        <?= $order->getDateTime(); ?><br>
        <?= $order->getOrderId(); ?><br>
        订单状态：<?= $order->getOrderStatus(); ?><br>
        <button type='button' class='btn btn-sm btn-primary' value='<?= "../assets/images/orders/".$order->getOrderId().".jpg"; ?>' onclick='viewReceipt(this)'>查看账单</button>
    </td>

    <td>
        <form action="" method="post">
            <input type="text" name="orderId" value="<?= $order->getOrderId(); ?>" hidden/>
            <input type="text" class="form-control form-control-sm mb-0" name="deliveryId" value="<?= $order->getDeliveryId(); ?>" placeholder="输入运输ID..." <?= ($order->getOrderStatus() == "待处理" or $order->getOrderStatus() == "已出货") ? "" : "disabled"; ?>/><br>
            <button type="submit" class="btn btn-sm btn-primary mt-0" name="updateDeliveryId" <?= ($order->getOrderStatus() == "待处理" or $order->getOrderStatus() == "已出货") ? "" : "disabled"; ?>>更新</button>
        </form>
    </td>

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
        if(!empty($cartItem->getItem()->getWholesales()) and $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getDiscountRate() == 1.0){
            echo "价钱：RM".number_format($cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getPrice() * $cartItem->getItem()->getWholesalesDiscountRate($cartItem->getQuantity()), 2, '.', '');
        } else{
            echo "价钱：RM".number_format($cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getPrice() * $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getDiscountRate(), 2, '.', '');
        }
        echo " x ".$cartItem->getQuantity()."<br>";
        $count++;
    }
    ?></td>

    <td>
        <?= "付款：RM" . number_format($order->getCart()->getSubtotal(), 2, '.', ''); ?><br>
        <?= "运费：RM" . number_format($order->getCart()->getShippingFee(), 2, '.', ''); ?>
    </td>

    <td>
        <form action="" method="post">
            <input type="text" name="orderId" value="<?= $order->getOrderId(); ?>" hidden/>
            <button type="submit" class="btn btn-outline-secondary p-2 m-1" style="width: 70px;" name="refund">退款</button><br>
            <button type="submit" class="btn btn-outline-secondary p-2 m-1" style="width: 70px;" name="unbuy">反结账</button><br>
            <!-- <button type="submit" class="btn btn-outline-secondary p-2 m-1" name="adjustOrder">调整订单</button><br> -->
        </form>
    </td>
</tr>
