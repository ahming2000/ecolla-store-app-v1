<?php

require_once __DIR__."\\..\\database\\Model.class.php";

class Controller extends Model {

    public function insertNewItem($itemName){

        // Check duplication
        if($this->dbSelectRow("items", "i_name", $itemName) != null) return false;

        $item_ready = [$itemName, "", "", "", "", 0];
        $this->dbInsert("items", $item_ready);
        return true;
    }

    public function updateItem($oldItem, $newItem, $i_id){

        // No changes
        if($oldItem == $newItem) return true;
        else{
            /* Item */
            // Item name
            if ($oldItem->getName() != $newItem->getName()) $this->dbUpdate("items", "i_name", $newItem->getName(), "i_id", $i_id);

            // Item description
            if ($oldItem->getDescription() != $newItem->getDescription()) $this->dbUpdate("items", "i_desc", $newItem->getDescription(), "i_id", $i_id);

            // Item brand
            if ($oldItem->getBrand() != $newItem->getBrand()) $this->dbUpdate("items", "i_brand", $newItem->getBrand(), "i_id", $i_id);

            // Item Origin
            if ($oldItem->getOrigin() != $newItem->getOrigin()) $this->dbUpdate("items", "i_origin", $newItem->getOrigin(), "i_id", $i_id);

            // Item property name
            if ($oldItem->getPropertyName() != $newItem->getPropertyName()) $this->dbUpdate("items", "i_property_name", $newItem->getPropertyName(), "i_id", $i_id);

            // Item image count
            if ($oldItem->getImgCount() != $newItem->getImgCount()) $this->dbUpdate("items", "i_image_count", $newItem->getImgCount(), "i_id", $i_id);

            /* Category */
            $categoryToRemove = array_diff($oldItem->getCategories(), $newItem->getCategories());
            $categoryToAdd = array_diff($newItem->getCategories(), $oldItem->getCategories());

            // Remove category
            foreach($categoryToRemove as $cat){
                $cat_id = $this->dbSelectAttribute("categories", "cat_id", "cat_name", $cat);
                $this->dbDelete("classifications", ["i_id", "cat_id"], [$i_id, $cat_id]);

                if($this->dbSelectAttribute("classifications", "i_id", "cat_id", $cat_id) == null){
                    // If no item have the specific category, delete it from category table
                    $this->dbDelete("categories", "cat_id", $cat_id);
                }
            }

            // Add category
            foreach($categoryToAdd as $cat){
                $cat_id = $this->dbSelectAttribute("categories", "cat_id", "cat_name", $cat);

                if($cat_id == null){
                    $category_ready = [$cat];
                    $this->dbInsert("categories", $category_ready);

                    $cat_id = $this->dbSelectAttribute("categories", "cat_id", "cat_name", $cat);
                }

                $classification_ready = [$i_id, $cat_id];
                $this->dbInsert("classifications", $classification_ready);
            }

            /* Variety and Inventory */

            // Add all old item barcode into an array
            $oldItemBarcode = array();
            foreach($oldItem->getVarieties() as $v){
                array_push($oldItemBarcode, $v->getBarcode());
            }

            $newItemBarcode = array();
            foreach($newItem->getVarieties() as $v){
                array_push($newItemBarcode, $v->getBarcode());
            }

            // Get modify information
            $barcodeRemained = array_intersect($oldItemBarcode, $newItemBarcode);
            $barcodeToRemove = array_diff($oldItemBarcode, $newItemBarcode);
            $barcodeToAdd = array_diff($newItemBarcode, $oldItemBarcode);

            // Remove variety (Auto remove inventory with cascade delete rule)
            foreach($barcodeToRemove as $b){
                $this->dbDelete("varieties", "v_barcode", $b);
            }

            // Update remained variety information
            foreach($barcodeRemained as $b){

                $newI;
                $oldI;

                // Get new item variety index
                for($i = 0; $i < sizeof($newItem->getVarieties()); $i++){
                    if ($newItem->getVarieties()[$i]->getBarcode() == $b) $newI = $i;
                }

                // Get new item variety index
                for($i = 0; $i < sizeof($oldItem->getVarieties()); $i++){
                    if ($oldItem->getVarieties()[$i]->getBarcode() == $b) $oldI = $i;
                }

                $oldV = $oldItem->getVarieties()[$oldI];
                $newV = $newItem->getVarieties()[$newI];

                // Variety property
                if($oldV->getProperty() != $newV->getProperty()) $this->dbUpdate("varieties", "v_property", $newV->getProperty(), "v_barcode", $b);

                // Variety price
                if($oldV->getPrice() != $newV->getPrice()) $this->dbUpdate("varieties", "v_price", $newV->getPrice(), "v_barcode", $b);

                // Variety weight
                if($oldV->getWeight() != $newV->getWeight()) $this->dbUpdate("varieties", "v_weight", $newV->getWeight(), "v_barcode", $b);

                // Variety discount rate
                if($oldV->getDiscountRate() != $newV->getDiscountRate()) $this->dbUpdate("varieties", "v_discount_rate", $newV->getDiscountRate(), "v_barcode", $b);

                /* Inventory */
                $invCountDiff = sizeof($newV->getInventories()) - sizeof($oldV->getInventories());
                $inv_ids = $this->dbSelectColumnAttribute("inventories", "inv_id", "v_barcode", $b);

                // Direct delete all and recreate again (May do more operations and use up more inv_id)
                /*
                // Delete all first
                for($i = 0; $i < sizeof($inv_ids); $i++){
                    $this->dbDelete("inventories", "inv_id", $inv_ids[$i]);
                }

                // Insert new
                for($i = 0; $i < sizeof($newV->getInventories()); $i++){
                    $inventory_ready = [$b, $newV->getInventories()[$i]->getExpireDate(), $newV->getInventories()[$i]->getQuantity()];
                    $this->dbInsert("inventories", $inventory_ready);
                }
                */

                if($invCountDiff < 0){ // Old inventory is more than new inventory

                    // Delete extra inventory
                    for($i = 0; $i < abs($invCountDiff); $i++){
                        $this->dbDelete("inventories", "inv_id", $inv_ids[0]); //Delete first inv_id row found
                        array_shift($inv_ids); // Remove the first inv_id which deleted from inventories table
                    }

                    // Update current available data
                    for($i = 0; $i < sizeof($newV->getInventories()); $i++){

                        // Inventory expire date
                        $this->dbUpdate("inventories", "inv_expire_date", $newV->getInventories()[$i]->getExpireDate(), "inv_id", $inv_ids[$i]);

                        // Inventory quantity
                        $this->dbUpdate("inventories", "inv_quantity", $newV->getInventories()[$i]->getQuantity(), "inv_id", $inv_ids[$i]);

                    }

                } else if($invCountDiff > 0){ // Old inventory is less than new inventory

                    // Insert the new one first
                    for($i = 0; $i < $invCountDiff; $i++){
                        $inventory_ready = [$b, $newV->getInventories()[$i]->getExpireDate(), $newV->getInventories()[$i]->getQuantity()];
                        $this->dbInsert("inventories", $inventory_ready);
                    }

                    // Update current available data
                    for($i = $invCountDiff; $i < sizeof($newV->getInventories()); $i++){

                        // Inventory expire date
                        $this->dbUpdate("inventories", "inv_expire_date", $newV->getInventories()[$i]->getExpireDate(), "inv_id", $inv_ids[$i - $invCountDiff]);

                        // Inventory quantity
                        $this->dbUpdate("inventories", "inv_quantity", $newV->getInventories()[$i]->getQuantity(), "inv_id", $inv_ids[$i - $invCountDiff]);

                    }
                } else if($invCountDiff == 0){ // Old inventory is same as new inventory
                    // Update current available data
                    for($i = 0; $i < sizeof($newV->getInventories()); $i++){

                        // Inventory expire date
                        $this->dbUpdate("inventories", "inv_expire_date", $newV->getInventories()[$i]->getExpireDate(), "inv_id", $inv_ids[$i]);

                        // Inventory quantity
                        $this->dbUpdate("inventories", "inv_quantity", $newV->getInventories()[$i]->getQuantity(), "inv_id", $inv_ids[$i]);

                    }
                }

            }

            // Add new variety
            foreach($barcodeToAdd as $b){

                // Get index of the new variety
                $index;
                for($i = 0; $i < sizeof($newItem->getVarieties()); $i++){
                    if($newItem->getVarieties()[$i]->getBarcode() == $b) $index = $i;
                }

                $variety = $newItem->getVarieties()[$index];

                // Insert into varieties
                $variety_ready = [$variety->getBarcode(), $variety->getProperty(), $variety->getPrice(), $variety->getWeight(), $variety->getDiscountRate(), $i_id];
                $this->dbInsert("varieties", $variety_ready);

                // Insert into inventories
                foreach($variety->getInventories() as $inventory){
                    $inventory_ready = [$variety->getBarcode(), $inventory->getExpireDate(), $inventory->getQuantity()];
                    $this->dbInsert("inventories", $inventory_ready);
                }

            }

        }

        return true;
    }

