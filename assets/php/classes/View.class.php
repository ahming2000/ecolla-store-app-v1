<?php

require_once __DIR__."\\..\\database\\Model.class.php";

class View extends Model{

    public function getAllItems($attrToSearch, $attrContentToSearch){
        return $this->selectAllItems($attrToSearch, $attrContentToSearch);
    }

    public function getItemAttr($attrToSelect, $attrToSearch, $attrContentToSearch){
        return $this->selectItemAttr($attrToSelect, $attrToSearch, $attrContentToSearch);
    }

    public function getAllVarieties($attrToSearch, $attrContentToSearch){
        return $this->selectAllVarieties($attrToSearch, $attrContentToSearch);
    }

    public function getVarietyAttr($attrToSelect, $attrToSearch, $attrContentToSearch){
        return $this->selectVarietyAttr($attrToSelect, $attrToSearch, $attrContentToSearch);
    }

    public function getSpecificationAttr($attrToSelect, $attrToSearch, $attrContentToSearch){
        return $this->selectSpecificationAttr($attrToSelect, $attrToSearch, $attrContentToSearch);
    }

    public function getItemImgsAttr($attrToSelect, $attrToSearch, $attrContentToSearch){
        return $this->selectItemImgAttr($attrToSelect, $attrToSearch, $attrContentToSearch);
    }

}

?>