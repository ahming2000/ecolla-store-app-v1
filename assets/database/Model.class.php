<?php

require_once __DIR__."\\Dbh.class.php";

class Model extends Dbh{

    //items
    protected function selectCount($tableName){
        $sql = "SELECT COUNT(*) AS num FROM ".$tableName;
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetch();
        return $results['num'];
    }

    protected function insertItem($name, $brand, $country, $isListed, $i_imgCount){
        $sql = "INSERT INTO items(i_name, i_brand, i_country, i_isListed, i_imgCount) VALUE(?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$name, $brand, $country, $isListed, $i_imgCount]);
    }

    protected function selectAllItems(){
        $sql = "SELECT * FROM items";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        return $results;
    }

    protected function selectItem($attrToSearch, $attrContentToSearch){
        $sql = "SELECT * FROM items WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);
        $results = $stmt->fetchAll();

        return $results;
    }

    protected function selectItemAttr($attrToSelect, $attrToSearch, $attrContentToSearch){
        $sql = "SELECT ".$attrToSelect." FROM items WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);

        $results = $stmt->fetchAll();
        return $results[0][$attrToSelect];
    }

    protected function updateItemAttr($attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch){
        $sql = "UPDATE items SET ".$attrToUpdate." = ? WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToUpdate, $attrContentToSearch]);
    }

    protected function deleteItemAttr($attrToSearch, $attrContentToSearch){
        $sql = "DELETE FROM items WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);
    }

    //varieties
    protected function insertVariety($barcode, $property, $propertyName, $price, $weight, $weightUnit, $discountRate){
        $sql = "INSERT INTO varieties(v_barcode, v_property, v_propertyType, v_price, v_weight, v_weightUnit, v_discountRate) VALUE(?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$barcode, $property, $propertyName, $price, $weight, $weightUnit, $discountRate]);
    }

    protected function selectAllVarieties(){
        $sql = "SELECT * FROM varieties";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        return $results;
    }

    protected function selectVariety($attrToSearch, $attrContentToSearch){
        $sql = "SELECT * FROM varieties WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);

        $results = $stmt->fetchAll();
        return $results;
    }

    protected function selectVarietyAttr($attrToSelect, $attrToSearch, $attrContentToSearch){
        $sql = "SELECT ".$attrToSelect." FROM varieties WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);

        $results = $stmt->fetchAll();
        return $results[0][$attrToSearch];
    }

    protected function updateVarietyAttr($attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch){
        if($attrToUpdate === "v_barcode"){
            die("Barcode only allow to delete, cannot modify!");
        }
        $sql = "UPDATE varieties SET ".$attrToUpdate." = ? WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToUpdate, $attrContentToSearch]);
    }

    protected function deleteVarietyAttr($attrToSearch, $attrContentToSearch){
        $sql = "DELETE FROM varieties WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);
    }

    //specifications
    protected function insertSpecification($v_barcode, $i_id){
        $sql = "INSERT INTO specifications(v_barcode, i_id) VALUE(?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$v_barcode, $i_id]);
    }

    protected function selectAllSpecifications(){
        $sql = "SELECT * FROM specifications";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        return $results;
    }

    protected function selectSpecification($attrToSearch, $attrContentToSearch){
        $sql = "SELECT * FROM specifications WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);

        $results = $stmt->fetchAll();
        return $results;
    }

    protected function selectSpecificationAttr($attrToSelect, $attrToSearch, $attrContentToSearch){
        $sql = "SELECT ".$attrToSelect." FROM specifications WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);

        $results = $stmt->fetchAll();
        return $results[0][$attrToSelect];
    }

    protected function updateSpecificationAttr($attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch){
        $sql = "UPDATE specifications SET ".$attrToUpdate." = ? WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToUpdate, $attrContentToSearch]);
    }

    protected function deleteSpecificationAttr($attrToSearch, $attrContentToSearch){
        $sql = "DELETE FROM specifications WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);
    }

    //shelf_life_list
    protected function insertShelfLife($v_barcode, $sll_expireDate, $sll_inventory){
        $sql = "INSERT INTO shelf_life_list(v_barcode, sll_expireDate, sll_inventory) VALUE(?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$v_barcode, $sll_expireDate, $sll_inventory]);
    }

    protected function selectAllShelfLife(){
        $sql = "SELECT * FROM shelf_life_list";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        return $results;
    }

