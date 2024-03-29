<?php

class CartItem {

    private $item;
    private $quantity;
    private $barcode; //Selected variety //Only one various can be selected in this class

    private $subPrice;
    private $varietyIndex;

    public function __construct($item, $quantity, $barcode){
        $this->item = $item;
        $this->quantity = $quantity;
        $this->barcode = $barcode;

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

        if($this->item->getVarieties()[$this->varietyIndex]->getDiscountRate() == 1.0 and !empty($this->item->getWholesales())){
            return $this->quantity * ($this->item->getVarieties()[$this->varietyIndex]->getPrice() * $this->item->getWholesalesDiscountRate($this->quantity));
        } else{
            return $this->quantity * ($this->item->getVarieties()[$this->varietyIndex]->getPrice() * $this->item->getVarieties()[$this->varietyIndex]->getDiscountRate());
        }
    }
}

?>
