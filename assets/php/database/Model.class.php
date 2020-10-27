<?php

require_once __DIR__."\\Dbh.class.php";

class Model extends Dbh{

    //Item
    protected function insertItem($name, $catogory, $brand, $country){
        $sql = "INSERT INTO items(i_name, i_catogory, i_brand, i_country) VALUE(?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$name, $catogory, $brand, $country]);
    }

    protected function selectAllItems($attrToSearch, $attrContentToSearch){
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
    protected function insertVariety($barcode, $property, $propertyType, $price, $weight, $weightUnit){
        $sql = "INSERT INTO varieties(v_barcode, v_property, v_propertyType, v_price, v_weight, v_weightUnit) VALUE(?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$barcode, $property, $propertyType, $price, $weight, $weightUnit]);
    }

    protected function selectAllVarieties($attrToSearch, $attrContentToSearch){
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

    protected function selectAllSpecifications($attrToSearch, $attrContentToSearch){
        $sql = "SELECT * FROM specifications WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrToSearch, $attrContentToSearch]);

        $results = $stmt->fetchAll();
        return $results;
    }

    protected function selectSpecificationAttr($attrToSelect, $attrToSearch, $attrContentToSearch){
        $sql = "SELECT ".$attrToSearch." FROM specifications WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrContentToSearch]);

        $results = $stmt->fetchAll();
        return $results[0][$attrToSearch];
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

    protected function selectAllItemImgs($attrToSearch, $attrContentToSearch){
        $sql = "SELECT * FROM item_imgs WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$attrToSearch, $attrContentToSearch]);

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

}

?>