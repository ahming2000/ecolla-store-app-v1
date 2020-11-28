<?php

class Order {

    private $dateTime;
    private $orderId; // Unique format
    private $customer; // Customer object
    private $deliveryId; // Key in after admin sent out the parcel

    public function __construct($customer){
        $this->customer = $customer;
    }

    public function createOrder($cart){
        $this->dateTime = date("Y-m-d H:i:s");
        $this->orderId = $this->generateOrderId();
        $controller = new Controller();
        $controller->createNewOrder($this->dateTime, $this->orderId, $this->customer, $cart);
    }

    private function generateOrderId(){
        $dt = date_create($this->dateTime);
        return "ECOLLA".date_format($dt, "YmdHis");
    }

    public function getOrderHistory(){
        $view = new View();
        // Get specific order history from this function
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

    public function setDateTime($dateTime) {
        $this->dateTime = $dateTime;
        return $this;
    }

    public function getOrderId() {
        return $this->orderId;
    }

    public function setOrderId($orderId) {
        $this->orderId = $orderId;
        return $this;
    }

    public function getCustomer() {
        return $this->customer;
    }

    public function setCustomer($customer) {
        $this->customer = $customer;
        return $this;
    }
}

?>