    public function deleteItem($item){
        $view = new View();
        $i_id = $view->getItemId($item);
        if($i_id == false) return false;

        if($this->dbDelete("items", "i_id", $i_id)){
            //Delete general image
            for($i = 0; $i < $item->getImgCount(); $i++){
                if(file_exists("../assets/images/items/$i_id/$i.jpg")){
                    unlink("../assets/images/items/$i_id/$i.jpg");
                }
            }

            //Delete Variety image
            for($i = 0; $i < sizeof($item->getVarieties()); $i++){
                if(file_exists("../assets/images/items/$i_id/" . $item->getVarieties()[$i]->getBarcode() . ".jpg")){
                    unlink("../assets/images/items/$i_id/" . $item->getVarieties()[$i]->getBarcode() . ".jpg");
                }
            }

            //Remove directory
            @rmdir("../assets/images/items/".$i_id."/");

            //Delete webpage
            if(file_exists("../items/" . $item->getName() . ".php")) unlink("../items/" . $item->getName() . ".php");
        } else{
            return false;
        }

        return true;
    }

    public function insertNewOrder($order){

        $order_ready = [$order->getOrderId(), $order->getDateTime(), $order->getPaymentMethod(), $order->getCart()->getNote(), $order->getCustomer()->getName(), $order->getCustomer()->getPhoneMMC(), $order->getCustomer()->getPhone(), $order->getCustomer()->getAddress(), $order->getCustomer()->getState(), $order->getCustomer()->getArea(), $order->getCustomer()->getPostalCode()];
        $this->dbInsert("orders", $order_ready);

        foreach($order->getCart()->getCartItems() as $cartItem){

            $order_items_ready = [$order->getOrderId(), $cartItem->getBarcode() , $cartItem->getQuantity()];
            $this->dbInsert("order_items", $order_items_ready);

            // Edit Inventory
            $this->editIventoryQuantity($cartItem->getBarcode(), $cartItem->getQuantity());

        }

    }

