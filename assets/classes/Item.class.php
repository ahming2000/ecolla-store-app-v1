<?php

class Item implements JsonSerializable {

    //Standard variable
    private $id; //Unique //Generate after insert into database
    private $name; //String
    private $brand; //String
    private $country; //String
    private $isListed; //Boolean
    private $imgCount; //Integer

    //Array variable
    private $catogories; //Array //String
    private $varieties; //Array //Variety object

    //Utility variable
    private $catogoryCount; //Integer

    public function __construct($name, $brand, $country, $isListed, $imgCount){
        $this->name = $name;
        $this->brand = $brand;
        $this->country = $country;
        $this->isListed = $isListed;
        $this->imgCount = $imgCount;

        $this->catogories = array();
        $this->varieties = array();

        $this->catogoryCount = 0;
    }

    //Not in use
    public function jsonSerialize(){
        return [
            'id' => $this->id,
            'name' => $this->name,
            'catogory' => $this->catogory,
            'brand' => $this->brand,
            'country' => $this->country,
            'isListed' => $this->isListed,
            'catogories' => $this->catogories,
            'varieties' => UsefulFunction::jsonSerializeArray($this->varieties),
            'catogoryCount' => $this->catogoryCount
        ];
    }

    public function addCatogory($catogory){
        array_push($this->catogories, $catogory);
        $this->catogoryCount++;
    }

    public function removeCatogory($index){
        UsefulFunction::removeArrayElementI($this->catogories, $index);
        $this->catogoryCount--;
    }

    public function addVariety($variety){
        array_push($this->varieties, $variety);
    }

    public function removeVariety($index){
        UsefulFunction::removeArrayElementI($this->varieties, $index);
    }

    public function getID(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getBrand(){
        return $this->brand;
    }

    public function getCountry(){
        return $this->country;
    }

    public function isListed(){
        return $this->isListed;
    }

    public function getImgCount(){
        return $this->imgCount;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setBrand($brand){
        $this->brand = $brand;
    }

    public function setListed($isListed){
        $this->isListed = $isListed;
    }

    public function setImgCount($imgCount){
        $this->imgCount = $imgCount;
    }

    public function setID($id){
        $this->id = $id;
    }

    public function getCatogories(){
        return $this->catogories;
    }

    public function getVarieties(){
        return $this->varieties;
    }

    public function getCatogoryCount(){
        return $this->catogoryCount;
    }

}

?>
