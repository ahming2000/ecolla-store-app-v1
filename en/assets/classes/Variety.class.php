<?php

class Variety {

    //Standard variable
    private $barcode; //string //Unique
    private $property; //string //Flavour or type
    private $price; //Float //In Malaysia Riggit
    private $weight; //Float //In kiligram
    private $discountRate; //Float //Default: 1.0

    //Array variable
    private $inventories; //Array //Inventory object

    public function __construct($barcode, $property, $price, $weight, $discountRate){
        $this->barcode = $barcode;
        $this->property = $property;
        $this->price = $price;
        $this->weight = $weight;
        is_numeric($discountRate) ? $this->discountRate = $discountRate : $this->discountRate = 1.0;

        $this->inventories = array();
    }

    public function addInventory($inventory){
        array_push($this->inventories, $inventory);
    }

    public function removeInventory($index){
        UsefulFunction::removeArrayElementI($this->inventories, $index);
    }

    public function getTotalQuantity(){
        $total = 0;
        foreach($this->inventories as $inventory){
            $total += $inventory->getQuantity();
        }
        return $total;
    }

    public function getInventories(){
        return $this->inventories;
    }

    public function getBarcode(){
        return $this->barcode;
    }

    public function getProperty(){
        return $this->property;
    }

    public function getPrice(){
        return $this->price;
    }

    public function getWeight(){
        return $this->weight;
    }

    public function getDiscountRate(){
        return $this->discountRate;
    }

    public function setProperty($property){
        $this->property = $property;
    }

    public function setPrice($price){
        $this->price = $price;
    }

    public function setWeight($weight){
        $this->weight = $weight;
    }

    public function setDiscountRate($discountRate){
        $this->discountRate = $discountRate;
    }
}

?>