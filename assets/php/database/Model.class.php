<?php

class Items extends Dbh{

    //Item
    protected function insertItem($name, $catogory, $brand, $country){
        $sql = "INSERT INTO items(items_name, items_catogory, items_brand, items_country) VALUE(?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$name, $catogory, $brand, $country]);
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

    protected function deleteItemAttr($attrToSearch, $attrContentToSearch){
        $sql = "DELETE FROM items WHERE ? = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrToSearch, $attrContentToSearch]);
    }

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

    protected function deleteVarietyAttr($attrToSearch, $attrContentToSearch){
        $sql = "DELETE FROM varieties WHERE ? = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrToSearch, $attrContentToSearch]);
    }

    //Specification
    protected function insertSpecification($s_id, $id, $barcode, $imgPath){
        $sql = "INSERT INTO specifications(s_id, i_id, v_barcode, s_imgPath) VALUE(?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id, $barcode]);
    }

    protected function selectAllSpecifications($attrToSearch, $attrContentToSearch){
        $sql = "SELECT * FROM specifications WHERE ? = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrToSearch, $attrContentToSearch]);

        $results = $stmt->fetchAll();
        return $result;
    }

    protected function selectSpecificationAttr($attrToSelect, $attrToSearch, $attrContentToSearch){
        $sql = "SELECT ? FROM specifications WHERE ? = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrToSelect, $attrToSearch, $attrContentToSearch]);

        $results = $stmt->fetchAll();
        return $result[0][$attrToSearch];
    }

    protected function updateSpecificationAttr($attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch){
        $sql = "UPDATE specifications SET ? = ? WHERE ? = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch]);
    }

    protected function deleteSpecificationAttr($attrToSearch, $attrContentToSearch){
        $sql = "DELETE FROM specifications WHERE ? = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrToSearch, $attrContentToSearch]);
    }

}

?>