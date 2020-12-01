<?php

require_once __DIR__."\\..\\database\\Model.class.php";

class Controller extends Model {

    public function insertNewItem($item){

        // Case:
        // 1. Variety cannot duplicate
        foreach($item->getVarieties() as $_v) {
            if($this->dbSelectRow("varieties", "v_barcode", $_v->getBarcode()) != null) return false;
        }
        // 2. Item name and item brand cannot duplicate
        if($this->dbSelectRow_MultiSearch("items", ["i_name", "i_brand"], [$item->getName(), $item->getBrand()]) != null) return false;

        // Insert priority: items > catogories > classifications > varieties > inventories

        // Insert into items table first to get item id generated by database
        $item_ready = [$item->getName(), $item->getDescription(), $item->getBrand(), $item->getCountry(), (int) $item->isListed(), $item->getImgCount()];
        $this->dbInsert("items", $item_ready);

        // Get item id from database
        // Query: SELECT i_id FROM items WHERE i_name = ? AND i_brand = ?
        $i_id = $this->dbSelectAttribute_MultiSearch("items", "i_id", ["i_name", "i_brand"], [$item->getName(), $item->getBrand()]);


        foreach($item->getCatogories() as $catogory){

            // Get catogory id from database
            // Query: SELECT cat_id FROM catogories WHERE cat_name = ?
            $cat_id = $this->dbSelectAttribute("catogories", "cat_id", "cat_name", $catogory);

            // Insert the catogory if it does not exist in the database
            if($result == null){
                // Insert into catogories
                $catogory_ready = [$catogory];
                $this->dbInsert("catogories", $catogory_ready);

                // Get catogory id from database
                // Query: SELECT cat_id FROM catogories WHERE cat_name = ?
                $cat_id = $this->dbSelectAttribute("catogories", "cat_id", "cat_name", $catogory);
            }

            // Insert into classifications
            $classification_ready = [$i_id, $cat_id];
            $this->dbInsert("classifications", $classification_ready);
        }

        // Insert into varieties
        foreach($item->getVarieties() as $variety){
            $variety_ready = [$variety->getBarcode(), $variety->getProperty(), $variety->getPropertyName(), $variety->getPrice(), $variety->getWeight(), $variety->getWeightUnit(), $variety->getDiscountRate(), $i_id];
            $this->dbInsert("varieties", $variety_ready);

            // Insert into inventories
            foreach($variety->getInventories() as $inventory){
                $inventory_ready = [$variety->getBarcode(), $inventory->getExpireDate(), $inventory->getQuantity()];
                $this->dbInsert("inventories", $inventory_ready);
            }

        }

        return true;
    }






    //Need to use more effecient way //Haven't modify for the chances - 19/11/2020 and 20/11/2020
    public function modifyItemSingleAttr($attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch){
        $this->updateItemAttr($attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch);
    }






    public function replaceItem($oldItem, $newItem){

    }






    public function deleteItem($item){
        $this->deleteItemAttr("i_id", $item->getID());
        foreach($item->getVarieties() as $variety){
            $this->deleteVarietyAttr("v_barcode", $variety->getBarcode());
        }
        //To-do: delete the img file from the directory
    }






    public function insertNewOrder($order){ //$order

        $order_ready = [$order->getOrderId(), $order->getDateTime(), $order->getCustomer()->getName(), $order->getCustomer()->getPhoneMMC(), $order->getCustomer()->getPhone(), $order->getCustomer()->getAddress()];
        $this->dbInsert("orders", $order_ready);

        foreach($order->getCart()->getCartItems() as $cartItem){
            $order_items_ready = [$order->getOrderId(), $cartItem->getItem()->getVarieties()[$cartItem->getVarietyIndex()]->getBarcode(), $cartItem->getQuantity(), $cartItem->getNote()];
            $this->dbInsert("order_items", $order_items_ready);

            // TO-DO: Edit Inventory

        }

    }

    public function checkUserPassword($username, $password){
        $results = $this->dbSelectRow("users", "user_name", $username);
        if(count($results) > 0 && password_verify($password, $results[0]["user_password"])){
            return true;
        }
        return false;
    }

    // Static function to call
    public function registerAccount(){
        $this->dbInsert("users", ["ahming", password_hash("Ksm10072000", PASSWORD_BCRYPT)]);
    }
}

?>
