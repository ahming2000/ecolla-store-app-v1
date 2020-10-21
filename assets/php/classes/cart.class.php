<?php

class Cart{
    private $cartItems;
    private $cartCount;
    private $subtotal;
    private $shippingFee;

    function __construct(){
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

    function calculateSubtotal(){
        $total = 0;
        foreach ($this->$cartItems as $CartItem) {
            $total += $cartItem->subPrice;
        }
        return $total + $shippingFee;
    }

    function addCartItem($cartItem){
        array_push($this->cartItems, $cartItem);
        $this->cartCount++;
    }

    function removeCartItem($barcode){
        for($i = 0; i < sizeof($this->$cartItems); $i++){
            if($this->cartItems[$i]->barcode == $barcode){
                UsefulFunction::removeArrayElementE($this->cartItems, $this->cartItems[$i]);
                $this->cartCount--;
                return true;
            }
        }
        return false; //If fail to remove item
    }

    function clearCart(){
        for($i = 0; $i < sizeof($this->cartItems); $i++){
            unset($this->cartItems[$i]);
        }
    }

    function getCartItems(){
        return $this->cartItems;
    }

    function getCartCount(){
        return $this->cartCount;
    }

    function getSubtotal(){
        return $this->subtotal;
    }

    function getShippingFee(){
        return $this->shippingFee;
    }

    function setCartItems($cartItems){
        $this->cartItems = $cartItems;
    }

    function setCartCount($cartCount){
        $this->cartCount = $cartCount;
    }

    function setSubTotal($subtotal){
        $this->subtotal = $subtotal;
    }

    function setShippingFee($shippingFee){
        $this->shippingFee = $shippingFee;
    }

}

?>