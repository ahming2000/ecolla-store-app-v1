<?php

    class Item {
        private $name;
        private $barcode;
        private $price;
        private $weight;
        private $properties;
        private $imgPaths;

        function __contruct($name, $barcode, $price, $weight, $properties, $imgPaths){
            $this->$name = $name;
            $this->$barcode = $barcode;
            $this->$price = $price;
            $this->$weight = $weight;
            $this->$properties = $properties;
            $this->$imgPaths = $imgPaths;
        }

        function getName(){
            return $this->$name;
        }

        function getBarcode(){
            return $this->$barcode;
        }

        function getPrice(){
            return $this->$price;
        }

        function getWeight(){
            return $this->$weight;
        }

        function getProperties(){
            return $this->$properties;
        }

        function getImgPath(){
            return $this->$imgPaths;
        }

        function setName($name){
            $this->$name = $name;
        }

        function setBarcode($barcode){
            $this->$barcode = $barcode;
        }

        function setPrice($price){
            $this->$price = $price;
        }

        function setWeight($weight){
            $this->$weight = $weight;
        }

        function setProperties($properties){
            $this->$properties = $properties;
        }

        function setImgPath($imgPaths){
            $this->$imgPaths = $imgPaths;
        }

    }

    class CartItem extends Item{
        
        private $quantity;
        private $note;
        private $subPrice;

        function __contruct($name, $price, $barcode, $weight, $properties, $imgPaths, $quantity, $note, $subPrice){
            $this->$name = $name;
            $this->$barcode = $barcode;
            $this->$price = $price;
            $this->$weight = $weight;
            $this->$properties = $properties;
            $this->$imgPaths = $imgPaths;
            $this->$quantity = $quantity;
            $this->$note = $note;
            $this->$subPrice = $subPrice;
        }

        function __contruct($cart, $quantity, $note, $subPrice){
            $this->$name = $cart->$name;
            $this->$barcode = $cart->$barcode;
            $this->$price = $cart->$price;
            $this->$weight = $cart->$weight;
            $this->$properties = $cart->$properties;
            $this->$imgPaths = $cart->$imgPaths;
            $this->$quantity = $quantity;
            $this->$note = $note;
            $this->$subPrice = $subPrice;
        }

        function getQuantity(){
            return $this->$quantity;
        }

        function getNote(){
            return $this->$note;
        }

        function getSubPrice(){
            return $this->$subPrice;
        }

        function setQuantity($quantity){
            $this->$quantity = $quantity;
        }

        function setNote($note){
            $this->$note = $note;
        }

        function setSubPrice($subPrice){
            $this->$subPrice = $subPrice;
        }

    }

    class Cart{
        private $cartItems;
        private $cartCount;
        private $subtotal;
        private $shippingFee;

        function __contruct(){
            $cartItems = array();
        }

        function calculateSubtotal(){
            $total = 0;
            foreach ($this->$cartItems as $CartItem) {
                total += $cartItem->$subPrice;
            }
            return $total + $shippingFee;
        }

        function addCartItem($cartItem){
            array_push($this->$cartItems, $cartItem);
        }

        function removeCartItem($barcode){
            foreach($this->$cartItems as $cartItem){
                if($cartItem->$barcode == $barcode){
                    unset($cartItems[$cartItem]);
                }
            }
        }

        function getCartItems(){
            return $this->$cartItems;
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

        function setCartItem($cartItem){
            
        }

        function setCartCount($cartCount){
            $this->$cartCount = $cartCount;
        }

    }

 ?>