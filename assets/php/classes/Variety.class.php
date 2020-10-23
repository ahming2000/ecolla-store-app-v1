<?php

class Variety {
    private $barcode; //int
    private $property; //string //Flavour or type
    private $propertyType; //String //Type of describe way on propertys
    private $price; //double //In Malaysia Riggit
    private $weight; //double
    private $weightUnit; //string //Gram or others

    public function getBarcode(){
        return $this->barcode;
    }

    public function getProperty(){
        return $this->property;
    }

    public function getPropertyType(){
        return $this->propertyType;
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

    public function setBarcode($barcode){
        $this->barcode = $barcode;
    }

    public function setProperty($property){
        $this->property = $property;
    }

    public function setPropertyType($propertyType){
        $this->propertyType = $propertyType;
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
}

?>