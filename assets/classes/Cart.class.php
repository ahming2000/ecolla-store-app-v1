<?php

require_once __DIR__."\\UsefulFunction.class.php";

class Cart{

    private $cartItems; //Array
    private $cartCount; //Int
    private $subtotal; //Float
    private $shippingFee; //Float
    private $isEastMY; // Flag

    public function __construct(){
        session_start();

        if(isset($_SESSION["cart"])){
            // Resume last cart value
            $this->cartItems = $_SESSION["cart"]->cartItems;
            $this->cartCount = $_SESSION["cart"]->cartCount;
            $this->subtotal = $_SESSION["cart"]->subtotal;
            $this->shippingFee = $_SESSION["cart"]->shippingFee;
            $this->isEastMY = $_SESSION["cart"]->isEastMY;
        } else{
            // Initial cart if no value present in $_SESSION
            $this->initial();
        }
    }

    //Cart function
    public function addItem($cartItem){
        array_push($this->cartItems, $cartItem);
        $this->cartCount++;

        $this->updateValue();
        $this->updateCart();
    }

    public function removeItem($barcode){
        foreach($this->cartItems as $cartItem){
            if($cartItem->getBarcode() === $barcode){
                $this->cartItems = UsefulFunction::removeArrayElementE($this->cartItems, $cartItem);
                $this->cartCount--;
                $this->updateValue();
                $this->updateCart();
                return true;
            }
        }
        return false; //If fail to remove item
    }

    public function editQuantity($barcode, $scale){
        foreach ($this->cartItems as $cartItem) {
            if($cartItem->getBarcode() === $barcode){
                $cartItem->setQuantity($cartItem->getQuantity() + $scale);
                $this->updateValue();
                $this->updateCart();
                return true;
            }
        }
        return false; //If error or fail to edit quantity
    }

    public function setEastMY($isEastMY){
        $this->isEastMY = $isEastMY;
        $this->updateValue();
        $this->updateCart();
    }

    public function resetCart(){
        session_destroy();
        unset($this->cartItems);
        $this->initial();
    }

    //Private useful function for cart
    private function initial(){
        $this->cartItems = array();
        $this->cartCount = 0;
        $this->subtotal = 0.0;
        $this->shippingFee = 0.0;
        $this->isEastMY = 0;
        $this->updateCart();
    }

    private function updateValue(){
        $subtotal = 0;
        $totalWeight = 0;
        foreach ($this->cartItems as $cartItem) {
            $subtotal += $cartItem->getSubPrice();
            $totalWeight += $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getWeight() * $cartItem->getQuantity();
        }

        // Update subtotal
        $this->subtotal = $subtotal;

        // Update shipping fee
        $view = new View();
        $this->shippingFee = ceil($totalWeight) * $view->getShippingFeeRate($this->isEastMY);
    }

    private function updateCart(){
        $_SESSION["cart"] = $this;
    }

    //To-do: check duplicate item
    public function isDuplicated($cartItem){
        foreach($this->cartItems as $c){
            if($c->getBarcode() === $cartItem->getBarcode()){
                return True;
            }
        }
    }

    //Xi En added this
    // Just remove it if you feel its unnecessary
    public function getSpecificCartItem($barcode){
        foreach($this->cartItems as $cartItem){
            if($cartItem->getBarcode() == $barcode){
                return $cartItem;
            }
        }
        return NULL;
    }

    //Getter
    public function getCartItems(){
        return $this->cartItems;
    }

    public function getCartCount(){
        return $this->cartCount;
    }

    public function getSubtotal(){
        return $this->subtotal;
    }

    public function getShippingFee(){
        return $this->shippingFee;
    }

    public function isEastMY(){
        return $this->isEastMY;
    }

}

?>
