<h5 class="card-title">Order Summary</h5>

<ul class="list-group list-group-flush">
    <li
        class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
        Subtotal
        <span>RM <?php echo number_format($c->getSubtotal(), 2); ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
        Shipping Fee
        <span>RM <?php echo number_format($c->getShippingFee(), 2); ?></span>
    </li>
    <li
        class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
        <strong>Total</strong>
        <span><strong>RM <?php $total = $c->getSubtotal() + $c->getShippingFee(); echo number_format($total, 2); ?></strong></span>
    </li>
</ul>
