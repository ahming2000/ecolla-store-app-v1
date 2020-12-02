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
        $view = new View();
        // Get specific order history from this function
    }

    public function deleteOrderHistory(){

    }

    public function refundOrder(){

    }

    public function revertOrder(){

    }

}

?>
