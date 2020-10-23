<?php

class Item {
    public $name; //String
    private $catogory; //String
    private $brand; //String
    private $country; //String
    private $imgPaths; //Array
    private $varieties; //Array

    public function __construct($name, $catogory, $brand, $country, $imgPaths){
        $this->name = $name;
        $this->catogory = $catogory;
        $this->brand = $brand;
        $this->country = $country;
        $this->imgPaths = $imgPaths;
        $this->varieties = array();
    }

    public function addVarious($variety){
        $this->varieties.push($variety);
    }

    public function removeVarious($index){
        UsefulFunction::removeArrayElementI($this->varieties, $index);
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

    public function getImgPath(){
        return $this->imgPaths;
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

    public function setImgPath($imgPaths){
        $this->imgPaths = $imgPaths;
    }
}

?>