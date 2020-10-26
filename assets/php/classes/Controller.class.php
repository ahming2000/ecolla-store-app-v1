<?php

require_once "../database/Model.php";

class Controller extends Model{

    public function getItemID($item){
        return $this->selectItemAttr("i_id", "i_name", $item->getName());
    }

    public function getSpecificationID($item){
        
    }

    public function createNewItem($item){
        $this->insertItem($item->getName(), $item->getCatogory(), $item->getBrand(), $item->getCountry());

        $item->setID(getItemID($item));

        foreach($item->getVarieties() as $variety){
            $this->insertVariety($variety->getBarcode(), $variety->getProperty(), $variety->getPropertyType(), $variety->getPrice(), $variety->getWeight(), $variety->getWeightUnit());
            foreach($item->getImgPaths() as $imgPath){
                $this->insertSpecificationAttr($item->getID(), $variety->getBarcode(), $imgPath);
            }
        }
    }

    public function modifyItemSingleAttr($attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch){
        $this->updateItemAttr($attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch);
    }

    public function replaceItemDetail($orgItem, $newItem){
        $this->updateItemAttr("i_name", $newItem->getName(), "items_id", $orgItem->getID());
        $this->updateItemAttr("i_catogory", $newItem->getName(), "items_id", $orgItem->getID());
        $this->updateItemAttr("i_brand", $newItem->getName(), "items_id", $orgItem->getID());
        $this->updateItemAttr("i_country", $newItem->getName(), "items_id", $orgItem->getID());

        foreach($newItem->getImgPaths() as $imgPath){
            $this->updateImgPathAttr("items_imgPath", $imgPath, "imgPath_id", getImgPathID($item));
        }

        foreach($newItem->getVarieties() as $variety){
            $this->updateVarietyAttr("v_property", $variety->getProperty(), "v_barcode", $variety->getBarcode());
            $this->updateVarietyAttr("v_propertyType", $variety->getPropertyType(), "v_barcode", $variety->getBarcode());
            $this->updateVarietyAttr("v_price", $variety->getPrice(), "v_barcode", $variety->getBarcode());
            $this->updateVarietyAttr("v_weight", $variety->getWeight(), "v_barcode", $variety->getBarcode());
            $this->updateVarietyAttr("v_weightUnit", $variety->getWeightUnit(), "v_barcode", $variety->getBarcode());
        }
    }

}

?>