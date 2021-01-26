<?php

class Order {

    private $customer; // Customer object

    private $dateTime;
    private $orderId; // Unique format
    private $cart;
    private $paymentMethod;

    private $deliveryId; // Key in after admin sent out the parcel
    private $orderStatus;

    public function __construct($customer){
        $this->customer = $customer;
    }

    public function orderNow($cart, $paymentMethod){
        $this->dateTime = date("Y-m-d H:i:s");
        $view = new View();
        $prefix = $view->getOrderIdPrefix();
        $this->orderId = $prefix . date_format(date_create($this->dateTime), "YmdHis");
        $this->cart = $cart;
        $this->paymentMethod = $paymentMethod;
    }

    public function importOrder($dateTime, $orderId, $cart, $paymentMethod, $deliveryId, $orderStatus){
        $this->dateTime = $dateTime;
        $this->orderId = $orderId;
        $this->cart = $cart;
        $this->paymentMethod = $paymentMethod;
        $this->deliveryId = $deliveryId;
        $this->orderStatus = $orderStatus;
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

    public function getPaymentMethod() {
        return $this->paymentMethod;
    }

    public function getOrderStatus(){
        return $this->orderStatus;
    }

}

?>
