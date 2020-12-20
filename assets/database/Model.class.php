<?php

/*  MVC Model Version: v0.1.1-alpha (To be released)
 *  Created by AhMing
 *  Github: https://github.com/ahming2000
 *
 *  Changing Log:
 *  v0.1.0-alpha
 *  Now you can insert table with one function, less confusion on inserting table.
 *
 *  v0.1.1-alpha
 *  Select column function may cause error when null value (not found) is selected, respond on null value with return false to ignore the error.
 *
 *  v0.1.2-alpha
 *  Multiple Search function now combine with the single search function, it will auto detect array
 *
 *  v0.2.0-alpha (Upcoming)
 *  Joined table function added.
 *
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
            "columnsToInsert" => "items(i_name, i_desc, i_brand, i_origin, i_property_name, i_image_count)",
            "columnsCountToInsert" => 6
        ],

        "varieties" => [
            "columnsToInsert" => "varieties(v_barcode, v_property, v_price, v_weight, v_discount_rate, i_id)",
            "columnsCountToInsert" => 6
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
            "columnsToInsert" => "orders(o_id, o_date_time, o_payment_method, o_note, c_name, c_phone_mcc, c_phone, c_address, c_state, c_area, c_postal_code)",
            "columnsCountToInsert" => 11
        ],

        "order_items" => [
            "columnsToInsert" => "order_items(o_id, v_barcode, oi_quantity, oi_note)",
            "columnsCountToInsert" => 4
        ],

        "users" => [
            "columnsToInsert" => "users(user_name, user_password)",
            "columnsCountToInsert" => 2
        ]

    ];





    /*  Concat the symbol into a string

        Example:
        $primaryChar = '?'; $saperateWith = ', '; $count = 3;
        $output = ?, ?, ?
    */
    private function concatToStrChar($primaryChar, $saperateWith, $count){
        $str = "$primaryChar";

        for($i = 1; $i < $count; $i++){
            $str = $str . $saperateWith . $primaryChar;
        }
        return $str;
    }





    /*  Connect multiple attribute with clause by using this function

        Example:
        $attrArray = ["i_name", "i_brand"]; $clause = "AND";
        $output = "i_name = ? AND i_brand = ?"
    */
    private function clauseConnector($attrArray, $clause){
        $str = $attrArray[0] . " = ?";

        for($i = 1; $i < sizeof($attrArray); $i++){
            $str = $str . " " . $clause . " " . $attrArray[$i] . " = ?";
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
        if(!$stmt->execute($data)) die("Database inserting $tableName error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
    }





    /*  Select from database
        Syntax:
        dbSelectAll: SELECT * FROM {table name}
        dbSelectRange: SELECT * FROM {table name} LIMIT {start from}, {how many times/range}
        dbSelectRow: SELECT * FROM {table name} WHERE {attribute to search} = {attribute content to search}
        dbSelectColumn: SELECT {attribute to select} FRM {table name} WHERE {attribute to search} = {attribute content to search}
        dbSelectAttribute: SELECT {attribute to select} FROM {table name} WHERE {attribute to search} = {attribute content to search}
        dbSelectCount: SELECT COUNT(*) FROM {table name}
        dbSelectAttributeCount: SELECT COUNT(*) FROM {table name} WHERE {attribute to search} = {attribute content to search}
        dbSelectAttributeCount_MultiSearch: SELECT COUNT(*) FROM {table name} WHERE {first attribute to search} = {first attribute content to search} AND {second attribute to search} = {second attribute content to search} ...

        Output: (To retrive the cell data)
        dbSelectAll: data[row(number)][column(column name)]
        dbSelectRange: data[row(number)][column(column name)]
        dbSelectRow: data[row(number)][column(column name)]
        dbSelectColumn: data[column(column name)]
        dbSelectAttribute: data (Auto use the first result as the main result) (Return false when not found)
        dbSelectCount: data count
        dbSelectAttributeCount: data count
        dbSelectAttributeCount_MultiSearch: data count

        Coming soon:
        1. Select function with clause ORDER BY
        2. Select function with combined table (WIP)
    */
    protected function dbSelectAll($tableName){
        $sql = "SELECT * FROM ".$tableName;
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute()) die("Database selecting $tableName error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function dbSelectAllRange($tableName, $start, $range){
        $sql = "SELECT * FROM $tableName LIMIT ".$start.", ".$range;
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute()) die("Database selecting $tableName error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function dbSelectRow($tableName, $attrToSearch, $attrContentToSearch){
        // Check is multiple search or not
        if(is_array($attrToSearch) or is_array($attrContentToSearch)){
            // Make number of attribute and number of content are the same
            if(sizeof($attrToSearch) !== sizeof($attrContentToSearch)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
            $sql = "SELECT * FROM $tableName WHERE " . $this->clauseConnector($attrToSearch, "AND");
        } else {
            $sql = "SELECT * FROM $tableName WHERE $attrToSearch = ?";
        }

        $stmt = $this->connect()->prepare($sql);

        //  Follow the mysql syntax
        if(!$stmt->execute(is_array($attrContentToSearch) ? $attrContentToSearch : [$attrContentToSearch])) die("Database selecting $tableName error. MySQL error message: " . $stmt->errorInfo()[2] . "<br>");

        $results = $stmt->fetchAll();
        return $results;
    }

    protected function dbSelectRowRange($tableName, $attrToSearch, $attrContentToSearch, $start, $range){
        // Check is multiple search or not
        if(is_array($attrToSearch) or is_array($attrContentToSearch)){
            // Make number of attribute and number of content are the same
            if(sizeof($attrToSearch) !== sizeof($attrContentToSearch)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
            $sql = "SELECT * FROM $tableName WHERE " . $this->clauseConnector($attrToSearch, "AND") . " LIMIT $start, $range";
        } else {
            $sql = "SELECT * FROM $tableName WHERE $attrToSearch = ? LIMIT $start, $range";
        }

        $stmt = $this->connect()->prepare($sql);

        //  Follow the mysql syntax
        if(!$stmt->execute(is_array($attrContentToSearch) ? $attrContentToSearch : [$attrContentToSearch])) die("Database selecting $tableName error. MySQL error message: " . $stmt->errorInfo()[2] . "<br>");

        $results = $stmt->fetchAll();
        return $results;
    }

    protected function dbSelectColumn($tableName, $attrToSelect, $attrToSearch, $attrContentToSearch){
        // Check is multiple search or not
        if(is_array($attrToSearch) or is_array($attrContentToSearch)){
            // Make number of attribute and number of content are the same
            if(sizeof($attrToSearch) !== sizeof($attrContentToSearch)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
            $sql = "SELECT $attrToSelect FROM $tableName WHERE " . $this->clauseConnector($attrToSearch, "AND");
        } else {
            $sql = "SELECT $attrToSelect FROM $tableName WHERE $attrToSearch = ?";
        }

        $stmt = $this->connect()->prepare($sql);

        //  Follow the mysql syntax
        if(!$stmt->execute(is_array($attrContentToSearch) ? $attrContentToSearch : [$attrContentToSearch])) die("Database selecting $tableName error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");

        $results = $stmt->fetchAll();

        // Convert value into ordered array
        $columns = array();
        foreach($results as $row){
            array_push($columns, $row[$attrToSelect]);
        }
        return $columns;
    }

    protected function dbSelectAttribute($tableName, $attrToSelect, $attrToSearch, $attrContentToSearch){
        // Check is multiple search or not
        if(is_array($attrToSearch) or is_array($attrContentToSearch)){
            // Make number of attribute and number of content are the same
            if(sizeof($attrToSearch) !== sizeof($attrContentToSearch)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
            $sql = "SELECT $attrToSelect FROM $tableName WHERE " . $this->clauseConnector($attrToSearch, "AND");
        } else {
            $sql = "SELECT $attrToSelect FROM $tableName WHERE $attrToSearch = ?";
        }

        $stmt = $this->connect()->prepare($sql);

        //  Follow the mysql syntax
        if(!$stmt->execute(is_array($attrContentToSearch) ? $attrContentToSearch : [$attrContentToSearch])) die("Database selecting $tableName error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");

        $results = $stmt->fetchAll();

        // If nothing is found, directly return null to avoid array indexing error
        if($results != null) return $results[0][$attrToSelect];
        else return null;
    }

    protected function dbSelectAllRange_JoinTable($tableNameA, $tableNameB, $tableNameC, $foreignKeyAB, $foreignKeyBC, $attrToSearch, $attrContentToSearch, $start, $range){
        // Check is multiple search or not
        if(is_array($attrToSearch) or is_array($attrContentToSearch)){
            // Make number of attribute and number of content are the same
            if(sizeof($attrToSearch) !== sizeof($attrContentToSearch)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
            $sql = "SELECT * FROM $tableNameA a, $tableNameB b, $tableNameC c WHERE a.$foreignKeyAB = b.$foreignKeyAB AND b.$foreignKeyBC = c.$foreignKeyBC AND " . $this->clauseConnector($attrToSearch, "AND") . " LIMIT $start, $range";
        } else {
            $sql = "SELECT * FROM $tableNameA a, $tableNameB b, $tableNameC c WHERE a.$foreignKeyAB = b.$foreignKeyAB AND b.$foreignKeyBC = c.$foreignKeyBC AND $attrToSearch = ? LIMIT $start, $range";
        }

        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute(is_array($attrContentToSearch) ? $attrContentToSearch : [$attrContentToSearch])) die("Database selecting ".$tableNameA." or ".$tableNameB." error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function dbSelectRow_JoinTable($tableNameMain, $tableNameA, $tableNameB, $foreignKeyFromTableA, $foreignKeyFromTableB, $attrToSelect, $attrToSearch, $attrContentToSearch){
        // Check is multiple search or not
        if(is_array($attrToSearch) or is_array($attrContentToSearch)){
            // Make number of attribute and number of content are the same
            if(sizeof($attrToSearch) !== sizeof($attrContentToSearch)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
            $sql = "SELECT $attrToSelect FROM $tableNameMain JOIN ($tableNameA, $tableNameB) USING ($foreignKeyFromTableA, $foreignKeyFromTableB) WHERE " . $this->clauseConnector($attrToSearch, "AND");
        } else {
            $sql = "SELECT $attrToSelect FROM $tableNameMain JOIN ($tableNameA, $tableNameB) USING ($foreignKeyFromTableA, $foreignKeyFromTableB) WHERE $attrToSearch = ?";
        }

        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute(is_array($attrContentToSearch) ? $attrContentToSearch : [$attrContentToSearch])) die("Database selecting ".$tableNameA." or ".$tableNameB." error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function dbSelectRow_JoinTable_Modern($tableNameA, $tableNameB, $tableNameC, $foreignKeyAB, $foreignKeyBC, $attrToSelect, $attrToSearch, $attrContentToSearch){
        // Check is multiple search or not
        if(is_array($attrToSearch) or is_array($attrContentToSearch)){
            // Make number of attribute and number of content are the same
            if(sizeof($attrToSearch) !== sizeof($attrContentToSearch)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
            $sql = "SELECT $attrToSelect FROM $tableNameA a, $tableNameB b, $tableNameC c WHERE a.$foreignKeyAB = b.$foreignKeyAB AND b.$foreignKeyBC = c.$foreignKeyBC AND " . $this->clauseConnector($attrToSearch, "AND");
        } else {
            $sql = "SELECT $attrToSelect FROM $tableNameA a, $tableNameB b, $tableNameC c WHERE a.$foreignKeyAB = b.$foreignKeyAB AND b.$foreignKeyBC = c.$foreignKeyBC AND $attrToSearch = ?";
        }

        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute(is_array($attrContentToSearch) ? $attrContentToSearch : [$attrContentToSearch])) die("Database selecting ".$tableNameA." or ".$tableNameB." error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function dbSelectRowRange_JoinTable($tableNameA, $tableNameB, $tableNameC, $foreignKeyAB, $foreignKeyBC, $attrToSelect, $attrToSearch, $attrContentToSearch, $start, $range){
        // Check is multiple search or not
        if(is_array($attrToSearch) or is_array($attrContentToSearch)){
            // Make number of attribute and number of content are the same
            if(sizeof($attrToSearch) !== sizeof($attrContentToSearch)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
            $sql = "SELECT $attrToSelect FROM $tableNameA a, $tableNameB b, $tableNameC c WHERE a.$foreignKeyAB = b.$foreignKeyAB AND b.$foreignKeyBC = c.$foreignKeyBC AND " . $this->clauseConnector($attrToSearch, "AND") . " LIMIT $start, $range";
        } else {
            $sql = "SELECT $attrToSelect FROM $tableNameA a, $tableNameB b, $tableNameC c WHERE a.$foreignKeyAB = b.$foreignKeyAB AND b.$foreignKeyBC = c.$foreignKeyBC AND $attrToSearch = ? LIMIT $start, $range";
        }

        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute(is_array($attrContentToSearch) ? $attrContentToSearch : [$attrContentToSearch])) die("Database selecting ".$tableNameA." or ".$tableNameB." error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function dbSelectCount($tableName){
        $sql = "SELECT COUNT(*) AS count FROM ".$tableName;
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute()) die("Database selecting $tableName error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetch();
        return $results['count'];
    }

    protected function dbSelectAttributeCount($tableName, $attrToSearch, $attrContentToSearch){
        // Check is multiple search or not
        if(is_array($attrToSearch) or is_array($attrContentToSearch)){
            // Make number of attribute and number of content are the same
            if(sizeof($attrToSearch) !== sizeof($attrContentToSearch)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
            $sql = "SELECT COUNT(*) AS count FROM $tableName WHERE " . $this->clauseConnector($attrToSearch, "AND");
        } else {
            $sql = "SELECT COUNT(*) AS count FROM $tableName WHERE $attrToSearch = ?";
        }

        $stmt = $this->connect()->prepare($sql);

        //  Follow the mysql syntax
        if(!$stmt->execute(is_array($attrContentToSearch) ? $attrContentToSearch : [$attrContentToSearch])) die("Database selecting $tableName error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");

        $results = $stmt->fetch();
        return $results['count'];
    }







    /*  Update database
        Syntax:
        dbUpdate: UPDATE {table name} SET {attribute to update} = {attribute content to update} WHERE {attribute to search} = {attribute content to search}
    */
    protected function dbUpdate($tableName, $attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch){
        // Check is multiple search or not
        if(is_array($attrToSearch) or is_array($attrContentToSearch)){
            // Make number of attribute and number of content are the same
            if(sizeof($attrToSearch) !== sizeof($attrContentToSearch)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
            $sql = "UPDATE $tableName SET $attrToUpdate = ? WHERE " . $this->clauseConnector($attrToSearch, "AND");
        } else {
            $sql = "UPDATE $tableName SET $attrToUpdate = ? WHERE $attrToSearch = ?";
        }

        $stmt = $this->connect()->prepare($sql);

        $variables = array();
        $variables[] = $attrContentToUpdate;

        if(is_array($attrContentToSearch)){
            foreach($attrContentToSearch as $element){
                $variables[] = $element;
            }
        } else{
            $variables[] = $attrContentToSearch;
        }

        if(!$stmt->execute($variables)) die("Database updating $tableName error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
    }





    /*  Delete database data
        Syntax:
        dbDelete: DELETE FROM {table name} WHERE {attribute to search} = {attribute content to search}

    */
    protected function dbDelete($tableName, $attrToSearch, $attrContentToSearch){
        $sql = "DELETE FROM $tableName WHERE ".$attrToSearch." = ?";
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute([$attrContentToSearch])) die("Database deleting from $tableName error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        return true;
    }

    protected function dbDelete_MultiSearch($tableName, $attrToSearchList, $attrContentToSearchList){
        if(sizeof($attrToSearchList) !== sizeof($attrContentToSearchList)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
        $sql = "DELETE FROM $tableName WHERE ".$this->clauseConnector($attrToSearchList, "AND");
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute($attrContentToSearchList)) die("Database deleting from $tableName error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        return true;
    }









    /*  MVC Model Version: v0.1.1-alpha
     *  Old version code will remain until all codes are tested perfectly
     */

    protected function dbSelectRow_MultiSearch($tableName, $attrToSearchList, $attrContentToSearchList){
        if(sizeof($attrToSearchList) !== sizeof($attrContentToSearchList)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
        $sql = "SELECT * FROM $tableName WHERE ".$this->clauseConnector($attrToSearchList, "AND");
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute($attrContentToSearchList)) die("Database selecting $tableName error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function dbSelectColumn_MultiSearch($tableName, $attrToSelect, $attrToSearchList, $attrContentToSearchList){
        if(sizeof($attrToSearchList) !== sizeof($attrContentToSearchList)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
        $sql = "SELECT ".$attrToSelect." FROM $tableName WHERE ".$this->clauseConnector($attrToSearchList, "AND");
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute($attrContentToSearchList)) die("Database selecting $tableName error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetchAll();
        $columns = array();
        foreach($results as $row){
            array_push($columns, $row[$attrToSelect]);
        }
        return $columns;
    }

    protected function dbSelectAttribute_MultiSearch($tableName, $attrToSelect, $attrToSearchList, $attrContentToSearchList){
        if(sizeof($attrToSearchList) !== sizeof($attrContentToSearchList)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
        $sql = "SELECT ".$attrToSelect." FROM $tableName WHERE ".$this->clauseConnector($attrToSearchList, "AND");
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute($attrContentToSearchList)) die("Database selecting $tableName error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetchAll();
        if($results != null) return $results[0][$attrToSelect];
        else return null;
    }

    protected function dbSelectAttributeCount_MultiSearch($tableName, $attrToSearchList, $attrContentToSearchList){
        if(sizeof($attrToSearchList) !== sizeof($attrContentToSearchList)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
        $sql = "SELECT COUNT(*) AS count FROM $tableName WHERE ".$this->clauseConnector($attrToSearchList, "AND");
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute($attrContentToSearchList)) die("Database selecting $tableName error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetch();
        return $results['count'];
    }

}

?>
