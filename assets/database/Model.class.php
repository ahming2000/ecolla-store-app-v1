<?php

require_once __DIR__."\\Dbh.class.php";

class Model extends Dbh{

    //Item

    protected function selectCount($tableName){
        $sql = "SELECT COUNT(*) AS num FROM ".$tableName;
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetch();
        return $results['num'];
    }

    protected function insertItem($name, $catogory, $brand, $country, $isListed){
        $sql = "INSERT INTO items(i_name, i_catogory, i_brand, i_country, i_isListed) VALUE(?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$name, $catogory, $brand, $country, $isListed]);
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

    //Variety
    protected function insertVariety($barcode, $property, $propertyType, $price, $weight, $weightUnit, $inventory, $discountRate){
        $sql = "INSERT INTO varieties(v_barcode, v_property, v_propertyType, v_price, v_weight, v_weightUnit, v_inventory, v_discountRate) VALUE(?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$barcode, $property, $propertyType, $price, $weight, $weightUnit, $inventory, $discountRate]);
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

    //Specification
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

    //ItemImg
    protected function insertItemImg($i_id, $imgPath){
        $sql = "INSERT INTO item_imgs(i_id, imgPath) VALUE(?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$i_id, $imgPath]);
    }

    protected function selectAllItemImgs(){
        $sql = "SELECT * FROM item_imgs";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        return $results;
    }

    protected function selectItemImg($attrToSearch, $attrContentToSearch){
        $sql = "SELECT * FROM item_imgs WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);

        $results = $stmt->fetchAll();
        return $results;
    }

    protected function selectItemImgAttr($attrToSelect, $attrToSearch, $attrContentToSearch){
        $sql = "SELECT ".$attrToSelect." FROM item_imgs WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);

        $results = $stmt->fetchAll();
        return $results[0][$attrToSearch];
    }

    protected function updateItemImgAttr($attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch){
        $sql = "UPDATE item_imgs SET ".$attrToUpdate." = ? WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToUpdate, $attrContentToSearch]);
    }

    protected function deleteItemImgAttr($attrToSearch, $attrContentToSearch){
        $sql = "DELETE FROM item_imgs WHERE ".$attrToSearch." = ?";
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
