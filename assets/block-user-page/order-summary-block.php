<h5 class="card-title">购物车订单摘要</h5>

<ul class="list-group list-group-flush">
    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
        小计
        <span>RM <?php echo number_format($c->getSubtotal(), 2); ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
        邮费
        <span>RM <?php echo number_format($c->getShippingFee(), 2); ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
        <strong>总计</strong>
        <span><strong>RM <?php $total = $c->getSubtotal() + $c->getShippingFee();
                            echo number_format($total, 2); ?></strong></span>
    </li>
</ul>

<script>
    $(function() {
        let price = parseFloat(<?php $total = $c->getSubtotal() + $c->getShippingFee(); echo number_format($total, 2); ?>)
        if(price <= 0)
            $("#submit_btn").attr("disabled", "disabled");
    });
</script>