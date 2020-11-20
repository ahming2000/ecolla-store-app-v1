<?php

class Variety implements JsonSerializable {

    //Standard variable
    private $barcode; //string //Unique
    private $property; //string //Flavour or type
    private $propertyName; //String //Type of describe way on propertys
    private $price; //Float //In Malaysia Riggit
    private $weight; //Float
    private $weightUnit; //string //Gram or others
    private $discountRate; //Float //Default: 1.0

    //Array variable
    private $shelfLifeList; //Array //ShelfLife object

    public function __construct($barcode, $property, $propertyName, $price, $weight, $weightUnit, $discountRate){
        $this->barcode = $barcode;
        $this->property = $property;
        $this->propertyName = $propertyName;
        $this->price = $price;
        $this->weight = $weight;
        $this->weightUnit = $weightUnit;
        is_numeric($discountRate) ? $this->discountRate = $discountRate : $this->discountRate = 1.0;

        $this->shelfLifeList = array();
    }

    //Not in use //Didn't modify for the changes - 20/11/2020
    public function jsonSerialize(){
        return [
            'barcode' => $this->barcode,
            'property' => $this->property,
            'propertyName' => $this->propertyName,
            'price' => $this->price,
            'weight' => $this->weight,
            'weightUnit' => $this->weightUnit,
            'discountRate' => $this->discountRate
        ];
    }

    public function addShelfLife($shelfLife){
        array_push($this->shelfLifeList, $shelfLife);
    }

    public function removeShelfLife($index){
        UsefulFunction::removeArrayElementI($this->shelfLifeList, $index);
    }

    public function getShelfLifeList(){
        return $this->shelfLifeList;
    }

    public function getBarcode(){
        return $this->barcode;
    }

    public function getProperty(){
        return $this->property;
    }

    public function getPropertyName(){
        return $this->propertyName;
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

    public function setPropertyName($propertyName){
        $this->propertyName = $propertyName;
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
