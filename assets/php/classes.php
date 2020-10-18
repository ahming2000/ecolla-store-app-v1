<?php

    class Various{
        private $properties; //string //Flavour or type
        private $price; //double //In Malaysia Riggit
        private $weight; //double
        private $weightUnit; //string //Gram or others
        private $barcode; //int

        function getProperties(){
            return $this->$properties;
        }

        function getPrice(){
            return $this->$price;
        }

        function getWeight(){
            return $this->$weight;
        }

        function getWeightUnit(){
            return $this->$weightUnit;
        }

        function getBarcode(){
            return $this->$barcode;
        }

        function setProperties($properties){
            $this->$properties = $properties;
        }

        function setPrice($price){
            $this->$price = $price;
        }

        function setWeight($weight){
            $this->$weight = $weight;
        }

        function setWeightUnit($weightUnit){
            $this->$weightUnit = $weightUnit;
        }

        function setBarcode($barcode){
            $this->$barcode = $barcode;
        }

    }

    class Item {
        private $name; //String
        private $catogory; //String
        private $imgPaths; //Array
        private $variousList; //Array

        function __contruct($name, $catogory, $imgPaths){
            $this->$name = $name;
            $this->$catogory = $catogory;
            $this->$imgPaths = $imgPaths;
            $this->$variousList = array();
        }

        function addVarious($various){
            $this->$variousList.push($various);
        }

        function removeVarious($index){
            UsefulFunction::removeArrayElementI($this->$various, $index);
        }

        function getName(){
            return $this->$name;
        }

        function getCatogory(){
            return $this->$catogory;
        }

        function getImgPath(){
            return $this->$imgPaths;
        }

        function setName($name){
            $this->$name = $name;
        }

        function setImgPath($imgPaths){
            $this->$imgPaths = $imgPaths;
        }

        function setCatogory($catogory){
            $this->$catogory = $catogory;
        }

    }

    class CartItem{
        
        final private $item;
        private $quantity;
        private $subPrice;
        private $variousIndex; //Only one various can be selected in this class
        private $note;

        function __contruct($item, $variousProperties, $quantity, $subPrice, $note){
            $this->$item = $item;
            $this->$variousIndex = getVariousIndex($variousProperties);
            if($variousIndex === 1000) die("Various Index has error!!!");
            $this->$quantity = $quantity;
            $this->$subPrice = $subPrice;
            $this->$note = $note;
        }

        private function getVariousIndex($properties){
            for($i = 0; $i < sizeof($item->$variousList); $i++){
                if($variousList[$i] === $item){
                    return $i;
                }
            }
            return 1000;
        }

        function getItem(){
            return $this->$item;
        }

        function getQuantity(){
            return $this->$quantity;
        }

        function getSubPrice(){
            return $this->$subPrice;
        }

        function getNote(){
            return $this->$note;
        }

        function setQuantity($quantity){
            $this->$quantity = $quantity;
        }

        function setSubPrice($subPrice){
            $this->$subPrice = $subPrice;
        }

        function setNote($note){
            $this->$note = $note;
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
            $this->$cartCount++;
        }

        function removeCartItem($barcode){
            for($i = 0; i < sizeof($this->$cartItems); $i++){
                if($this->$cartItems[$i]->$barcode == $barcode){
                    UsefulFunction::removeArrayElementE($this->$cartItems, $this->$cartItems[$i]);
                    $this->$cartCount--;
                    return true;
                }
            }
            return false; //If fail to remove item
        }

        function clearCart(){
            for($i = 0; $i < sizeof($this->$cartItems); $i++){
                unset($this->$cartItems[$i]);
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

    class UsefulFunction{
        public static function removeArrayElementE($array, $element){
            //Get the index of the element that require to remove
            for($i = 0; $i < sizeof($array); $i++){
                if(is_null($value)){
                    $index = $i;
                    break;
                }
            }
            //Delete the element from array (will left a null space)
            $array = array_diff($array, $element); 
            //Copy the array part after the null space to the end
            $arrayAfterElement = array_slice($array, $index + 1, length($array)); 
            //Replace the array element (from null space to the last element) with elements after null space
            array_splice($array, $index, length($array), $arrayAfterElement);
            return $array; //To do (Debug): if the array do not change by using array_splice(), need to address the result using return
        }

        public static function removeArrayElementI($array, $index){
            //Track back the array element
            $element = $array[$index];
            //Delete the element from array (will left a null space)
            $array = array_diff($array, $element); 
            //Copy the array part after the null space to the end
            $arrayAfterElement = array_slice($array, $index + 1, length($array)); 
            //Replace the array element (from null space to the last element) with elements after null space
            array_splice($array, $index, length($array), $arrayAfterElement);
            return $array; //To do (Debug): if the array do not change by using array_splice(), need to address the result using return
        }
    }

    //$cart = new Cart(); //Only declare once

 ?>