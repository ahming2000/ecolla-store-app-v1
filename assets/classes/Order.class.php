<?php

class Order {

    private $customer; // Customer object

    private $dateTime;
    private $orderId; // Unique format
    private $cart;

    private $deliveryId; // Key in after admin sent out the parcel

    public function __construct($customer){
        $this->customer = $customer;
    }

    public function orderNow($cart){
        $this->dateTime = date("Y-m-d H:i:s");
        $this->orderId = "ECOLLA".date_format(date_create($this->dateTime), "YmdHis");
        $this->cart = $cart;
    }

    public function importOrder($dateTime, $orderId, $cart, $deliveryId){
        $this->dateTime = $dateTime;
        $this->orderId = $orderId;
        $this->cart = $cart;
        $this->deliveryId = $deliveryId;
    }

    public function deleteOrderHistory(){

    }

    public function refundOrder(){

    }

    public function revertOrder(){

    }

    public function getDateTime() {
        return $this->dateTime;
    }

    public function getOrderId() {
        return $this->orderId;
    }

    public function getCustomer() {
        return $this->customer;
    }

    public function getCart() {
        return $this->cart;
    }

    public function getDeliveryId() {
        return $this->deliveryId;
    }
}

?>
