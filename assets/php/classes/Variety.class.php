<?php

class Variety implements JsonSerializable {
    private $barcode; //string //Unique
    private $property; //string //Flavour or type
    private $propertyType; //String //Type of describe way on propertys
    private $price; //Float //In Malaysia Riggit
    private $weight; //Float
    private $weightUnit; //string //Gram or others
    private $inventory; //Integer
    private $discountRate; //Float //Default: 1.0

    public function __construct($barcode, $property, $propertyType, $price, $weight, $weightUnit, $inventory){
        $this->barcode = $barcode;
        $this->property = $property;
        $this->propertyType = $propertyType;
        $this->price = $price;
        $this->weight = $weight;
        $this->weightUnit = $weightUnit;
        $this->inventory = $inventory;
        $this->discountRate = 1.0;
    }

    public function jsonSerialize(){
        return [
            'barcode' => $this->barcode,
            'property' => $this->property,
            'propertyType' => $this->propertyType,
            'price' => $this->price,
            'weight' => $this->weight,
            'weightUnit' => $this->weightUnit,
            'inventory' => $this->inventory,
            'discountRate' => $this->discountRate
        ];
    }

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

    public function getInventory(){
        return $this->inventory;
    }

    public function getDiscountRate(){
        return $this->discountRate;
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

    public function setInventory($inventory){
        $this->inventory = $inventory;
    }

    public function setDiscountRate($discountRate){
        $this->discountRate = $discountRate;
    }
}

?>
