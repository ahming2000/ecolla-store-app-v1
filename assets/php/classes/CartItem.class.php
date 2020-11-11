<?php

class CartItem{

    private $item;
    private $quantity;
    private $varietyIndex; //Only one various can be selected in this class
    private $subPrice;
    private $note;

    public function __construct($item, $quantity, $varietyProperty, $note){
        $this->item = $item;
        $this->quantity = $quantity;
        $this->varietyIndex = $this->getVarietyIndex($varietyProperty);
        $this->subPrice = setSubPrice();
        $this->note = $note;
    }

    private function getVarietyIndex($itemProperty){
        for($i = 0; $i < sizeof($this->getItem()->getVarieties()); $i++){
            if($this->getItem()->getVarieties()[$i] === $itemProperty){
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
        $this->subPrice = setSubPrice();
    }

    private function setSubPrice(){
        return $this->$quantity * $this->item->getVarieties()[$this->varietyIndex]->getPrice();
    }

    public function setNote($note){
        $this->note = $note;
    }
}

?>
