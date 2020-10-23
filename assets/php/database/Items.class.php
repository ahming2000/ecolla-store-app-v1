<?php

class Items extends Dbh{

    protected function insertItem($name, $catogory, $brand, $country, $imgPath){
        $sql = "INSERT INTO items(items_name, items_catogory, items_brand, items_country, items_imgPath) VALUE(?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$name, $catogory, $brand, $country, $imgPath]);
    }

    protected function getItemName($barcode){
        $sql = "SELECT items_name FROM items WHERE v_barcode = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$barcode]);

        $results = $stmt->fetchAll();
        return $result;
    }

    protected function updateItemName($barcode, $name){

        return $result;
    }
    

}

?>