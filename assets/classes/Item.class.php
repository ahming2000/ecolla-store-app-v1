<?php

class Item {

    //Standard variable
    private $name; //String
    private $description; //String
    private $brand; //String
    private $origin; //String
    private $propertyName; //String //Type of describe way on propertys

    private $isListed; //Boolean
    private $imgCount; //Integer
    private $viewCount; //Integer

    //Array variable
    private $categories; //Array //String
    private $varieties; //Array //Variety object

    //Utility variable
    private $categoryCount; //Integer

    public function __construct($name, $description, $brand, $origin, $propertyName, $isListed, $imgCount, $viewCount){
        $this->name = $name;
        $this->description = $description;
        $this->brand = $brand;
        $this->origin = $origin;
        $this->propertyName = $propertyName;

        $this->isListed = $isListed;
        $this->imgCount = $imgCount;
        $this->viewCount = $viewCount;

        $this->categories = array();
        $this->varieties = array();

        $this->categoryCount = 0;
    }

    public function addCategory($category){
        array_push($this->categories, $category);
        $this->categoryCount++;
    }

    public function removeCategory($index){
        UsefulFunction::removeArrayElementI($this->categories, $index);
        $this->categoryCount--;
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

    public function getCategories() {
        return $this->categories;
    }

    public function setCategories($categories) {
        $this->categories = $categories;
        return $this;
    }

    public function getVarieties() {
        return $this->varieties;
    }

    public function setVarieties($varieties) {
        $this->varieties = $varieties;
        return $this;
    }

    public function getCategoryCount() {
        return $this->categoryCount;
    }

    public function setCategoryCount($categoryCount) {
        $this->categoryCount = $categoryCount;
        return $this;
    }

    public function getViewCount() {
        return $this->viewCount;
    }

    public function setViewCount($viewCount) {
        $this->viewCount = $viewCount;
        return $this;
    }

    public function getPropertyName() {
        return $this->propertyName;
    }

    public function setPropertyName($propertyName) {
        $this->propertyName = $propertyName;
        return $this;
    }
}

?>