    private function editIventoryQuantity($barcode, $quantity){
        $dbTable_inventories = $this->dbSelectRow("inventories", "v_barcode", $barcode);

        $selected = 0;
        for($i = 0; $i < sizeof($dbTable_inventories) - 1; $i++){
            if($dbTable_inventories[$i]['inv_expire_date'] < $dbTable_inventories[$i + 1]['inv_expire_date']){
                $selected = $i;
            }
        }

        $this->dbUpdate("inventories", "inv_quantity", $dbTable_inventories[$selected]['inv_quantity'] - $quantity, ["v_barcode", "inv_expire_date"], [$barcode, $dbTable_inventories[$selected]['inv_expire_date']]);
    }

    public function checkUserPassword($username, $password){
        $results = $this->dbSelectRow("users", "user_name", $username);
        if(count($results) > 0 && password_verify($password, $results[0]["user_password"])){
            return true;
        }
        return false;
    }

    public function addViewCount($item){
        $this->dbUpdate("items", "i_view_count", $item->getViewCount() + 1, "i_name", $item->getName());
    }

    /*  Listing condition (attributes must present)
        1. Item: name, property name and at least one variety
        2. Variety: all attribute in Variety class and at least one inventory
        3. Inventory: quantity
        4. Category can be blank
     */
    public function list($itemName){

        $isFail = false;

        $view = new View();

        $dbTable_items = $this->dbSelectRow("items", "i_name", $itemName);
        if ($dbTable_items == null) die("上架失败<br>错误代码：Item is not in the database.");

        $i_id = $this->dbSelectAttribute("items", "i_id", "i_name", $itemName);
        $items = $view->toItemObjList($dbTable_items);
        $item = $items[0];

        $message_fail = "上架失败，请符合以下条件：\\n";

        // Check property name
        if($item->getPropertyName() == null){
            $message_fail = $message_fail . "规格名称不可为空\\n";
            $isFail = true;
        }

        // Check variety
        if(empty($item->getVarieties())){
            $message_fail = $message_fail . "请先添加至少一个规格\\n";
            $isFail = true;
        }
        else {
            for($i = 0; $i < sizeof($item->getVarieties()); $i++){

                if($item->getVarieties()[$i]->getProperty() == null){
                    $message_fail = $message_fail . "货号 " . $item->getVarieties()[$i]->getBarcode() . " 的规格选择不可为空！\\n";
                    $isFail = true;
                }

                if($item->getVarieties()[$i]->getPrice() == null){
                    $message_fail = $message_fail . "规格 " . $item->getVarieties()[$i]->getProperty() . " 的价钱不可为空！\\n";
                    $isFail = true;
                }

                if($item->getVarieties()[$i]->getWeight() == null){
                    $message_fail = $message_fail . "规格 " . $item->getVarieties()[$i]->getProperty() . " 的重量不可为空！\\n";
                    $isFail = true;
                }

                if(empty($item->getVarieties()[$i]->getInventories())){
                    $message_fail = $message_fail . "规格 " . $item->getVarieties()[$i]->getProperty() . " 的库存不可为空！\\n";
                    $isFail = true;
                }

            }
        }

        // Check cover image is existed
        if(!file_exists("../assets/images/items/$i_id/0.jpg") && $item->getImgCount() == 0){
            $message_fail = $message_fail . "请先上传封面照片！\\n";
            $isFail  = true;
        }

        if($isFail){
            $this->dbUpdate("items", "i_is_listed", 0, "i_id", $i_id);
            return $message_fail;
        } else{
            $this->dbUpdate("items", "i_is_listed", 1, "i_id", $i_id);
            return null;
        }

    }

    public function changeListStatus($itemName){
        if($this->dbSelectAttribute("items", "i_is_listed", "i_name", $itemName) == 1){
            $this->dbUpdate("items", "i_is_listed", 0, "i_name", $itemName);
            return true;
        } else{
            if($this->list($itemName) != null){
                return true;
            } else{
                return false;
            }
        }
    }

    public function updateDeliveryId($orderId, $deliveryId){
        $this->dbUpdate("orders", "o_delivery_id", $deliveryId, "o_id", $orderId);
    }






    /* Temporary function */
    public function registerAccount(){
        $this->dbInsert("users", ["ahming", password_hash("Ksm10072000", PASSWORD_BCRYPT)]);
    }

}

?>
