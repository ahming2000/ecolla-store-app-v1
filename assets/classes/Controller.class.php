<?php

require_once __DIR__."\\..\\database\\Model.class.php";

class Controller extends Model{

    public function insertNewItem($item){
        $this->insertItem($item->getName(), $item->getBrand(), $item->getCountry(), (int) $item->isListed(), $item->getImgCount());

        $item->setID($this->selectItemAttr("i_id", "i_name", $item->getName()));

        foreach($item->getCatogories() as $catogory){
            $this->insertCatogory($item->getID(), $catogory);
        }

        foreach($item->getVarieties() as $variety){
            $this->insertVariety($variety->getBarcode(), $variety->getProperty(), $variety->getPropertyName(), $variety->getPrice(), $variety->getWeight(), $variety->getWeightUnit(), $variety->getInventory(), $variety->getDiscountRate());
            $this->insertSpecification($variety->getBarcode(), $item->getID());
        }

    }

    //Need to use more effecient way //Haven't modify for the chances - 19/11/2020
    public function modifyItemSingleAttr($attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch){
        $this->updateItemAttr($attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch);
    }

    public function replaceAllItemDetail($orgItem, $newItem){
        $this->updateItemAttr("i_name", $newItem->getName(), "i_id", $orgItem->getID());
        $this->updateItemAttr("i_catogory", $newItem->getCatogory(), "i_id", $orgItem->getID());
        $this->updateItemAttr("i_brand", $newItem->getBrand(), "i_id", $orgItem->getID());
        $this->updateItemAttr("i_country", $newItem->getCountry(), "i_id", $orgItem->getID());
        $this->updateItemAttr("i_isListed", $newItem->isListed(), "i_id", $orgItem->getID());

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

    public function createNewOrder($cart, $customer){

        $this->insertOrder($cart->getCartCount(), $customer["name"], $customer["phone"], $customer["address"], $customer["postcode"], $customer["city"], $customer["state"], $customer["receiptPath"], $cart->getSubtotal());
        $o_id = $this->selectOrderAttr("o_id", "c_name", $customer["name"]);

        foreach($cart->getCartItems() as $cartItem){
            $i_id = $cartItem->getItem()->getID();
            $s_id = $this->selectSpecificationAttr("s_id", "i_id", $i_id);
            $this->insertOrderItem($o_id, $s_id, $cartItem->getQuantity());
        }

    }
}

?>
