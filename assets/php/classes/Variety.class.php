<?php

class Variety {
    private $property; //string //Flavour or type
    private $price; //double //In Malaysia Riggit
    private $weight; //double
    private $weightUnit; //string //Gram or others
    private $barcode; //int

    public function getProperty(){
        return $this->property;
    }

    public function getPrice(){
        return $this->price;
    }

    public function getWeight(){
        return $this->weight;
    }

    public function getWeightUnit(){
        return $this->weightUnit;
    }

    public function getBarcode(){
        return $this->barcode;
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

    public function setWeightUnit($weightUnit){
        $this->weightUnit = $weightUnit;
    }

    public function setBarcode($barcode){
        $this->barcode = $barcode;
    }

}

?>