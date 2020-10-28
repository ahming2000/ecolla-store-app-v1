<?php

require_once __DIR__."\\..\\database\\Model.class.php";

class Controller extends Model{

    public function insertNewItem($item){
        $this->insertItem($item->getName(), $item->getCatogory(), $item->getBrand(), $item->getCountry());

        $item->setID($this->selectItemAttr("i_id", "i_name", $item->getName()));

        foreach($item->getVarieties() as $variety){
            $this->insertVariety($variety->getBarcode(), $variety->getProperty(), $variety->getPropertyType(), $variety->getPrice(), $variety->getWeight(), $variety->getWeightUnit(), $variety->getInventory());
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

    public function replaceAllItemDetail($orgItem, $newItem){
        $this->updateItemAttr("i_name", $newItem->getName(), "i_id", $orgItem->getID());
        $this->updateItemAttr("i_catogory", $newItem->getCatogory(), "i_id", $orgItem->getID());
        $this->updateItemAttr("i_brand", $newItem->getBrand(), "i_id", $orgItem->getID());
        $this->updateItemAttr("i_country", $newItem->getCountry(), "i_id", $orgItem->getID());

        $newItem->setID($orgItem->getID());

        foreach($newItem->getVarieties() as $variety){
            $this->updateVarietyAttr("v_property", $variety->getProperty(), "v_barcode" , $variety->getBarcode());
            $this->updateVarietyAttr("v_propertyType", $variety->getPropertyType(), "v_barcode" , $variety->getBarcode());
            $this->updateVarietyAttr("v_price", $variety->getPrice(), "v_barcode" , $variety->getBarcode());
            $this->updateVarietyAttr("v_weight", $variety->getWeight(), "v_barcode" , $variety->getBarcode());
            $this->updateVarietyAttr("v_weightUnit", $variety->getWeightUnit(), "v_barcode" , $variety->getBarcode());
            $this->updateVarietyAttr("v_inventory", $variety->getInventory(), "v_barcode" , $variety->getBarcode());
            $this->updateVarietyAttr("v_discountRate", $variety->getDiscountRate(), "v_barcode" , $variety->getBarcode());
        }

        for($i = 0; $i < sizeof($newItem->getImgPaths()); $i++){
            $this->updateItemImgAttr("imgPath", $newItem->getImgPaths()[$i], "imgPath", $orgItem->getImgPaths()[$i]);
        }
    }

    public function deleteItem($item){
        $this->deleteItemAttr("i_id", $item->getID());
        foreach($item->getVarieties() as $variety){
            $this->deleteVarietyAttr("v_barcode", $variety->getBarcode());
        }
        //To-do: delete the img file from the directory
    }
}

?>