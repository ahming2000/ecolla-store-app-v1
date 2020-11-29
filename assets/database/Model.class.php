<?php

/*  MVC Model Version: v0.1.0-alpha (To be released)
 *  Created by AhMing
 *  Github: https://github.com/ahming2000
 *
 *  Changing Log:
 *  1. Now you can insert table with one function, less confusion on inserting table.
 *  2.
 */

require_once __DIR__."\\Dbh.class.php";

class Model extends Dbh{

    //To-do:
    // 1. Logging to file for every function
    // 2. Create dynamic way on declaring table attribute outside of this class





    /*  Database Table
        Notice: PLEASE DEFINE YOUR TABLE ATTRIBUTE OVER HERE!
    */
    private $DATABASE_TABLE = [

        "items" => [
            "columnsToInsert" => "items(i_name, i_brand, i_country, i_is_listed, i_image_count)",
            "columnsCountToInsert" => 5
        ],

        "varieties" => [
            "columnsToInsert" => "varieties(v_barcode, v_property, v_property_name, v_price, v_weight, v_weight_unit, v_discount_rate, i_id)",
            "columnsCountToInsert" => 8
        ],

        "catogories" => [
            "columnsToInsert" => "catogories(cat_name)",
            "columnsCountToInsert" => 1
        ],

        "inventories" => [
            "columnsToInsert" => "inventories(v_barcode, inv_expire_date, inv_quantity)",
            "columnsCountToInsert" => 3
        ],

        "classifications" => [
            "columnsToInsert" => "classifications(i_id, cat_id)",
            "columnsCountToInsert" => 2
        ],

        "orders" => [
            "columnsToInsert" => "orders(o_id, o_date_time, c_name, c_phone_mcc, c_phone, c_address, c_postcode, c_city, c_state)",
            "columnsCountToInsert" => 9
        ],

        "order_items" => [
            "columnsToInsert" => "order_items(o_id, v_barcode, oi_quantity, oi_note)",
            "columnsCountToInsert" => 4
        ],

        "ecolla_website_config" => [
            "columnsToInsert" => "ecolla_website_config(config_name, congif_value, config_info)",
            "columnsCountToInsert" => 3
        ]

    ];





    /*  Concat the symbol into a string

        Example:
        $primaryChar = '?'; $saperateWith = ', '; $count = 3;
        $output = ?, ?, ?
    */
    private function concatToStrChar($primaryChar, $saperateWith, $count){
        $str = "".$primaryChar;

        for($i = 1; $i < $count; $i++){
            $str = $str.$saperateWith.$primaryChar;
        }
        return $str;
    }





    /*  Connect multiple attribute with clause by using this function

        Example:
        $attrArray = ["i_name", "i_brand"]; $clause = "AND";
        $output = "i_name = ? AND i_brand = ?"
    */
    private function clauseConnector($attrArray, $clause){
        $str = $attrArray[0]." = ?";

        for($i = 1; $i < sizeof($attrArray); $i++){
            $str = $str." ".$clause." ".$attrArray[$i]." = ?";
        }
        return $str;
    }





    /*  Insert into database
        Syntax:
        dbInsert: INSERT INTO {table name} VALUE({number of '?' is equal to nnumber of column of the table})
    */
    protected function dbInsert($tableName, $data){
        $sql = "INSERT INTO ".$this->DATABASE_TABLE[$tableName]["columnsToInsert"]." VALUE(".$this->concatToStrChar('?', ', ', $this->DATABASE_TABLE[$tableName]["columnsCountToInsert"]).")";
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute($data)) die("Database inserting ".$tableName." error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
    }





