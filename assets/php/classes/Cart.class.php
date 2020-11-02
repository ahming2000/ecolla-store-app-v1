<?php

class Cart{
    
    private $cartItems; //Array
    private $cartCount; //Int
    private $subtotal; //Float
    private $shippingFee; //Float

    public function __construct(){
        $cartItems = $this->getCartItems();
        $cartCount = $this->getCartCount();
        $subtotal = $this->getSubtotal();
        $shippingFee = $this->getShippingFee();
    }

    public function addItemToCart($cartItem){
        array_push($this->cartItems, $cartItem);
        $this->cartCount++;
    }

    public function removeItemFromCart($barcode){
        for($i = 0; i < sizeof($this->$cartItems); $i++){
            if($this->cartItems[$i]->barcode == $barcode){
                UsefulFunction::removeArrayElementE($this->cartItems, $this->cartItems[$i]);
                $this->cartCount--;
                return true;
            }
        }
        return false; //If fail to remove item
    }

    public function modifyItemFromCart($orgCartItem, $newCartItem){

    }

    public function deleteAllData(){
        setcookie("cartCount", "", time() - 3600);
        setcookie("cart", "", time() - 3600);
    }

    public function clearCart(){
        for($i = 0; $i < sizeof($this->cartItems); $i++){
            unset($this->cartItems[$i]);
        }
    }

    public function calculateSubtotal(){

    }

    public function getCartItems(){
        return $this->cartItems;
    }

    public function getCartCount(){
        if(!isset($_COOKIE["cartCount"])) {
            return 0;
        }
        else{
            return $_COOKIE["cartCount"];
        }
    }

    public function getSubtotal(){
        $total = 0;
        foreach ($this->$cartItems as $CartItem) {
            $total += $cartItem->subPrice;
        }
        return $total + $shippingFee;
    }

    public function getShippingFee(){
        return $this->shippingFee;
    }

    private function setCartItems($cartItems){
        $this->cartItems = $cartItems;
    }

    private function setCartCount($cartCount){
        $this->cartCount = $cartCount;
        setcookie("cartCount", $cartCount, time() + (86400 * 30), "/");
    }

    private function setSubTotal($subtotal){
        $this->subtotal = $subtotal;
    }

    private function setShippingFee($shippingFee){
        $this->shippingFee = $shippingFee;
    }
}

?>
