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

                    $v = new Variety($variety['v_barcode'], $variety['v_property'], $variety['v_propertyName'], $variety['v_price'], $variety['v_weight'], $variety['v_weightUnit'], $variety['v_discountRate']);

                    $shelfLifeList_array = $this->selectShelfLife("v_barcode", $variety['v_barcode']);
                    foreach($shelfLifeList_array as $shelfLife){
                        $v->addShelfLife(new ShelfLife($shelfLife["sll_expireDate"], $shelfLife["sll_inventory"]));
                    }

                    $item->addVariety($v);
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

                $v = new Variety($variety['v_barcode'], $variety['v_property'], $variety['v_propertyName'], $variety['v_price'], $variety['v_weight'], $variety['v_weightUnit'], $variety['v_discountRate']);

                $_sll = $this->selectShelfLife("v_barcode", $variety['v_barcode']);
                foreach($_sll as $shelfLife){
                    $v->addShelfLife(new ShelfLife($shelfLife["sll_expireDate"], $shelfLife["sll_inventory"]));
                }

                $item->addVariety($v);
            }
        }

        return $item;
    }

    public function getItemCount(){
        return $this->selectCount("items");
    }

    public function getAllOrders(){
        $orders = array();

        $_o = $this->selectAllOrders();

        foreach($_o as $o){

            $cartItems = array();
            $_c_i = $this->selectOrderItem("o_date_time", $o["o_date_time"]);
            foreach($_c_i as $c_i){

                $i_id = $this->selectSpecificationAttr("i_id", "s_id", $c_i["s_id"]);
                $v_barcode = $this->selectSpecificationAttr("v_barcode", "s_id", $c_i["s_id"]);

                $item = $this->selectItem("i_id", $i_id);
                $variety = $this->selectVariety("v_barcode", $v_barcode);

                $cartItem = [
                    "i_name" => $item[0]["i_name"],
                    "i_brand" => $item[0]["i_brand"],
                    "i_country" => $item[0]["i_country"],
                    "i_imgCount" => $item[0]["i_imgCount"],
                    "v_barcode" => $variety[0]["v_barcode"],
                    "v_property" => $variety[0]["v_property"],
                    "v_propertyName" => $variety[0]["v_propertyName"],
                    "v_price" => $variety[0]["v_price"],
                    "v_weight" => $variety[0]["v_weight"],
                    "v_weightUnit" => $variety[0]["v_weightUnit"],
                    "v_discountRate" => $variety[0]["v_discountRate"],
                    "quantity" => $c_i["quantity"]
                ];

                array_push($cartItems, $cartItem);
            }


            $order = [
                "o_date_time" => $o["o_date_time"],
                "o_item_count" => $o["o_item_count"],
                "customer" => [
                    "c_name" => $o["c_name"],
                    "c_phone" => $o["c_phone"],
                    "c_address" => $o["c_address"],
                    "c_postcode" => $o["c_postcode"],
                    "c_city" => $o["c_city"],
                    "c_state" => $o["c_state"],
                    "c_receiptPath" => $o["c_receiptPath"]
                ],
                "o_subtotal" => $o["o_subtotal"],
                "cartItems" => $cartItems
            ];

            array_push($orders, $order);
        }

        return $orders;
    }


}

?>
