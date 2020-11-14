<?php

class Item implements JsonSerializable {
    private $id; //Unique //Generate after insert into database
    private $name; //String
    private $catogory; //String
    private $brand; //String
    private $country; //String
    private $isListed; //Boolean

    private $varieties; //Array
    private $imgPaths; //Array

    public function __construct($name, $catogory, $brand, $country, $isListed){
        $this->name = $name;
        $this->catogory = $catogory;
        $this->brand = $brand;
        $this->country = $country;
        $this->isListed = $isListed;

        $this->varieties = array();
        $this->imgPaths = array();
    }

    public function jsonSerialize(){
        return [
            'id' => $this->id,
            'name' => $this->name,
            'catogory' => $this->catogory,
            'brand' => $this->brand,
            'country' => $this->country,
            'isListed' => $this->isListed,
            'varieties' => UsefulFunction::jsonSerializeArray($this->varieties),
            'imgPaths' => $this->imgPaths
        ];
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

    public function getVarieties(){
        return $this->varieties;
    }

    public function getImgPaths(){
        return $this->imgPaths;
    }

    public function isListed(){
        return $this->isListed;
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

    public function setListed($isListed){
        $this->isListed = $isListed;
    }

}

?>
