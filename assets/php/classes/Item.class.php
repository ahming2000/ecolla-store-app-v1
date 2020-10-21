<?php

/* */

class Item {
    public $name; //String
    private $catogory; //String
    private $imgPaths; //Array
    private $variousList; //Array

    function __construct($name, $catogory, $imgPaths){
        $this->name = $name;
        $this->catogory = $catogory;
        $this->imgPaths = $imgPaths;
        $this->variousList = array();
    }

    function addVarious($various){
        $this->variousList.push($various);
    }

    function removeVarious($index){
        UsefulFunction::removeArrayElementI($this->various, $index);
    }

    
    function __toString(){
        return (string)$this->name;
    }

    function getName(){
        return $this->name;
    }

    function getCatogory(){
        return $this->catogory;
    }

    function getImgPath(){
        return $this->imgPaths;
    }

    function setName($name){
        $this->name = $name;
    }

    function setImgPath($imgPaths){
        $this->imgPaths = $imgPaths;
    }

    function setCatogory($catogory){
        $this->catogory = $catogory;
    }

}

?>