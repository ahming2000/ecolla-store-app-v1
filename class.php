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

        function __contruct($cartCount){
            $cartItems = array();
            $this->$cartCount = $cartCount;
            if($cartCount != 0){
                //To-do: Get Cart item from database and save it into object
                calculateSubtotal();
            }else{
                $cartCount = 0;
            }
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
                    //Need to do experiment on unset item from array to confirm
                    //The arranging function is needed for the array or not
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

        function setCartItems($cartItems){
            $this->$cartItems = $cartItems;
        }

        function setCartCount($cartCount){
            $this->$cartCount = $cartCount;
        }

        function setSubTotal($subtotal){
            $this->$subtotal = $subtotal;
        }

        function setShippingFee($shippingFee){
            $this->$shippingFee = $shippingFee;
        }

    }

    static $cart = new Cart(); //Only declare once

 ?>