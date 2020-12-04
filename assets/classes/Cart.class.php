<?php

require_once __DIR__."\\UsefulFunction.class.php";

class Cart{

    private $cartItems; //Array
    private $cartCount; //Int
    private $subtotal; //Float
    private $shippingFee; //Float

    public function __construct(){
        session_start();
        if(isset($_SESSION["cart"])){
            $this->cartItems = $_SESSION["cart"]->cartItems;
            $this->cartCount = $_SESSION["cart"]->cartCount;
            $this->subtotal = $_SESSION["cart"]->subtotal;
            $this->shippingFee = $_SESSION["cart"]->shippingFee;
        } else{
            $this->initial();
        }
    }

    //Cart function
    public function addItem($cartItem){
        array_push($this->cartItems, $cartItem);
        $this->cartCount++;

        $this->updateSubtotal();
        $this->updateCookie();
    }

    public function removeItem($barcode){
        foreach($this->cartItems as $cartItem){
            if($cartItem->getBarcode() === $barcode){
                $this->cartItems = UsefulFunction::removeArrayElementE($this->cartItems, $cartItem);
                $this->cartCount--;
                $this->updateSubtotal();
                $this->updateCookie();
                return true;
            }
        }
        return false; //If fail to remove item
    }

    public function editQuantity($barcode, $scale){
        foreach ($this->cartItems as $cartItem) {
            if($cartItem->getBarcode() === $barcode){
                $cartItem->setQuantity($cartItem->getQuantity() + $scale);
                $this->updateSubtotal();
                $this->updateCookie();
                return true;
            }
        }
        return false; //If error or fail to edit quantity
    }

    public function resetCart(){
        session_destroy();
        unset($this->cartItems);
        $this->initial();
    }

    //Private useful function for cart
    private function updateSubtotal(){
        $total = 0;
        foreach ($this->cartItems as $cartItem) {
            $total += $cartItem->getSubPrice();
        }
        $this->subtotal = $total;
    }

    private function initial(){
        $this->cartItems = array();
        $this->cartCount = 0;
        $this->subtotal = 0.0;
        $this->shippingFee = 0.0;
        $this->updateCookie();
    }

    private function updateCookie(){
        $_SESSION["cart"] = $this;
        // $_SESSION["cart"] = array("cartItems" => UsefulFunction::jsonSerializeArray($this->cartItems), "cartCount" => $this->cartCount, "subtotal" => $this->subtotal, "shippingFee" => $this->shippingFee);
        // setcookie("cart", json_encode($_SESSION["cart"]), time() + (86400 * 30), "/"); //Active 30 days (wrong)
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
            if($cartItem->getBarcode() === $barcode){
                return $cartItem;
            }
            return NULL;
        }
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

}

?>
