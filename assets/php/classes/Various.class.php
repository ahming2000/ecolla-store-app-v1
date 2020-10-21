<?php

/* */

class Various{
    private $properties; //string //Flavour or type
    private $price; //double //In Malaysia Riggit
    private $weight; //double
    private $weightUnit; //string //Gram or others
    private $barcode; //int

    function getProperties(){
        return $this->properties;
    }

    function getPrice(){
        return $this->price;
    }

    function getWeight(){
        return $this->weight;
    }

    function getWeightUnit(){
        return $this->weightUnit;
    }

    function getBarcode(){
        return $this->barcode;
    }

    function setProperties($properties){
        $this->properties = $properties;
    }

    function setPrice($price){
        $this->price = $price;
    }

    function setWeight($weight){
        $this->weight = $weight;
    }

    function setWeightUnit($weightUnit){
        $this->weightUnit = $weightUnit;
    }

    function setBarcode($barcode){
        $this->barcode = $barcode;
    }

}

?>