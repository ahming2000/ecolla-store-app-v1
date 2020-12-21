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
        if($this->dbSelectRow("items", ["i_name", "i_brand"], [$item->getName(), $item->getBrand()]) != null) return false;

        // Insert priority: items > categories > classifications > varieties > inventories

        // Insert into items table first to get item id generated by database
        $item_ready = [$item->getName(), $item->getDescription(), $item->getBrand(), $item->getOrigin(), $item->getPropertyName() , $item->getImgCount()];
        $this->dbInsert("items", $item_ready);

        // Get item id from database
        $view = new View();
        $i_id = $view->getItemId($item);


        foreach($item->getCatogories() as $category){

            // Get category id from database
            // Query: SELECT cat_id FROM categories WHERE cat_name = ?
            $cat_id = $this->dbSelectAttribute("categories", "cat_id", "cat_name", $category);

            // Insert the category if it does not exist in the database
            if($cat_id == null){
                // Insert into categories
                $category_ready = [$category];
                $this->dbInsert("categories", $category_ready);

                // Get category id from database
                // Query: SELECT cat_id FROM categories WHERE cat_name = ?
                $cat_id = $this->dbSelectAttribute("categories", "cat_id", "cat_name", $category);
            }

            // Insert into classifications
            $classification_ready = [$i_id, $cat_id];
            $this->dbInsert("classifications", $classification_ready);
        }

        // Insert into varieties
        foreach($item->getVarieties() as $variety){
            $variety_ready = [$variety->getBarcode(), $variety->getProperty(), $variety->getPrice(), $variety->getWeight(), $variety->getDiscountRate(), $i_id];
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
        $view = new View();
        $i_id = $view->getItemId($item);
        if($i_id == false) return false;

        if($this->dbDelete_MultiSearch("items", ["i_name", "i_brand"], [$item->getName(), $item->getBrand()])){
            //Delete general image
            for($i = 0; $i < $item->getImgCount(); $i++){
                if(file_exists("../assets/images/items/".$i_id."/".$i.".jpg")){
                    unlink("../assets/images/items/".$i_id."/".$i.".jpg");
                }
            }

            //Delete Variety image
            for($i = 0; $i < sizeof($item->getVarieties()); $i++){
                if(file_exists("../assets/images/items/".$i_id."/".$item->getVarieties()[$i]->getBarcode().".jpg")){
                    unlink("../assets/images/items/".$i_id."/".$item->getVarieties()[$i]->getBarcode().".jpg");
                }
            }

            //Remove directory
            //rmdir("../assets/images/items/".$i_id."/");

            //Delete webpage
            if(file_exists("../items/".$item->getBrand()."-".$item->getName().".php")) unlink("../items/".$item->getBrand()."-".$item->getName().".php");
        } else{
            return false;
        }

        return true;
    }






    public function insertNewOrder($order){ //$order

        $order_ready = [$order->getOrderId(), $order->getDateTime(), $order->getPaymentMethod(), $order->getCart()->getNote(), $order->getCustomer()->getName(), $order->getCustomer()->getPhoneMMC(), $order->getCustomer()->getPhone(), $order->getCustomer()->getAddress(), $order->getCustomer()->getState(), $order->getCustomer()->getArea(), $order->getCustomer()->getPostalCode()];
        $this->dbInsert("orders", $order_ready);

        foreach($order->getCart()->getCartItems() as $cartItem){

            $order_items_ready = [$order->getOrderId(), $cartItem->getBarcode() , $cartItem->getQuantity(), $cartItem->getNote()];
            $this->dbInsert("order_items", $order_items_ready);

            // Edit Inventory
            $this->editIventoryQuantity($cartItem->getBarcode(), $cartItem->getQuantity);

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

        $this->dbUpdate("inventories", "inv_quantity", $dbTable_inventories[$selected]['inv_quantity'] - $quantity, "v_barcode", $barcode);
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

    public function addViewCount($item){
        $this->dbUpdate("items", "i_view_count", $item->getViewCount() + 1, ["i_name", "i_brand"], [$item->getName(), $item->getBrand()]);
    }

    public function changeListStatus($itemName, $itemBrand){

        $isFail = false;

        $dbTable_items = $this->dbSelectRow("items", ["i_name", "i_brand"], [$itemName, $itemBrand]);
        $i_id = $dbTable_items[0]['i_id'];
        $view = new View();
        $items = $view->toItemObjList($dbTable_items);
        $item = $items[0];

        $message_fail = "上传失败，请符合以下条件：\\n";
        $message_success = "上架/下架成功！";

        //print_r($item);die();
        if($item->isListed() == 0) {
            // Check variety information is completed
            if(sizeof($item->getVarieties()) == 0){
                $message_fail = $message_fail . "请先添加至少一个规格！\\n";
            } else{
                $i = 1;
                foreach($item->getVarieties() as $variety){
                    if($variety->getBarcode() == ""){
                        $message_fail = $message_fail . "请添加规格 $i 的商品货号！\\n";
                        $isFail = true;
                    } else{
                        if($variety->getProperty() == ""){
                            $message_fail = $message_fail . "货号 " . $variety->getBarcode() . " 的规格选择不可为空！\\n";
                            $isFail = true;
                        }

                        if($variety->getPropertyName() == "") {
                            $message_fail = $message_fail . "货号 " . $variety->getBarcode() . " 的规格名称不可为空！\\n";
                            $isFail = true;
                        }

                        if($variety->getPrice() == "") {
                            $message_fail = $message_fail . "货号 " . $variety->getBarcode() . " 的规格价钱不可为空！\\n";
                            $isFail = true;
                        }

                        if($variety->getWeight() == "") {
                            $message_fail = $message_fail . "货号 " . $variety->getBarcode() . " 的规格重量不可为空！\\n";
                            $isFail = true;
                        }

                        if(sizeof($item->getVarieties()) == 0){
                            $message_fail = $message_fail . "货号 " . $variety->getBarcode() . "：请添加至少一个库存！\\n";
                            $isFail = true;
                        } else{
                            $j = 0;
                            foreach($variety->getInventories() as $inventory){
                                if($inventory->getExpireDate() == ""){
                                    $message_fail = $message_fail . "货号 " . $variety->getBarcode() . " 的库存 $j 的过期日期不可为空！\\n";
                                    $isFail = true;
                                }
                            }
                            $j++;
                        }
                    }
                    $i++;
                }
            }


            // Check inventory information is completed

            // Check cover image is existed
            if(!file_exists("../assets/images/items/$i_id/0.jpg" && $item->getImgCount() == 0)){
                $message_fail = $message_fail . "请先上传封面照片！";
                $isFail  = true;
            }

        }

        // Approve to list or unlist
        if($isFail){
            UsefulFunction::generateAlert($message_fail);
        } else{
            // To-do: generate new webpage (replace)
            $this->dbUpdate("items", "i_is_listed", $item->isListed() ? 0 : 1, "i_id", $i_id);
            UsefulFunction::generateAlert($message_success);
        }

    }

    public function initializeItem($itemName){
        $item_ready = [$itemName, "", "", "", "", "", 0];

        // Check is duplicate
        $dbTable_items = $this->dbSelectColumnAttribute("items", "i_name", "");

        if(!$this->dbInsert("items", $item_ready)){

        }
    }


}

?>
