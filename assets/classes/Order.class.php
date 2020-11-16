<?php

class Order {

    private $customer; //array("name"=>, "phone"=>, "address"=>, "postcode"=>, "city"=>, "state"=>, "receiptPath"=>, )

    public function __construct($customer){
        $this->customer = $customer;
    }

    public function createOrder($cart){
        $controller = new Controller();
        $controller->createNewOrder($cart, $this->customer);
    }

    public function getOrderHistory(){

    }

    public function deleteOrderHistory(){

    }

    public function refundOrder(){

    }

    public function revertOrder(){

    }

}

?>
