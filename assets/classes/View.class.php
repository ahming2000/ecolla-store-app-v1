<?php

require_once __DIR__ . "\\..\\database\\Model.class.php";

class View extends Model{

    public function toItemObjList($dbTable_items){

        $items = array();

        foreach ($dbTable_items as $i) {

            // Create new Item object
            $item = new Item($i['i_name'], $i["i_desc"], $i['i_brand'], $i['i_origin'], $i['i_property_name'], $i['i_is_listed'], $i['i_image_count'], $i['i_view_count']);

            // Get classifications of current item
            // Query: SELECT cat_id FROM classifications WHERE i_id = ?
            $class = $this->dbSelectColumnAttribute("classifications", "cat_id", "i_id", $i["i_id"]);

            foreach ($class as $cat_id) {

                // Get categories of current classification
                // Query: SELECT cat_name FROM categories WHERE cat_id = ?
                $cat_name = $this->dbSelectAttribute("categories", "cat_name", "cat_id", $cat_id);

                // Add into item object
                $item->addCategory($cat_name);
            }

            // Get wholesales of current item
            // Query: SELECT * FROM wholesales WHERE i_id = ? ORDER BY w_min
            // $dbTable_wholesales = $this->dbQuery("SELECT * FROM wholesales WHERE i_id = " . $i["i_id"] . " ORDER BY w_min");

            if($dbTable_wholesales != 1){ // Result is true due to dbQuery default settings
                foreach($dbTable_wholesales as $w){

                    // Create new Wholesale object
                    $wholesale = new Wholesale($w["w_min"], $w["w_max"], $w["w_discount_rate"]);

                    // Add into item object
                    $item->addWholesale($wholesale);

                }
            }

            // Get varieties of current item
            // Query: SELECT * FROM varieties WHERE i_id = ?
            $dbTable_varieties = $this->dbSelectRow("varieties", "i_id", $i["i_id"]);

            foreach ($dbTable_varieties as $v) {

                // Create new Variety object
                $variety = new Variety($v['v_barcode'], $v['v_property'], $v['v_price'], $v['v_weight'], $v['v_discount_rate']);

                // Only loop through when barcode is available
                if (!empty($v["v_barcode"])) {

                    // Get inventories of current variety with asc expire date
                    $dbTable_inventories = $this->dbQuery("SELECT * FROM inventories WHERE v_barcode LIKE " . $v["v_barcode"] . " ORDER BY inv_expire_date");

                    // Only loop through when inventory is available
                    if ($dbTable_inventories != 1) { // Result is true due to dbQuery default settings
                        foreach ($dbTable_inventories as $inv) {

                            // Create new Inventory object
                            $inventory = new Inventory($inv["inv_expire_date"], $inv["inv_quantity"]);

                            // Add into the variety object
                            $variety->addInventory($inventory);
                        }
                    }
                }

                // Add into item object
                $item->addVariety($variety);
            }

            // Push current item into items
            array_push($items, $item);
        }

        return $items;
    }

    public function getAllItems()
    {

        // Get all items
        // Query: SELECT * FROM items
        $dbTable_items = $this->dbSelectAll("items");

        // Return empty array if no item is found
        if ($dbTable_items == null) return array();

        return $this->toItemObjList($dbTable_items);
    }

    public function getItemsWithRange($start, $range)
    {

        // Get all items
        // Query: SELECT * FROM items
        $dbTable_items = $this->dbSelectRowRange("items", "i_is_listed", 1, $start, $range);
        // Return empty array if no item is found
        if ($dbTable_items == null) return array();

        return $this->toItemObjList($dbTable_items);
    }

    public function getItemWithSpecificCategory($categoryName, $start, $range)
    {
        $dbTable_items_categories = $this->dbSelectAllRange_JoinTable("items", "classifications", "categories", "i_id", "cat_id", ["cat_name", "i_is_listed"], [$categoryName, 1], $start, $range);
        return $this->toItemObjList($dbTable_items_categories);
    }

    public function getItem($itemName)
    {

        // Get the item
        // Query: SELECT * FROM items WHERE i_name = ? AND i_brand = ?
        $dbTable_items = $this->dbSelectRow("items", "i_name", $itemName);
        // Return null  if no item is found
        if ($dbTable_items == null) return null;

        // Take default first row (Assume only one item is found, not duplicated)
        return $this->toItemObjList($dbTable_items)[0];
    }

    public function getItemId($item)
    {
        // Query: SELECT i_id FROM items WHERE i_name = ?
        return $this->dbSelectAttribute("items", "i_id", "i_name", $item->getName());
    }

    public function getItemCount()
    {
        return $this->selectCount("items");
    }

    public function toOrderObjList($dbTable_orders)
    {

        $orders = array();

        foreach ($dbTable_orders as $o) {

            $cart = new Cart();
            $cart->resetCart(); // Make sure session data is cleared

            $dbTable_order_items = $this->dbSelectRow("order_items", "o_id", $o["o_id"]);

            foreach ($dbTable_order_items as $oi) {

                $i_id = $this->dbSelectAttribute("varieties", "i_id", "v_barcode", $oi["v_barcode"]);
                $i_name = $this->dbSelectAttribute("items", "i_name", "i_id", $i_id);
                $i_brand = $this->dbSelectAttribute("items", "i_brand", "i_id", $i_id);

                $item = $this->getItem($i_name, $i_brand);
                $cartItem = new CartItem($item, $oi["oi_quantity"], $oi["v_barcode"]);
                $cart->addItem($cartItem);
            }

            $cart->setNote($o['o_note']);

            $customer = new Customer($o["c_name"], $o["c_phone_mcc"], $o["c_phone"], $o["c_address"], $o["c_state"], $o["c_area"], $o["c_postal_code"]);
            $order = new Order($customer);
            $order->importOrder($o["o_date_time"], $o["o_id"], $cart, $o["o_payment_method"], $o["o_delivery_id"], $o["o_status"]);

            array_push($orders, $order);
        }

        return $orders;
    }

