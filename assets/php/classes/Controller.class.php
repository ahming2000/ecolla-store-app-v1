<?php

require_once "../database/Model.php";

class Controller extends Model{

    public function getItemID($item){
        return selectItemAttr("items_id", "items_name", $item->getName());
    }

    public function createNewItem($item){
        insertItem($item->getName(), $item->getCatogory(), $item->getBrand(), $item->getCountry(), $item->getImgPath());
        foreach($item->getVarieties() as $variety){
            insertVariety($variety->getBarcode(), $variety->getProperty(), $variety->getPropertyType(), $variety->getPrice(), $variety->getWeight(), $variety->getWeightUnit());
            insertItemGroup(getItemID($item), $variety->getBarcode());
        }
    }

    public function modifyItemSingleAttr($attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch){
        updateItemAttr($attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch);
    }

    public function replaceItemDetail($orgItem, $newItem){
        updateItemAttr("items_name", $newItem->getName(), "items_id", getItemID($item));
        updateItemAttr("items_name", $newItem->getName(), "items_id", getItemID($item));
        updateItemAttr("items_name", $newItem->getName(), "items_id", getItemID($item));
        updateItemAttr("items_name", $newItem->getName(), "items_id", getItemID($item));
        updateItemAttr("items_name", $newItem->getName(), "items_id", getItemID($item));
        for
    }

}

?>