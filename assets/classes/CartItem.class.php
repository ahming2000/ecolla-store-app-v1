<?php

class CartItem {

    private $item;
    private $quantity;
    private $barcode; //Selected variety //Only one various can be selected in this class
    private $note;

    private $subPrice;
    private $varietyIndex;

    public function __construct($item, $quantity, $barcode, $note){
        $this->item = $item;
        $this->quantity = $quantity;
        $this->barcode = $barcode;
        $this->note = $note;

        //Assign variety index from barcode
        for($i = 0; $i < sizeof($item->getVarieties()); $i++){
            if($item->getVarieties()[$i]->getBarcode() === $this->barcode){
                $this->varietyIndex = $i;
                break;
            }
        }

        $this->subPrice = $this->setSubPrice();
    }

    public function getItem(){
        return $this->item;
    }

    public function getQuantity(){
        return $this->quantity;
    }

    public function getBarcode(){
        return $this->barcode;
    }

    public function getNote(){
        return $this->note;
    }

    public function getSubPrice(){
        return $this->subPrice;
    }

    public function getVarietyIndex(){
        return $this->varietyIndex;
    }

    public function getVariety(){
        return $this->item->getVarieties()[$this->varietyIndex];
    }

    public function getVarietyProperty(){ //Can select to be remove
        return $this->item->getVarieties()[$this->varietyIndex]->getProperty;
    }

    public function setQuantity($quantity){
        $this->quantity = $quantity;
        $this->subPrice = $this->setSubPrice();
    }

    private function setSubPrice(){
        return $this->quantity * ($this->item->getVarieties()[$this->varietyIndex]->getPrice() * $this->item->getVarieties()[$this->varietyIndex]->getDiscountRate());
    }

    public function setNote($note){
        $this->note = $note;
    }
}

?>
