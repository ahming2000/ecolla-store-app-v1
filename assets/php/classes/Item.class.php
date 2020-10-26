<?php

class Item {
    private $id; //Unique //Generate after insert into database
    private $name; //String
    private $catogory; //String
    private $brand; //String
    private $country; //String

    private $varieties; //Array
    private $imgPaths; //Array

    public function __construct($name, $catogory, $brand, $country){
        $this->name = $name;
        $this->catogory = $catogory;
        $this->brand = $brand;
        $this->country = $country;
        
        $this->varieties = array();
        $this->imgPaths = array();
    }

    public function addVariety($variety){
        $this->varieties.push($variety);
    }

    public function removeVariety($index){
        UsefulFunction::removeArrayElementI($this->varieties, $index);
    }

    public function addImgPath($imgPath){
        $this->imgPaths.push($imgPath);
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

}

?>