    public function getAllOrders()
    {

        $dbTable_orders = $this->dbQuery("SELECT * FROM orders ORDER BY o_date_time DESC");

        return $this->toOrderObjList($dbTable_orders);
    }

    public function getOrder($orderId)
    {

        $dbTable_orders = $this->dbSelectRow("orders", "o_id", $orderId);
        if ($dbTable_orders == null) return null;

        return $this->toOrderObjList($dbTable_orders)[0];
    }

    public function getMaxItemsPerPage()
    {
        return $this->dbSelectAttribute("ecolla_website_config", "config_value_float", "config_name", "max_items_per_page");
    }

    public function getShippingFeeRate($isEastMY)
    {
        if ($isEastMY) {
            return $this->dbSelectAttribute("ecolla_website_config", "config_value_float", "config_name", "shipping_fee_east_my");
        } else {
            return $this->dbSelectAttribute("ecolla_website_config", "config_value_float", "config_name", "shipping_fee_west_my");
        }
    }

    public function getDeliveryId($orderId)
    {
        return $this->dbSelectAttribute("orders", "o_delivery_id", "o_id", $orderId);
    }

    public function orderIsExisted($orderId)
    {
        if ($this->dbSelectAttribute("orders", "o_date_time", "o_id", $orderId) != null) {
            return true;
        } else {
            return false;
        }
    }

    public function getCategoryList()
    {
        $results = $this->dbSelectAll("categories");
        $catArray = array();
        foreach ($results as $result) {
            array_push($catArray, $result);
        }
        return $catArray;
    }

    public function getCategoryTotalCount($categoryName)
    {
        $cat_id = $this->dbSelectRow_JoinTable("classifications", "items", "categories", "i_id", "cat_id", "cat_id", ["cat_name", "i_is_listed"], [$categoryName, 1]);
        return sizeof($cat_id);
    }

    public function getItemTotalCount()
    {
        return $this->dbSelectCount("items");
    }

    public function getItemTotalCountListed()
    {
        return $this->dbSelectAttributeCount("items", "i_is_listed", 1);
    }

    public function getTotalPurchaseCount($item)
    {
        // Get all barcode from same item
        $i_id = $this->getItemId($item);
        $barcodes = $this->dbSelectColumnAttribute("varieties", "v_barcode", "i_id", $i_id);

        // Get all quantity from order items table (Using array or loop)
        $count = 0;
        foreach ($barcodes as $barcode) {
            // Make sure all barcode (repeated) counting into the count variable
            $quantityList = $this->dbSelectColumnAttribute("order_items", "oi_quantity", "v_barcode", $barcode);
            foreach ($quantityList as $quantity) {
                $count += $quantity;
            }
        }

        //Return the total quantity purchased.
        return $count;
    }

    public function getPurchaseCount($barcode)
    {
        $count = 0;
        // Make sure all barcode (repeated) counting into the count variable
        $quantityList = $this->dbSelectColumnAttribute("order_items", "oi_quantity", "v_barcode", $barcode);
        foreach ($quantityList as $quantity) {
            $count += $quantity;
        }

        return $count;
    }

    public function getOrderDateTime($orderId)
    {
        return $this->dbSelectAttribute("orders", "o_date_time", "o_id", $orderId);
    }

    public function querySearch($query)
    {
        //i_name, i_brand, i_desc, i_origin, v_barcode, v_property, cat_name
        $usr_search_arr = preg_split("/,[\s]+|[\s]+,|[,]/", $query);
        $tmp_item_arr = $this->getAllItems();
        $item_arr = array();

        foreach ($tmp_item_arr as $arr_item) {
            foreach ($arr_item->getVarieties() as $variety) {
                if ($this->checkItem(
                    $arr_item->getName(),
                    $arr_item->getBrand(),
                    $arr_item->getDescription(),
                    $arr_item->getOrigin(),
                    $variety->getBarcode(),
                    $variety->getProperty(),
                    $arr_item->getCategories(),
                    $usr_search_arr
                )) {
                    //If got duplication
                    if (count($item_arr) >= 1) {
                        $flag = false;
                        foreach ($item_arr as $arr_item_2) {
                            if ($arr_item->getName() == $arr_item_2->getName())
                                $flag = true;
                        }

                        if ($flag)
                            continue;
                    }
                    array_push($item_arr, $this->getItem($arr_item->getName()));
                }
            }
        }
        return $item_arr;
    }

    public function checkItem($name, $brand, $description, $origin, $barcode, $property, $categories, $search_str)
    {
        $arr = array($name, $brand, $description, $origin, $barcode, $property);
        foreach ($categories as $c) {
            array_push($arr, $c);
        }

        $flag = true;
        $flag_arr = array();
        for ($i = 0; $i < count($search_str); $i++) {
            array_push($flag_arr, false);
        }

        for ($i = 0; $i < count($search_str); $i++) {
            $str = preg_match("/[A-Za-z]+/", $search_str[$i]) ? strtoupper($search_str[$i]) : $search_str[$i];
            for ($j = 0; $j < count($arr); $j++) {
                $str_2 = preg_match("/[A-Za-z]+/", $arr[$j]) ? strtoupper($arr[$j]) : $arr[$j];
                if (strpos($str_2, $str) !== false)
                    $flag_arr[$i] = true;
            }
        }

        for ($i = 0; $i < count($flag_arr); $i++) {
            if (!$flag_arr[$i])
                $flag = false;
        }

        return $flag;
    }
}
