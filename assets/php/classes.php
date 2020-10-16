<?php

    class Item {
        private $name;
        private $barcode;
        private $price;
        private $weight;
        private $properties;
        private $imgPaths;
        private $catogory;

        function __contruct(){
            $arguments = func_get_args();
            $numberOfArguments = func_num_args();

            if (method_exists($this, $function = '__construct'.$numberOfArguments)) {
                call_user_func_array(array($this, $function), $arguments);
            }
        }

        function __contruct1($name, $barcode, $price, $weight, $properties, $imgPaths, $catogory){
            $this->$name = $name;
            $this->$barcode = $barcode;
            $this->$price = $price;
            $this->$weight = $weight;
            $this->$properties = $properties;
            $this->$imgPaths = $imgPaths;
            $this->$catogory = $catogory;
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

        function getCatogory(){
            return $this->$catogory;
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

        function setCatogory($catogory){
            $this->$catogory = $catogory;
        }

    }

    class CartItem extends Item{
        
        private $quantity;
        private $note;
        private $subPrice;

        function __contruct2($name, $price, $barcode, $weight, $properties, $imgPaths, $catogory, $quantity, $note, $subPrice){
            $this->$name = $name;
            $this->$barcode = $barcode;
            $this->$price = $price;
            $this->$weight = $weight;
            $this->$properties = $properties;
            $this->$imgPaths = $imgPaths;
            $this->$catogory = $catogory;
            $this->$quantity = $quantity;
            $this->$note = $note;
            $this->$subPrice = $subPrice;
        }

        function __contruct3($item, $quantity, $note, $subPrice){
            $this->$name = $item->$name;
            $this->$barcode = $item->$barcode;
            $this->$price = $item->$price;
            $this->$weight = $item->$weight;
            $this->$properties = $item->$properties;
            $this->$imgPaths = $item->$imgPaths;
            $this->$catogory = $item->$catogory;
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
                $total += $cartItem->$subPrice;
            }
            return $total + $shippingFee;
        }

        function addCartItem($cartItem){
            array_push($this->$cartItems, $cartItem);
        }

        function removeCartItem($barcode){
            for($i = 0; i < sizeof($this->$cartItems); $i++){
                if($this->$cartItems[$i]->$barcode == $barcode){
                    $this->$cartItems = array_diff($this->$cartItems, $cartItems[$i]);
                    array_splice($this->$cartItems, $i, length($this->cartItems), array_slice($this->$cartItems, $i + 1, length($this->cartItems)));
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

    //$cart = new Cart(); //Only declare once

 ?>