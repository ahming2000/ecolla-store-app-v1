<?php

require_once __DIR__."\\..\\database\\Model.class.php";

class View extends Model{

    private function toItemObjList($dbTable_items){

        $items = array();

        foreach($dbTable_items as $i){

            // Create new Item object
            $item = new Item($i['i_name'], $i["i_desc"], $i['i_brand'], $i['i_origin'], $i['i_is_listed'], $i['i_image_count']);

            // Get classifications of current item
            // Query: SELECT cat_id FROM classifications WHERE i_id = ?
            $class = $this->dbSelectColumn("classifications", "cat_id", "i_id", $i["i_id"]);

            foreach($class as $cat_id){

                // Get catogories of current classification
                // Query: SELECT cat_name FROM catogories WHERE cat_id = ?
                $cat_name = $this->dbSelectAttribute("catogories", "cat_name", "cat_id", $cat_id);

                // Add into item object
                $item->addCatogory($cat_name);

            }

            // Get varieties of current item
            // Query: SELECT * FROM varieties WHERE i_id = ?
            $dbTable_varieties = $this->dbSelectRow("varieties", "i_id", $i["i_id"]);

            foreach($dbTable_varieties as $v){

                // Create new Variety object
                $variety = new Variety($v['v_barcode'], $v['v_property'], $v['v_property_name'], $v['v_price'], $v['v_weight'], $v['v_discount_rate']);

                // Get inventories of current variety
                // Query: SELECT * FROM inventories WHERE v_barcode = ?
                $dbTable_inventories = $this->dbSelectRow("inventories", "v_barcode", $v['v_barcode']);

                foreach($dbTable_inventories as $inv){

                    // Create new Inventory object
                    $inventory = new Inventory($inv["inv_expire_date"], $inv["inv_quantity"]);

                    // Add into the variety object
                    $variety->addInventory($inventory);

                }

                // Add into item object
                $item->addVariety($variety);

            }

            // Push current item into items
            array_push($items, $item);

        }

        return $items;
    }

    public function getAllItems(){

        // Get all items
        // Query: SELECT * FROM items
        $dbTable_items = $this->dbSelectAll("items");
        // Return empty array if no item is found
        if($dbTable_items == null) return array();

        return $this->toItemObjList($dbTable_items);
    }

    public function getItemsWithRange($start, $range){

        // Get all items
        // Query: SELECT * FROM items
        $dbTable_items = $this->dbSelectRange("items", $start, $range);
        // Return empty array if no item is found
        if($dbTable_items == null) return array();

        return $this->toItemObjList($dbTable_items);
    }

    public function getItemWithSpecificCatogory($catogoryName, $start, $range){
        $dbTable_items_catogories = $this->dbSelectRow_JoinTable("items", "classifications", "catogories", "i_id", "cat_id", "cat_name", $catogoryName, $start, $range);
        return $this->toItemObjList($dbTable_items_catogories);
    }

    public function getItem($itemName, $itemBrand){

        // Get the item
        // Query: SELECT * FROM items WHERE i_name = ? AND i_brand = ?
        $dbTable_items = $this->dbSelectRow("items", ["i_name", "i_brand"], [$itemName, $itemBrand]);
        // Return null  if no item is found
        if($dbTable_items == null) return null;

        // Take default first row (Assume only one item is found, not duplicated)
        return $this->toItemObjList($dbTable_items)[0];
    }

    public function getItemId($item){
        // Query: SELECT i_id FROM items WHERE i_name = ? AND i_brand = ?
        return $this->dbSelectAttribute("items", "i_id", ["i_name", "i_brand"], [$item->getName(), $item->getBrand()]);
    }

    public function getItemCount(){
        return $this->selectCount("items");
    }

    public function getAllOrders(){

        $orders = array();

        $dbTable_orders = $this->dbSelectAll("orders");

        foreach($dbTable_orders as $o){

            $cart = new Cart();
            $cart->resetCart(); // Make sure session data is cleared

            $dbTable_order_items = $this->dbSelectRow("order_items", "o_id", $o["o_id"]);

            foreach($dbTable_order_items as $oi){

                $i_id = $this->dbSelectAttribute("varieties", "i_id", "v_barcode", $oi["v_barcode"]);
                $i_name = $this->dbSelectAttribute("items", "i_name", "i_id", $i_id);
                $i_brand = $this->dbSelectAttribute("items", "i_brand", "i_id", $i_id);

                $item = $this->getItem($i_name, $i_brand);
                $cartItem = new CartItem($item, $oi["oi_quantity"], $oi["v_barcode"], $oi["oi_note"]);
                $cart->addItem($cartItem);

            }

            $customer = new Customer($o["c_name"], $o["c_phone_mcc"], $o["c_phone"], $o["c_address"], $o["c_state"], $o["c_area"], $o["c_postal_code"]);
            $order = new Order($customer);
            $order->importOrder($o["o_date_time"], $o["o_id"], $cart, $o["o_delivery_id"]);

            array_push($orders, $order);
        }

        return $orders;
    }

    public function getOrder($orderId){

        $dbTable_orders = $this->dbSelectRow("orders", "o_id", $orderId);
        if($dbTable_orders == null) return null;

        $o = $dbTable_orders[0];

        $cart = new Cart();
        $cart->resetCart(); // Make sure session data is cleared

        $dbTable_order_items = $this->dbSelectRow("order_items", "o_id", $o["o_id"]);

        foreach($dbTable_order_items as $oi){

            $i_id = $this->dbSelectAttribute("varieties", "i_id", "v_barcode", $oi["v_barcode"]);
            $i_name = $this->dbSelectAttribute("items", "i_name", "i_id", $i_id);
            $i_brand = $this->dbSelectAttribute("items", "i_brand", "i_id", $i_id);

            $item = $this->getItem($i_name, $i_brand);
            $cartItem = new CartItem($item, $oi["oi_quantity"], $oi["v_barcode"], $oi["oi_note"]);
            $cart->addItem($cartItem);

        }

        $customer = new Customer($o["c_name"], $o["c_phone_mcc"], $o["c_phone"], $o["c_address"]);
        $order = new Order($customer);
        $order->importOrder($o["o_date_time"], $o["o_id"], $cart, $o["o_delivery_id"]);

        return $order;
    }

    public function getMaxItemsPerPage(){
        return $this->dbSelectAttribute("ecolla_website_config", "config_value_float", "config_name", "max_items_per_page");
    }

    public function getShippingFeeRate($isEastMY){
        if($isEastMY){
            return $this->dbSelectAttribute("ecolla_website_config", "config_value_float", "config_name", "shipping_fee_east_my");
        } else{
            return $this->dbSelectAttribute("ecolla_website_config", "config_value_float", "config_name", "shipping_fee_west_my");
        }
    }

    public function getDeliveryId($orderId){
        return $this->dbSelectAttribute("orders", "o_delivery_id", "o_id", $orderId);
    }

    public function orderIsExisted($orderId){
        if($this->dbSelectAttribute("orders", "o_date_time", "o_id", $orderId) != null){
            return true;
        } else{
            return false;
        }
    }

    public function getCatogoryList(){
        $results = $this->dbSelectAll("catogories");
        $catArray = array();
        foreach($results as $result){
            array_push($catArray, $result);
        }
        return $catArray;
    }

    public function getCatogoryTotalCount($catogoryName){
        $cat_id = $this->dbSelectAttribute("catogories", "cat_id", "cat_name", $catogoryName);
        return $this->dbSelectAttributeCount("classifications", "cat_id", $cat_id);
    }

    public function getItemTotalCount(){
        return $this->dbSelectCount("items");
    }

}

?>
