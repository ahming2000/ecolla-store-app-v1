<?php

class Cart{
    private $cartItems;
    private $cartCount;
    private $subtotal;
    private $shippingFee;

    public function __construct(){
        $cartItems = array();
        $subtotal = 0;
        $shippingFee = 0;

        if($cartCount != 0){
            //To-do: Get Cart item from database and save it into object
            //calculateSubtotal();
        }else{
            $cartCount = 0;
        }
    }

    public function calculateSubtotal(){
        $total = 0;
        foreach ($this->$cartItems as $CartItem) {
            $total += $cartItem->subPrice;
        }
        return $total + $shippingFee;
    }

    public function addCartItem($cartItem){
        array_push($this->cartItems, $cartItem);
        $this->cartCount++;
    }

    public function removeCartItem($barcode){
        for($i = 0; i < sizeof($this->$cartItems); $i++){
            if($this->cartItems[$i]->barcode == $barcode){
                UsefulFunction::removeArrayElementE($this->cartItems, $this->cartItems[$i]);
                $this->cartCount--;
                return true;
            }
        }
        return false; //If fail to remove item
    }

    public function clearCart(){
        for($i = 0; $i < sizeof($this->cartItems); $i++){
            unset($this->cartItems[$i]);
        }
    }

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

    public function setCartItems($cartItems){
        $this->cartItems = $cartItems;
    }

    public function setCartCount($cartCount){
        $this->cartCount = $cartCount;
    }

    public function setSubTotal($subtotal){
        $this->subtotal = $subtotal;
    }

    public function setShippingFee($shippingFee){
        $this->shippingFee = $shippingFee;
    }
}

?>