<?php

class CartItem{
        
    private $item;
    private $quantity;
    private $subPrice;
    private $varietyIndex; //Only one various can be selected in this class
    private $note;

    public function __construct($item, $quantity, $subPrice, $varietyProperty, $note){
        $this->item = $item;
        $this->quantity = $quantity;
        $this->subPrice = $subPrice;
        $this->varietyIndex = getVarietyIndex($varietyProperty);
        $this->note = $note;
    }

    private function getVarietyIndex($itemProperty){
        for($i = 0; $i < sizeof($this->item->varieties); $i++){
            if($this->item->varieties[$i] === $itemProperty){
                return $i;
            }
        }
        die("Error! No variery index in this item!");
    }

    public function getItem(){
        return $this->item;
    }

    public function getQuantity(){
        return $this->quantity;
    }

    public function getSubPrice(){
        return $this->subPrice;
    }

    public function getNote(){
        return $this->note;
    }

    public function setQuantity($quantity){
        $this->quantity = $quantity;
    }

    public function setSubPrice($subPrice){
        $this->subPrice = $subPrice;
    }

    public function setNote($note){
        $this->note = $note;
    }
}

?>