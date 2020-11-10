<?php

require_once __DIR__."\\..\\database\\Model.class.php";

class View extends Model{

    public function getAllItems(){
        $items = array();
        $_i = $this->selectAllItems();
        foreach($_i as $items_array){
            $item = new Item($items_array['i_name'], $items_array['i_catogory'], $items_array['i_brand'], $items_array['i_country'], $items_array['i_isListed']);

            $item->setID($items_array['i_id']);

            $barcode_array = $this->selectSpecification("i_id", $items_array['i_id']);
            foreach($barcode_array as $barcode){
                $varieties_array = $this->selectVariety("v_barcode", $barcode["v_barcode"]);
                foreach($varieties_array as $variety){
                    $v = new Variety($variety['v_barcode'], $variety['v_property'], $variety['v_propertyType'], $variety['v_price'], $variety['v_weight'], $variety['v_weightUnit'], $variety['v_inventory']);
                    $v->setDiscountRate($variety['v_discountRate']);
                    $item->addVariety($v);

                }
            }

            $imgPaths_array = $this->selectItemImg("i_id", $items_array["i_id"]);
            foreach($imgPaths_array as $imgPaths){
                $item->addImgPath($imgPaths['imgPath']);
            }

            array_push($items, $item);
        }
        return $items;
    }

    public function getItem($itemName){
        $_i = $this->selectItem("i_name", $itemName);
        if($_i == null) die("Item name is not found!");

        $item = new Item($_i[0]['i_name'], $_i[0]['i_catogory'], $_i[0]['i_brand'], $_i[0]['i_country'], $_i[0]['i_isListed']);

        $item->setID($_i[0]['i_id']);

        $_b = $this->selectSpecification("i_id", $_i[0]['i_id']);

        foreach($_b as $barcode){
            $_v = $this->selectVariety("v_barcode", $barcode["v_barcode"]);
            foreach($_v as $variety){
                $v = new Variety($variety['v_barcode'], $variety['v_property'], $variety['v_propertyType'], $variety['v_price'], $variety['v_weight'], $variety['v_weightUnit'], $variety['v_inventory']);
                $v->setDiscountRate($variety['v_discountRate']);
                $item->addVariety($v);

            }
        }

        $_img = $this->selectItemImg("i_id", $_i[0]["i_id"]);
        foreach($_img as $imgPaths){
            $item->addImgPath($imgPaths['imgPath']);
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

    public function getItemImgs($attrToSearch, $attrContentToSearch){
        return $this->selectItemImg($attrToSearch, $attrContentToSearch);
    }

    public function getItemImgsAttr($attrToSelect, $attrToSearch, $attrContentToSearch){
        return $this->selectItemImgAttr($attrToSelect, $attrToSearch, $attrContentToSearch);
    }

}

?>
