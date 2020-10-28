<?php

class Item {
    private $id; //Unique //Generate after insert into database
    private $name; //String
    private $catogory; //String
    private $brand; //String
    private $country; //String
    private $inventory; //Integer

    private $varieties; //Array
    private $imgPaths; //Array

    public function __construct($name, $catogory, $brand, $country, $inventory){
        $this->name = $name;
        $this->catogory = $catogory;
        $this->brand = $brand;
        $this->country = $country;
        $this->inventory = $inventory;
        
        $this->varieties = array();
        $this->imgPaths = array();
    }

    public function addVariety($variety){
        array_push($this->varieties, $variety);
    }

    public function removeVariety($index){
        UsefulFunction::removeArrayElementI($this->varieties, $index);
    }

    public function addImgPath($imgPath){
        array_push($this->imgPaths, $imgPath);
    }

    public function removeImgPath($index){
        UsefulFunction::removeArrayElementI($this->imgPaths, $index);
    }

    public function getID(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getCatogory(){
        return $this->catogory;
    }

    public function getBrand(){
        return $this->brand;
    }

    public function getCountry(){
        return $this->country;
    }

    public function getInventory(){
        return $this->$inventory;
    }

    public function getVarieties(){
        return $this->varieties;
    }

    public function getImgPaths(){
        return $this->imgPaths;
    }

    public function setID($id){
        $this->id = $id;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setCatogory($catogory){
        $this->catogory = $catogory;
    }

    public function setBrand($brand){
        $this->brand = $brand;
    }

    public function setCountry($country){
        $this->country = $country;
    }

    public function setInventory($inventory){
        $this->inventory = $inventory;
    }

}

?>