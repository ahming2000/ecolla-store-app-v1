<?php

class Cart{

    private $cartItems; //Array
    private $cartCount; //Int
    private $subtotal; //Float
    private $shippingFee; //Float

    public function __construct(){
        if(!isset($_COOKIE["cart"])) {
            $this->cartItems = array();
            $this->cartCount = 0;
            $this->subtotal = 0.0;
            $this->shippingFee = 0.0;

            $this->updateCookie();
        } else{
            $cart = json_decode($_COOKIE['cart']);

            $this->cartItems = $cart->cartItems;
            $this->cartCount = $cart->cartCount;
            $this->subtotal = $cart->subtotal;
            $this->shippingFee = $cart->shippingFee;
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
        for($this->cartItems as $cartItem){
            if($cartItem->getVarieties()[$cartItem->getVarietyIndex()]->getBarcode() === $barcode){
                UsefulFunction::removeArrayElementE($this->cartItems, $cartItem);
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
            if($cartItem->getVarieties()[$cartItem->getVarietyIndex()]->getBarcode() === $barcode){
                $cartItem->setQuantity($cartItem->getQuantity() + $scale);
                $this->updateSubtotal();
                $this->updateCookie();
                return true;
            }
        }
        return false; //If error or fail to edit quantity
    }

    public function resetCart(){
        setcookie("cart", "", time() - 3600);
        for($i = 0; $i < sizeof($this->cartItems); $i++){
            unset($this->cartItems[$i]);
        }
        $this->cartCount = 0;
        $this->subtotal = 0.0;
        $this->shippingFee = 0.0;
        $this->updateCookie();
    }

    //Private useful function for cart
    private function updateSubtotal(){
        $total = 0;
        foreach ($this->cartItems as $cartItem) {
            $total += $cartItem->getSubPrice();
        }
        $this->subtotal = $total + $shippingFee;
    }

    private function updateCookie(){
        $cart = array("cartItems" => $this->cartItems, "cartCount" => $this->cartCount, "subtotal" => $this->subtotal, "shippingFee" => $this->shippingFee);
        setcookie("cart", json_encode($cart), time() + (86400 * 30), "/"); //Active 30 days
    }

    private function isDuplicated(){

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