    protected function selectShelfLife($attrToSearch, $attrContentToSearch){
        $sql = "SELECT * FROM shelf_life_list WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);
        $results = $stmt->fetchAll();

        return $results;
    }

    protected function selectShelfLifeAttr($attrToSelect, $attrToSearch, $attrContentToSearch){
        $sql = "SELECT ".$attrToSelect." FROM shelf_life_list WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);

        $results = $stmt->fetchAll();
        return $results[0][$attrToSelect];
    }

    protected function updateShelfLifeAttr($attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch){
        $sql = "UPDATE shelf_life_list SET ".$attrToUpdate." = ? WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToUpdate, $attrContentToSearch]);
    }

    protected function deleteShelfLifeAttr($attrToSearch, $attrContentToSearch){
        $sql = "DELETE FROM shelf_life_list WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);
    }

    //catogories
    protected function insertCatogory($id, $i_id, $catogory){
        $sql = "INSERT INTO catogories(cat_id, i_id, cat_name) VALUE(?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id, $i_id, $catogory]);
    }

    protected function selectAllCatogories(){
        $sql = "SELECT * FROM catogories";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        return $results;
    }

    protected function selectCatogory($attrToSearch, $attrContentToSearch){
        $sql = "SELECT * FROM catogories WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);
        $results = $stmt->fetchAll();

        return $results;
    }

    protected function selectCatogoryAttr($attrToSelect, $attrToSearch, $attrContentToSearch){
        $sql = "SELECT ".$attrToSelect." FROM catogories WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);

        $results = $stmt->fetchAll();
        return $results[0][$attrToSelect];
    }

    protected function updateCatogoryAttr($attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch){
        $sql = "UPDATE catogories SET ".$attrToUpdate." = ? WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToUpdate, $attrContentToSearch]);
    }

    protected function deleteCatogoryAttr($attrToSearch, $attrContentToSearch){
        $sql = "DELETE FROM catogories WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);
    }

    //Orders
    protected function insertOrder($o_item_count, $c_name, $c_phone, $c_address, $c_postcode, $c_city, $c_state, $c_receiptPath, $o_subtotal){
        $sql = "INSERT INTO orders(o_item_count, c_name, c_phone, c_address, c_postcode, c_city, c_state, c_receiptPath, o_subtotal) VALUE(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$o_item_count, $c_name, $c_phone, $c_address, $c_postcode, $c_city, $c_state, $c_receiptPath, $o_subtotal]);
    }

    protected function selectAllOrders(){
        $sql = "SELECT * FROM orders";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        return $results;
    }

    protected function selectOrder($attrToSearch, $attrContentToSearch){
        $sql = "SELECT * FROM orders WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);
        $results = $stmt->fetchAll();

        return $results;
    }

    protected function selectOrderAttr($attrToSelect, $attrToSearch, $attrContentToSearch){
        $sql = "SELECT ".$attrToSelect." FROM orders WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);

        $results = $stmt->fetchAll();
        return $results[0][$attrToSelect];
    }

    protected function updateOrderAttr($attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch){
        $sql = "UPDATE orders SET ".$attrToUpdate." = ? WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToUpdate, $attrContentToSearch]);
    }

    protected function deleteOrderAttr($attrToSearch, $attrContentToSearch){
        $sql = "DELETE FROM orders WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);
    }

    //Order items
    protected function insertOrderItem($o_id, $s_id, $quantity){
        $sql = "INSERT INTO order_items(o_id, s_id, quantity) VALUE(?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$o_id, $s_id, $quantity]);
    }

    protected function selectAllOrderItems(){
        $sql = "SELECT * FROM order_items";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        return $results;
    }

    protected function selectOrderItem($attrToSearch, $attrContentToSearch){
        $sql = "SELECT * FROM order_items WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);
        $results = $stmt->fetchAll();

        return $results;
    }

    protected function selectOrderItemAttr($attrToSelect, $attrToSearch, $attrContentToSearch){
        $sql = "SELECT ".$attrToSelect." FROM order_items WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);

        $results = $stmt->fetchAll();
        return $results[0][$attrToSelect];
    }

    protected function updateOrderItemAttr($attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch){
        $sql = "UPDATE order_items SET ".$attrToUpdate." = ? WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToUpdate, $attrContentToSearch]);
    }

    protected function deleteOrderItemAttr($attrToSearch, $attrContentToSearch){
        $sql = "DELETE FROM order_items WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);
    }

}

?>
