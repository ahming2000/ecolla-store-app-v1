<?php

class CartItem{
        
    private $item;
    private $quantity;
    private $subPrice;
    private $variousIndex; //Only one various can be selected in this class
    private $note;

    function __construct($item, $variousProperties, $quantity, $subPrice, $note){
        $this->item = $item;
        $this->variousIndex = getVariousIndex($variousProperties);
        if($variousIndex === 1000) die("Various Index has error!!!");
        $this->quantity = $quantity;
        $this->subPrice = $subPrice;
        $this->note = $note;
    }

    private function getVariousIndex($properties){
        for($i = 0; $i < sizeof($item->variousList); $i++){
            if($variousList[$i] === $item){
                return $i;
            }
        }
        return 1000;
    }

    function getItem(){
        return $this->item;
    }

    function getQuantity(){
        return $this->quantity;
    }

    function getSubPrice(){
        return $this->subPrice;
    }

    function getNote(){
        return $this->note;
    }

    function setQuantity($quantity){
        $this->quantity = $quantity;
    }

    function setSubPrice($subPrice){
        $this->subPrice = $subPrice;
    }

    function setNote($note){
        $this->note = $note;
    }
}

?>