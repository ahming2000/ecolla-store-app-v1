<?php

require_once __DIR__."\\..\\database\\Model.class.php";

class View extends Model{

    public function getAllItems(){

        // Create an empty array
        $items = array();

        // Get all items
        // Query: SELECT * FROM items
        $dbTable_items = $this->dbSelectAll("items");

        foreach($dbTable_items as $i){

            // Create new Item object
            $item = new Item($i['i_name'], $i['i_brand'], $i['i_country'], $i['i_is_listed'], $i['i_image_count']);

            // Get catogories of current item
            // Query: SELECT * FROM catogories WHERE i_id = ?
            $dbTable_catogories = $this->dbSelectColumn("catogories", "i_id", $i["i_id"]);

            foreach($dbTable_catogories as $cat){

                // Add into item object
                $item->addCatogory($cat["cat_name"]);

            }

            // Get specifications of current item
            // Query: SELECT * FROM specifications WHERE i_id = ?
            $dbTable_specifications = $this->dbSelectColumn("specifications", "i_id", $i["i_id"]);

            foreach($dbTable_specifications as $s){

                // Get varieties of current item
                // Query: SELECT * FROM varieties WHERE v_barcode = ?
                $dbTable_varieties = $this->dbSelectColumn("varieties", "v_barcode", $s["v_barcode"]);

                foreach($dbTable_varieties as $v){

                    // Create new Variety object
                    $variety = new Variety($v['v_barcode'], $v['v_property'], $v['v_property_name'], $v['v_price'], $v['v_weight'], $v['v_weight_unit'], $v['v_discount_rate']);

                    // Get inventories of current variety
                    // Query: SELECT * FROM inventories WHERE v_barcode = ?
                    $dbTable_inventories = $this->dbSelectColumn("inventories", "v_barcode", $v['v_barcode']);

                    foreach($dbTable_inventories as $inv){

                        // Create new Inventory object
                        $inventory = new Inventory($inv["inv_expire_date"], $inv["inv_quantity"]);

                        // Add into the variety object
                        $variety->addInventory($inventory);

                    }

                    // Add into item object
                    $item->addVariety($variety);

                }

            }

            // Push current item into items
            array_push($items, $item);

        }

        return $items;
    }

    public function getItemId($item){
        // Query: SELECT i_id FROM items WHERE i_name = ? AND i_brand = ?
        return $this->dbSelectAttribute_MultiSearch("items", "i_id", ["i_name", "i_brand"], [$item->getName(), $item->getBrand()]);
    }

    public function getItem($itemName, $itemBrand){

        // Get the item
        // Query: SELECT * FROM items WHERE i_name = ? AND i_brand = ?
        $dbTable_items = $this->dbSelectColumn_MultiSearch("items", ["i_name", "i_brand"], [$itemName, $itemBrand]);

        // Take default first row (Assume only one item is found, not duplicated)
        $i = $dbTable_items[0];

        // Create new Item object
        $item = new Item($i['i_name'], $i['i_brand'], $i['i_country'], $i['i_is_listed'], $i['i_image_count']);

        // Get catogories of current item
        // Query: SELECT * FROM catogories WHERE i_id = ?
        $dbTable_catogories = $this->dbSelectColumn("catogories", "i_id", $i["i_id"]);

        foreach($dbTable_catogories as $cat){

            // Add into item object
            $item->addCatogory($cat["cat_name"]);

        }

        // Get specifications of current item
        // Query: SELECT * FROM specifications WHERE i_id = ?
        $dbTable_specifications = $this->dbSelectColumn("specifications", "i_id", $i["i_id"]);

        foreach($dbTable_specifications as $s){

            // Get varieties of current item
            // Query: SELECT * FROM varieties WHERE v_barcode = ?
            $dbTable_varieties = $this->dbSelectColumn("varieties", "v_barcode", $s["v_barcode"]);

            foreach($dbTable_varieties as $v){

                // Create new Variety object
                $variety = new Variety($v['v_barcode'], $v['v_property'], $v['v_property_name'], $v['v_price'], $v['v_weight'], $v['v_weight_unit'], $v['v_discount_rate']);

                // Get inventories of current variety
                // Query: SELECT * FROM inventories WHERE v_barcode = ?
                $dbTable_inventories = $this->dbSelectColumn("inventories", "v_barcode", $v['v_barcode']);

                foreach($dbTable_inventories as $inv){

                    // Create new Inventory object
                    $inventory = new Inventory($inv["inv_expire_date"], $inv["inv_quantity"]);

                    // Add into the variety object
                    $variety->addInventory($inventory);

                }

                // Add into item object
                $item->addVariety($variety);

            }

        }

        return $item;
    }

    public function getItemCount(){
        return $this->selectCount("items");
    }

    public function getAllOrders(){

        $orders = array();

        $dbTable_customers = $this->dbSelectAll("customer");

        foreach($dbTable_customers as $c){

            $customer = new Customer($c["c_name"], $c["c_phone_mcc"], $c["c_phone"], $c["c_address"], $c["c_postcode"], $c["c_city"], $c["c_state"]);

            $dbTable_orders = $this->dbSelectColumn("orders", "o_date_time", $c["o_date_time"]);
            $o = $dbTable_orders[0];

            $order = new Order($customer);
            $order->setDateTime($dbTable_orders["o_date_time"]);
            $order->setOrderId($dbTable_orders["o_id"]);

            array_push($orders, $order);
        }








        // $_o = $this->selectAllOrders();
        //
        // foreach($_o as $o){
        //
        //     $cartItems = array();
        //     $_c_i = $this->selectOrderItem("o_date_time", $o["o_date_time"]);
        //     foreach($_c_i as $c_i){
        //
        //         $i_id = $this->selectSpecificationAttr("i_id", "s_id", $c_i["s_id"]);
        //         $v_barcode = $this->selectSpecificationAttr("v_barcode", "s_id", $c_i["s_id"]);
        //
        //         $item = $this->selectItem("i_id", $i_id);
        //         $variety = $this->selectVariety("v_barcode", $v_barcode);
        //
        //         $cartItem = [
        //             "i_name" => $item[0]["i_name"],
        //             "i_brand" => $item[0]["i_brand"],
        //             "i_country" => $item[0]["i_country"],
        //             "i_imgCount" => $item[0]["i_imgCount"],
        //             "v_barcode" => $variety[0]["v_barcode"],
        //             "v_property" => $variety[0]["v_property"],
        //             "v_propertyName" => $variety[0]["v_propertyName"],
        //             "v_price" => $variety[0]["v_price"],
        //             "v_weight" => $variety[0]["v_weight"],
        //             "v_weightUnit" => $variety[0]["v_weightUnit"],
        //             "v_discountRate" => $variety[0]["v_discountRate"],
        //             "quantity" => $c_i["quantity"]
        //         ];
        //
        //         array_push($cartItems, $cartItem);
        //     }
        //
        //
        //     $order = [
        //         "o_date_time" => $o["o_date_time"],
        //         "o_item_count" => $o["o_item_count"],
        //         "customer" => [
        //             "c_name" => $o["c_name"],
        //             "c_phone" => $o["c_phone"],
        //             "c_address" => $o["c_address"],
        //             "c_postcode" => $o["c_postcode"],
        //             "c_city" => $o["c_city"],
        //             "c_state" => $o["c_state"],
        //             "c_receiptPath" => $o["c_receiptPath"]
        //         ],
        //         "o_subtotal" => $o["o_subtotal"],
        //         "cartItems" => $cartItems
        //     ];
        //
        //     array_push($orders, $order);
        // }

        return $orders;
    }


}

?>
