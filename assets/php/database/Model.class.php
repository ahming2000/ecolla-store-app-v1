<?php

class Items extends Dbh{

    //Variety
    protected function insertVariety($barcode, $property, $propertyType, $price, $weight, $weightUnit){
        $sql = "INSERT INTO varieties(v_barcode, v_property, v_propertyType, v_price, v_weight, v_weightUnit) VALUE(?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$barcode, $property, $propertyType, $price, $weight, $weightUnit]);
    }

    protected function selectAllVarieties($attrToSearch, $attrContentToSearch){
        $sql = "SELECT * FROM varieties WHERE ? = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrToSearch, $attrContentToSearch]);

        $results = $stmt->fetchAll();
        return $result;
    }

    protected function selectVarietyAttr($attrToSelect, $attrToSearch, $attrContentToSearch){
        $sql = "SELECT ? FROM varieties WHERE ? = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrToSelect, $attrToSearch, $attrContentToSearch]);

        $results = $stmt->fetchAll();
        return $result[0][$attrToSearch];
    }

    protected function updateVarietyAttr($attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch){
        $sql = "UPDATE varieties SET ? = ? WHERE ? = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch]);
    }

    //Item
    protected function insertItem($name, $catogory, $brand, $country, $imgPath){
        $sql = "INSERT INTO items(items_name, items_catogory, items_brand, items_country, items_imgPath) VALUE(?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$name, $catogory, $brand, $country, $imgPath]);
    }

    protected function selectAllItems($attrToSearch, $attrContentToSearch){
        $sql = "SELECT * FROM items WHERE ? = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrToSearch, $attrContentToSearch]);

        $results = $stmt->fetchAll();
        return $result;
    }

    protected function selectItemAttr($attrToSelect, $attrToSearch, $attrContentToSearch){
        $sql = "SELECT ? FROM items WHERE ? = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrToSelect, $attrToSearch, $attrContentToSearch]);

        $results = $stmt->fetchAll();
        return $result[0][$attrToSearch];
    }

    protected function updateItemAttr($attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch){
        $sql = "UPDATE items SET ? = ? WHERE ? = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch]);
    }

    //Item Group
    protected function insertItemGroup($id, $barcode){
        $sql = "INSERT INTO items_groups(items_id, v_barcode) VALUE(?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id, $barcode]);
    }

    protected function selectAllItemGroups($attrToSearch, $attrContentToSearch){
        $sql = "SELECT * FROM items_groups WHERE ? = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrToSearch, $attrContentToSearch]);

        $results = $stmt->fetchAll();
        return $result;
    }

    protected function selectItemGroupAttr($attrToSelect, $attrToSearch, $attrContentToSearch){
        $sql = "SELECT ? FROM items_groups WHERE ? = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrToSelect, $attrToSearch, $attrContentToSearch]);

        $results = $stmt->fetchAll();
        return $result[0][$attrToSearch];
    }

    protected function updateItemGroupAttr($attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch){
        $sql = "UPDATE varieties SET ? = ? WHERE ? = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch]);
    }

}

?>