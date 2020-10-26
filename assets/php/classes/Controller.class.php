<?php

include "assets/php/includes/class-auto-loader.inc.php"; //Auto include classes when needed.
require_once "../database/Model.php";

class Controller extends Model{

    public function getItemID($item){
        return $this->selectItemAttr("i_id", "i_name", $item->getName());
    }

    public function createNewItem($item){
        $this->insertItem($item->getName(), $item->getCatogory(), $item->getBrand(), $item->getCountry());

        $item->setID(getItemID($item));

        foreach($item->getVarieties() as $variety){
            $this->insertVariety($variety->getBarcode(), $variety->getProperty(), $variety->getPropertyType(), $variety->getPrice(), $variety->getWeight(), $variety->getWeightUnit());
            $this->insertSpecification($variety->getBarcode(), $item->getID());
        }

        foreach($item->getImgPaths() as $imgPath){
            $this->insertItemImg($item->getID(), $imgPath);
        }

    }

    //Need to use more effecient way
    public function modifyItemSingleAttr($attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch){
        $this->updateItemAttr($attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch);
    }

    public function replaceItemDetail($orgItem, $newItem){
        $this->updateItemAttr("i_name", $newItem->getName(), "items_id", $orgItem->getID());
        $this->updateItemAttr("i_catogory", $newItem->getCatogory(), "items_id", $orgItem->getID());
        $this->updateItemAttr("i_brand", $newItem->getBrand(), "items_id", $orgItem->getID());
        $this->updateItemAttr("i_country", $newItem->getCountry(), "items_id", $orgItem->getID());

        $newItem->setID($orgItem->getID());

        foreach($newItem->getVarieties() as $variety){
            $this->updateVarietyAttr("v_property", $variety->getProperty(), "v_barcode" , $variety->getBarcode());
            $this->updateVarietyAttr("v_propertyType", $variety->getPropertyType(), "v_barcode" , $variety->getBarcode());
            $this->updateVarietyAttr("v_price", $variety->getPrice(), "v_barcode" , $variety->getBarcode());
            $this->updateVarietyAttr("v_weight", $variety->getWeight(), "v_barcode" , $variety->getBarcode());
            $this->updateVarietyAttr("v_weightUnit", $variety->getWeightUnit(), "v_barcode" , $variety->getBarcode());
        }

        for($i = 0; $i < sizeof($newItem->getImgPaths()); $i++){
            $this->updateItemImgAttr("imgPath", $newItem->getImgPaths()[$i], "imgPath", $orgItem->getImgPaths()[$i]);
        }
    }

}

?>