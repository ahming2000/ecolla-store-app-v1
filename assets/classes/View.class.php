<?php

require_once __DIR__."\\..\\database\\Model.class.php";

class View extends Model{

    public function getAllItems(){
        $items = array();
        $_i = $this->selectAllItems();
        foreach($_i as $items_array){
            $item = new Item($items_array['i_name'], $items_array['i_brand'], $items_array['i_country'], $items_array['i_isListed'], $items_array['i_imgCount']);

            $item->setID($items_array['i_id']);

            $catogory_array = $this->selectCatogory("i_id", $items_array['i_id']);
            foreach($catogory_array as $catogory){
                $item->addCatogory($catogory["cat_name"]);
            }

            $barcode_array = $this->selectSpecification("i_id", $items_array['i_id']);
            foreach($barcode_array as $barcode){
                $varieties_array = $this->selectVariety("v_barcode", $barcode['v_barcode']);
                foreach($varieties_array as $variety){
                    $item->addVariety(new Variety($variety['v_barcode'], $variety['v_property'], $variety['v_propertyName'], $variety['v_price'], $variety['v_weight'], $variety['v_weightUnit'], $variety['v_inventory'], $variety['v_discountRate']));
                }
            }

            array_push($items, $item);
        }
        return $items;
    }

    public function getItem($itemName){
        $_i = $this->selectItem("i_name", $itemName);
        if($_i == null) die("Item name is not found!");

        $item = new Item($_i[0]['i_name'], $_i[0]['i_brand'], $_i[0]['i_country'], $_i[0]['i_isListed'], $_i[0]['i_imgCount']);

        $item->setID($_i[0]['i_id']);

        $_catogory = $this->selectCatogory("i_id", $_i[0]["i_id"]);
        foreach($_catogory as $catogory){
            $item->addCatogory($catogory['cat_name']);
        }

        $_b = $this->selectSpecification("i_id", $_i[0]['i_id']);
        foreach($_b as $barcode){
            $_v = $this->selectVariety("v_barcode", $barcode["v_barcode"]);
            foreach($_v as $variety){
                $item->addVariety(new Variety($variety['v_barcode'], $variety['v_property'], $variety['v_propertyName'], $variety['v_price'], $variety['v_weight'], $variety['v_weightUnit'], $variety['v_inventory'], $variety['v_discountRate']));
            }
        }

        return $item;
    }

    public function getItemCount(){
        return $this->selectCount("items");
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


}

?>
