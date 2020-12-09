<?php

class Item {

    //Standard variable
    private $name; //String
    private $description; //String
    private $brand; //String
    private $origin; //String
    private $isListed; //Boolean
    private $imgCount; //Integer
    private $viewCount; //Integer

    //Array variable
    private $catogories; //Array //String
    private $varieties; //Array //Variety object

    //Utility variable
    private $catogoryCount; //Integer

    public function __construct($name, $description, $brand, $origin, $isListed, $imgCount, $viewCount){
        $this->name = $name;
        $this->description = $description;
        $this->brand = $brand;
        $this->origin = $origin;
        $this->isListed = $isListed;
        $this->imgCount = $imgCount;
        $this->viewCount = $viewCount;

        $this->catogories = array();
        $this->varieties = array();

        $this->catogoryCount = 0;
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

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getBrand() {
        return $this->brand;
    }

    public function setBrand($brand) {
        $this->brand = $brand;
        return $this;
    }

    public function getOrigin() {
        return $this->origin;
    }

    public function setOrigin($origin) {
        $this->origin = $origin;
        return $this;
    }

    public function isListed() {
        return $this->isListed;
    }

    public function setListed($isListed) {
        $this->isListed = $isListed;
        return $this;
    }

    public function getImgCount() {
        return $this->imgCount;
    }

    public function setImgCount($imgCount) {
        $this->imgCount = $imgCount;
        return $this;
    }

    public function getCatogories() {
        return $this->catogories;
    }

    public function setCatogories($catogories) {
        $this->catogories = $catogories;
        return $this;
    }

    public function getVarieties() {
        return $this->varieties;
    }

    public function setVarieties($varieties) {
        $this->varieties = $varieties;
        return $this;
    }

    public function getCatogoryCount() {
        return $this->catogoryCount;
    }

    public function setCatogoryCount($catogoryCount) {
        $this->catogoryCount = $catogoryCount;
        return $this;
    }

    public function getViewCount() {
        return $this->viewCount;
    }

    public function setViewCount($viewCount) {
        $this->viewCount = $viewCount;
        return $this;
    }

}

?>