    /*  Select from database
        Syntax:
        dbSelectAll: SELECT * FROM {table name}
        dbSelectRow: SELECT * FROM {table name} WHERE {attribute to search} = {attribute content to search}
        dbSelectColumn: SELECT {attribute to select} FRM {table name} WHERE {attribute to search} = {attribute content to search}
        dbSelectAttribute: SELECT {attribute to select} FROM {table name} WHERE {attribute to search} = {attribute content to search}
        dbSelectRow_MultiSearch: SELECT * FROM {table name} WHERE {first attribute to search} = {first attribute content to search} AND {second attribute to search} = {second attribute content to search} ...
        dbSelectColumn_MultiSearch: SELECT {attribute to select} FRM {table name} WHERE {first attribute to search} = {first attribute content to search} AND {second attribute to search} = {second attribute content to search} ...
        dbSelectAttribute_MultiSearch: SELECT {attribute to select} FROM {table name} WHERE {first attribute to search} = {first attribute content to search} AND {second attribute to search} = {second attribute content to search} ...
        dbSelectCount: SELECT COUNT(*) FROM {table name}
        dbSelectAttributeCount: SELECT COUNT(*) FROM {table name} WHERE {attribute to search} = {attribute content to search}
        dbSelectAttributeCount_MultiSearch: SELECT COUNT(*) FROM {table name} WHERE {first attribute to search} = {first attribute content to search} AND {second attribute to search} = {second attribute content to search} ...

        Output: (To retrive the cell data)
        dbSelectAll: data[row(number)][column(column name)]
        dbSelectRow: data[row(number)][column(column name)]
        dbSelectColumn: data[column(column name)]
        dbSelectAttribute: data (Auto use the first result as the main result)
        dbSelectRow_MultiSearch: data[row(number)][column(column name)]
        dbSelectColumn_MultiSearch: data[column(column name)]
        dbSelectAttribute_MultiSearch: data (Auto use the first result as the main result)
        dbSelectCount: data count
        dbSelectAttributeCount: data count
        dbSelectAttributeCount_MultiSearch: data count

        Coming soon:
        1. Select function with clause ORDER BY
        2. Select function with combined table
    */
    protected function dbSelectAll($tableName){
        $sql = "SELECT * FROM ".$tableName;
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute()) die("Database selecting ".$tableName." error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function dbSelectRow($tableName, $attrToSearch, $attrContentToSearch){
        $sql = "SELECT * FROM ".$tableName." WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute([$attrContentToSearch])) die("Database selecting ".$tableName." error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function dbSelectColumn($tableName, $attrToSelect, $attrToSearch, $attrContentToSearch){
        $sql = "SELECT ".$attrToSelect." FROM ".$tableName." WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute([$attrContentToSearch])) die("Database selecting ".$tableName." error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetchAll();
        $columns = array();
        foreach($results as $row){
            array_push($columns, $row[$attrToSelect]);
        }
        return $columns;
    }

    protected function dbSelectAttribute($tableName, $attrToSelect, $attrToSearch, $attrContentToSearch){
        $sql = "SELECT ".$attrToSelect." FROM ".$tableName." WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute([$attrContentToSearch])) die("Database selecting ".$tableName." error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetchAll();
        return $results[0][$attrToSelect];
    }

    protected function dbSelectRow_MultiSearch($tableName, $attrToSearchList, $attrContentToSearchList){
        if(sizeof($attrToSearchList) !== sizeof($attrContentToSearchList)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
        $sql = "SELECT * FROM ".$tableName." WHERE ".$this->clauseConnector($attrToSearchList, "AND");
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute($attrContentToSearchList)) die("Database selecting ".$tableName." error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function dbSelectColumn_MultiSearch($tableName, $attrToSelect, $attrToSearchList, $attrContentToSearchList){
        if(sizeof($attrToSearchList) !== sizeof($attrContentToSearchList)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
        $sql = "SELECT ".$attrToSelect." FROM ".$tableName." WHERE ".$this->clauseConnector($attrToSearchList, "AND");
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute($attrContentToSearchList)) die("Database selecting ".$tableName." error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetchAll();
        $columns = array();
        foreach($results as $row){
            array_push($columns, $row[$attrToSelect]);
        }
        return $columns;
    }

    protected function dbSelectAttribute_MultiSearch($tableName, $attrToSelect, $attrToSearchList, $attrContentToSearchList){
        if(sizeof($attrToSearchList) !== sizeof($attrContentToSearchList)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
        $sql = "SELECT ".$attrToSelect." FROM ".$tableName." WHERE ".$this->clauseConnector($attrToSearchList, "AND");
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute($attrContentToSearchList)) die("Database selecting ".$tableName." error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetchAll();
        return $results[0][$attrToSelect];
    }

    protected function dbSelectCount($tableName){
        $sql = "SELECT COUNT(*) AS count FROM ".$tableName;
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute()) die("Database selecting ".$tableName." error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetch();
        return $results['count'];
    }

    protected function dbSelectAttributeCount($tableName, $attrToSearch, $attrContentToSearch){
        $sql = "SELECT COUNT(*) AS count FROM ".$tableName." WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute([$attrContentToSearch])) die("Database selecting ".$tableName." error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetch();
        return $results['count'];
    }

    protected function dbSelectAttributeCount_MultiSearch($tableName, $attrToSearchList, $attrContentToSearchList){
        if(sizeof($attrToSearchList) !== sizeof($attrContentToSearchList)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
        $sql = "SELECT COUNT(*) AS count FROM ".$tableName." WHERE ".$this->clauseConnector($attrToSearchList, "AND");
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute($attrContentToSearchList)) die("Database selecting ".$tableName." error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetch();
        return $results['count'];
    }





    /*  Update database
        Syntax:
        dbUpdate: UPDATE {table name} SET {attribute to update} = {attribute content to update} WHERE {attribute to search} = {attribute content to search}
    */
    protected function dbUpdate($tableName, $attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch){
        $sql = "UPDATE ".$tableName." SET ".$attrToUpdate." = ? WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute([$attrContentToUpdate, $attrContentToSearch])) die("Database updating ".$tableName." error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
    }





    /*  MVC Model Version: v0.0.0-alpha
     *  Old version code will remain until all codes are tested perfectly
     */

    //items
    protected function selectCount($tableName){
        $sql = "SELECT COUNT(*) AS num FROM ".$tableName;
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetch();
        return $results['num'];
    }

    protected function insertItem($name, $brand, $country, $isListed, $i_imgCount){
        $sql = "INSERT INTO items(i_name, i_brand, i_country, i_isListed, i_imgCount) VALUE(?, ?, ?, ?, ?)";
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
        $sql = "INSERT INTO varieties(v_barcode, v_property, v_propertyName, v_price, v_weight, v_weightUnit, v_discountRate) VALUE(?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute([$barcode, $property, $propertyName, $price, $weight, $weightUnit, $discountRate])) var_dump($stmt->errorInfo());
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
        try{
            $sql = "INSERT INTO shelf_life_list(v_barcode, sll_expireDate, sll_inventory) VALUE(?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            if(!$stmt->execute([$v_barcode, $sll_expireDate, $sll_inventory])) var_dump($stmt->errorInfo());
        }
        catch ( PDOException $exception )
        {
            die("PDO error :" . $exception->getMessage());
        }
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
    protected function insertCatogory($i_id, $catogory){
        $sql = "INSERT INTO catogories(i_id, cat_name) VALUE(?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$i_id, $catogory]);
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
    protected function insertOrder($o_date_time, $o_item_count, $c_name, $c_phone, $c_address, $c_postcode, $c_city, $c_state, $c_receiptPath, $o_subtotal){
        $sql = "INSERT INTO orders(o_date_time, o_item_count, c_name, c_phone, c_address, c_postcode, c_city, c_state, c_receiptPath, o_subtotal) VALUE(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        if (!$stmt->execute([$o_date_time, $o_item_count, $c_name, $c_phone, $c_address, $c_postcode, $c_city, $c_state, $c_receiptPath, $o_subtotal])) var_dump($stmt->errorInfo());
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
    protected function insertOrderItem($o_date_time, $s_id, $quantity){
        $sql = "INSERT INTO order_items(o_date_time, s_id, quantity) VALUE(?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$o_date_time, $s_id, $quantity]);
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
