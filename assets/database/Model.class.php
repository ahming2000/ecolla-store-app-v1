<?php

/*  MVC Model Version: v0.3.1-alpha
*   Created by AhMing
*   Commit Details: https://github.com/ahming2000/EcollaWebsite/commits/main/assets/database/Model.class.php
*   Go to README.MD for changing log.
*/

require_once "Dbh.class.php";

class Model extends Dbh{

    /*** Utility ***/
    /*  Print the error for debugging use */
    private function handleException($errorLocation, $detail){
        echo "Internal error<br>$errorLocation<br>Error message: $detail";
        $this->log("[Error] $errorLocation Error message: $detail");
        die();
    }

    /* Get client IP address */
    private function getClientIPAddress(){
        //whether ip is from the share internet
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        //whether ip is from the proxy
        else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //whether ip is from the remote address
        else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /* Get current page name */
    private function getCurrentPageLocation(){
        return substr($_SERVER['REQUEST_URI'], 1);
    }

    /* Log to file for any changes */
    private function log($message){

        $date = date("Y-m-d");
        $time = date("H:i:s");
        $ip = $this->getClientIPAddress();
        $pageLocation = $this->getCurrentPageLocation();

        // Make dir if it is not existed
        if(!is_dir($_SERVER['DOCUMENT_ROOT'] . "/log/")) mkdir($_SERVER['DOCUMENT_ROOT'] . "/log/", 0700);
        if(!is_dir($_SERVER['DOCUMENT_ROOT'] . "/log/model/")) mkdir($_SERVER['DOCUMENT_ROOT'] . "/log/model/", 0700);

        // Create file pointer
        if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/log/model/model-log-$date.log")){
            $fptr = fopen($_SERVER['DOCUMENT_ROOT'] . "/log/model/model-log-$date.log", "a") or die("Cannot open log file correctly!");
        } else{
            $fptr = fopen($_SERVER['DOCUMENT_ROOT'] . "/log/model/model-log-$date.log", "w") or die("Cannot open log file correctly!");
        }

        $logLine = "[$time][$ip accessing $pageLocation]$message\n";

        // Write to file
        if(!fwrite($fptr, $logLine)){
            $this->handleException("Error when logging.", "Please check the file pointer!");
        }
        fclose($fptr);
    }

    private $DB_CONFIG;
    function __construct(){
        /* Import table inserting config from json files */
        $JSON_STRING = file_get_contents("db-tables-config.json", true);
        if(!$JSON_STRING){
            $this->handleException("Error when importing database table config json file.", "Please make sure the database table config files is existed!");
        }

        $this->DB_CONFIG = json_decode($JSON_STRING, true);
        if($this->DB_CONFIG == null){
            $this->handleException("Cannot decode database table config json.", "Please make sure config files format is correct!");
        }
    }





    /*** Useful tools ***/
    /*  Concat the symbol into a string
        Example:
        When $count is assigned
        $element = '?', $saperateWith = ', ', $count = 3
        $output = ?, ?, ?
        When $count is not assigned
        $element = ["a", "b"], $saperateWith = ', '
        $output = "a, b"
    */
    private function concatString($element, $saperateWith, $count = 0){
        if($count == 0){
            $str = $element[0];
            for($i = 1; $i < sizeof($element); $i++){
                $str = $str . $saperateWith . $element[$i];
            }
        } else{
            $str = $element;
            for($i = 1; $i < $count; $i++){
                $str = $str . $saperateWith . $element;
            }
        }
        return $str;
    }

    /*  Connect multiple attribute with clause by using this function
        Example:
        $attrArray = ["i_name", "i_brand"], $clause = "AND"
        $output = "i_name = ? AND i_brand = ?"
    */
    private function clauseConnector($attrArray, $clause){
        $str = $attrArray[0] . " = ?";
        for($i = 1; $i < sizeof($attrArray); $i++){
            $str = $str . " " . $clause . " " . $attrArray[$i] . " LIKE ?";
        }
        return $str;
    }





    /*** Database Interaction ***/
    /*  Standard function for database query
        Output:
        Return raw data
        Return true when run a query without result
    */
    protected function dbQuery($sql){

        $this->log("[Info] Start query: $sql");

        $stmt = $this->connect()->prepare($sql);

        // Execute the query
        if(!$stmt->execute()){
            $this->handleException("Error when execute standard query function, your query conmmand: <br>$sql", $stmt->errorInfo()[2]);
        }

        // Return the results into php variable
        $results = $stmt->fetchAll();
        return $results == null ? true : $results;
    }

    /*  Insert into database
        Syntax:
        dbInsert: INSERT INTO {table name} VALUE({data to insert})
    */
    protected function dbInsert($configName, $data){

        $this->log("[Info] Inserting with config name \"$configName\"");

        // Check availability of the database table config
        if (!array_key_exists($configName, $this->DB_CONFIG)) {
            $this->handleException("$configName is not existed in database table config.", "Please make sure config is available in the database table config file!");
        }

        // Check $data is an array
        if (!is_array($data)){
            $this->handleException("Data to insert is not an array.", "Please make sure data to insert is an array!");
        }

        $tableName = $this->DB_CONFIG[$configName]["tableName"];
        $columns = $this->DB_CONFIG[$configName]["columns"];
        $columnsCount = sizeof($columns);

        // Check $data array has correct number of columns or not
        if (sizeof($data) != $columnsCount){
            $this->handleException("Data to insert should have $columnsCount column data but only have " . sizeof($data) . ".", "Please make sure data to insert has correct number of columns!");
        }

        $tableInfo = "$tableName(" . $this->concatString($columns, ", ") . ")";
        $valueInfo = $this->concatString("?", ", ", $columnsCount);

        $sql = "INSERT INTO $tableInfo VALUE($valueInfo)";

        // Prepare the query
        $stmt = $this->connect()->prepare($sql);

        // Execute the query
        if(!$stmt->execute($data)){
            $this->handleException("Error when inserting row into table.", $stmt->errorInfo()[2]);
        }
    }

    /*  Select all
        Syntax:
        1. SELECT * FROM {table name}
        2. SELECT * FROM {table name} LIMIT {start}, {range}
        Output:
        1. All column and row data (2D Array)
        2. All column and row data within range set (2D Array)
    */
    protected function dbSelectAll($tableName, $start = 0, $range = 0){

        $hasLimit = false;

        // If $start and $range is set, query with LIMIT CLAUSE
        if($range != 0) $hasLimit = true;

        if($hasLimit){
            $sql = "SELECT * FROM $tableName LIMIT $start, $range";
        }
        else{
            $sql = "SELECT * FROM $tableName";
        }

        $l = $hasLimit ? "with" : "without";
        $this->log("[Info] Selecting all row(s) from $tableName $l range set.");

        // Prepare the query
        $stmt = $this->connect()->prepare($sql);

        // Execute the query
        if(!$stmt->execute()){
            $this->handleException("Error when selecting all from $tableName.", $stmt->errorInfo()[2]);
        }

        // Return the results into php variable
        $results = $stmt->fetchAll();
        return $results;
    }

    /*  Select row(s) with all columns and condition(s) can be set
        Syntax:
        1. SELECT * FROM {table name} WHERE {attribute to search} = {attribute content to search}
        2. SELECT * FROM {table name} WHERE {attribute to search} = {attribute content to search} LIMIT {start}, {range}
        Output:
        1. All column and relevent row data (2D Array)
        2. All column and relevent row data within range set (2D Array)
    */
    protected function dbSelectRow($tableName, $attrToSearch, $attrContentToSearch, $start = 0, $range = 0){

        $hasLimit = false;
        $hasMultipleSearch = false;

        // If $start and $range is set, query with LIMIT CLAUSE
        if($range != 0) $hasLimit = true;

        // If $attrToSearch and $attrContentToSearch are array, enable multiple search
        if(is_array($attrToSearch) or is_array($attrContentToSearch)){
            $hasMultipleSearch = true;

            // Error when one of it is not array
            if(!is_array($attrToSearch) or !is_array($attrContentToSearch)){
                $this->handleException("Error when selecting row from $tableName.", "Both variables should be array for multiple search!");
            }

            // Error when two array have difference size
            if(sizeof($attrToSearch) != sizeof($attrContentToSearch)){
                $this->handleException("Error when selecting row from $tableName.", "You must have same amount of attribute and attribute content for WHERE clause!");
            }
        }

        if($hasLimit){
            if($hasMultipleSearch){
                $whereClause = $this->clauseConnector($attrToSearch, "AND");
                $sql = "SELECT * FROM $tableName WHERE $whereClause LIMIT $start, $range";
            } else{
                $sql = "SELECT * FROM $tableName WHERE $attrToSearch LIKE ? LIMIT $start, $range";
            }
        }
        else{
            if($hasMultipleSearch){
                $whereClause = $this->clauseConnector($attrToSearch, "AND");
                $sql = "SELECT * FROM $tableName WHERE $whereClause";
            } else{
                $sql = "SELECT * FROM $tableName WHERE $attrToSearch LIKE ?";
            }
        }

        $l = $hasLimit ? "with" : "without";
        $c = $hasMultipleSearch ? "with" : "without";
        $this->log("[Info] Selecting row(s) from $tableName $c multiple condition set and $l range set.");

        // Prepare the query
        $stmt = $this->connect()->prepare($sql);

        // Execute the query, put it as array when it is array
        if(!$stmt->execute(is_array($attrContentToSearch) ? $attrContentToSearch : [$attrContentToSearch])){
            $this->handleException("Error when selecting row from $tableName.", $stmt->errorInfo()[2]);
        }

        // Return the results into php variable
        $results = $stmt->fetchAll();
        return $results;
    }

    /*  Select all attributes with selected column name
        Syntax:
        1. SELECT {attribute to select} FROM {table name}
        2. SELECT {attribute to select} FROM {table name} LIMIT {start}, {range}
        Output:
        1. All column data (1D Array)
        2. All column data within range set (1D Array)
    */
    protected function dbSelectColumn($tableName, $attrToSelect, $start = 0, $range = 0){

        $hasLimit = false;

        // If $start and $range is set, query with LIMIT CLAUSE
        if($range != 0) $hasLimit = true;

        if($hasLimit){
            $sql = "SELECT $attrToSelect FROM $tableName LIMIT $start, $range";
        }
        else{
            $sql = "SELECT $attrToSelect FROM $tableName";
        }

        $l = $hasLimit ? "with" : "without";
        $this->log("[Info] Selecting column(s) from $tableName $l range set.");

        // Prepare the query
        $stmt = $this->connect()->prepare($sql);

        // Execute the query
        if(!$stmt->execute()){
            $this->handleException("Error when selecting column from $tableName.", $stmt->errorInfo()[2]);
        }

        // Return the results into php variable
        $results = $stmt->fetchAll();
        return array_column($results, $attrToSelect);
    }

    /*  Select relevent attributes with selected column name and condition(s) is set
        Syntax:
        1. SELECT {attribute to select} FROM {table name} WHERE {attribute to search} = {attribute content to search}
        2. SELECT {attribute to select} FROM {table name} WHERE {attribute to search} = {attribute content to search} LIMIT {start}, {range}
        Output:
        1. Relevent column and relevent row data (2D Array)
        2. Relevent column and relevent row data within range set (2D Array)
    */
    protected function dbSelectRowAttribute($tableName, $attrToSelect, $attrToSearch, $attrContentToSearch, $start = 0, $range = 0){

        $hasLimit = false;
        $hasMultipleSearch = false;
        $hasMultipleSelect = false;

        // If $start and $range is set, query with LIMIT CLAUSE
        if($range != 0) $hasLimit = true;

        // If $attrToSearch and $attrContentToSearch are array, enable multiple search
        if(is_array($attrToSearch) or is_array($attrContentToSearch)){
            $hasMultipleSearch = true;

            // Error when one of it is not array
            if(!is_array($attrToSearch) or !is_array($attrContentToSearch)){
                $this->handleException("Error when selecting row attribute from $tableName.", "Both variables should be array for multiple search!");
            }

            // Error when two array have difference size
            if(sizeof($attrToSearch) != sizeof($attrContentToSearch)){
                $this->handleException("Error when selecting row attribute from $tableName.", "You must have same amount of attribute and attribute content for WHERE clause!");
            }
        }

        // If $attrToSearch is array, enable multiple select
        if(is_array($attrToSelect)){
            $hasMultipleSelect = true;
        }

        if($hasLimit){
            if($hasMultipleSearch){
                if($hasMultipleSelect){
                    $whereClause = $this->clauseConnector($attrToSearch, "AND");
                    $selectClause = $this->concatString($attrToSelect, ", ");
                    $sql = "SELECT $selectClause FROM $tableName WHERE $whereClause LIMIT $start, $range";
                } else{
                    $whereClause = $this->clauseConnector($attrToSearch, "AND");
                    $sql = "SELECT $attrToSelect FROM $tableName WHERE $whereClause LIMIT $start, $range";
                }
            } else{
                if($hasMultipleSelect){
                    $selectClause = $this->concatString($attrToSelect, ", ");
                    $sql = "SELECT $selectClause FROM $tableName WHERE $attrToSearch LIKE ? LIMIT $start, $range";
                } else{
                    $sql = "SELECT $attrToSelect FROM $tableName WHERE $attrToSearch LIKE ? LIMIT $start, $range";
                }
            }
        }
        else{
            if($hasMultipleSearch){
                if($hasMultipleSelect){
                    $whereClause = $this->clauseConnector($attrToSearch, "AND");
                    $selectClause = $this->concatString($attrToSelect, ", ");
                    $sql = "SELECT $selectClause FROM $tableName WHERE $whereClause";
                } else{
                    $whereClause = $this->clauseConnector($attrToSearch, "AND");
                    $sql = "SELECT $attrToSelect FROM $tableName WHERE $whereClause";
                }
            } else{
                if($hasMultipleSelect){
                    $selectClause = $this->concatString($attrToSelect, ", ");
                    $sql = "SELECT $selectClause FROM $tableName WHERE $attrToSearch LIKE ?";
                } else{
                    $sql = "SELECT $attrToSelect FROM $tableName WHERE $attrToSearch LIKE ?";
                }
            }
        }

        $l = $hasLimit ? "with" : "without";
        $c = $hasMultipleSearch ? "with" : "without";
        $this->log("[Info] Selecting row(s) from $tableName $c multiple condition set and $l range set.");

        // Prepare the query
        $stmt = $this->connect()->prepare($sql);

        // Execute the query, put it as array when it is array
        if(!$stmt->execute(is_array($attrContentToSearch) ? $attrContentToSearch : [$attrContentToSearch])){
            $this->handleException("Error when selecting row attribute from $tableName.", $stmt->errorInfo()[2]);
        }

        // Return the results into php variable
        $results = $stmt->fetchAll();
        return $results;
    }


    /*  Select all attributes with selected column name and condition(s) is set
        Syntax:
        1. SELECT {attribute to select} FROM {table name} WHERE {attribute to search} = {attribute content to search}
        2. SELECT {attribute to select} FROM {table name} WHERE {attribute to search} = {attribute content to search} LIMIT {start}, {range}
        Output:
        1. Relevent column data (1D Array)
        2. Relevent column data within range set (1D Array)
    */
    protected function dbSelectColumnAttribute($tableName, $attrToSelect, $attrToSearch, $attrContentToSearch, $start = 0, $range = 0){

        $hasLimit = false;
        $hasMultipleSearch = false;

        // If $start and $range is set, query with LIMIT CLAUSE
        if($range != 0) $hasLimit = true;

        // If $attrToSearch and $attrContentToSearch are array, enable multiple search
        if(is_array($attrToSearch) or is_array($attrContentToSearch)){
            $hasMultipleSearch = true;

            // Error when one of it is not array
            if(!is_array($attrToSearch) or !is_array($attrContentToSearch)){
                $this->handleException("Error when selecting column attribute from $tableName.", "Both variables should be array for multiple search!");
            }

            // Error when two array have difference size
            if(sizeof($attrToSearch) != sizeof($attrContentToSearch)){
                $this->handleException("Error when selecting column attribute from $tableName.", "You must have same amount of attribute and attribute content for WHERE clause!");
            }
        }

        if($hasLimit){
            if($hasMultipleSearch){
                $whereClause = $this->clauseConnector($attrToSearch, "AND");
                $sql = "SELECT $attrToSelect FROM $tableName WHERE $whereClause LIMIT $start, $range";
            } else{
                $sql = "SELECT $attrToSelect FROM $tableName WHERE $attrToSearch LIKE ? LIMIT $start, $range";
            }
        }
        else{
            if($hasMultipleSearch){
                $whereClause = $this->clauseConnector($attrToSearch, "AND");
                $sql = "SELECT $attrToSelect FROM $tableName WHERE $whereClause";
            } else{
                $sql = "SELECT $attrToSelect FROM $tableName WHERE $attrToSearch LIKE ?";
            }
        }

        $l = $hasLimit ? "with" : "without";
        $c = $hasMultipleSearch ? "with" : "without";
        $this->log("[Info] Selecting column(s) from $tableName $c multiple condition set and $l range set.");

        // Prepare the query
        $stmt = $this->connect()->prepare($sql);

        // Execute the query, put it as array when it is array
        if(!$stmt->execute(is_array($attrContentToSearch) ? $attrContentToSearch : [$attrContentToSearch])){
            $this->handleException("Error when selecting column attribute from $tableName.", $stmt->errorInfo()[2]);
        }

        // Return the results into php variable
        $results = $stmt->fetchAll();
        return array_column($results, $attrToSelect);
    }

    /*  Select all attributes with selected column name and condition(s) is set
        Syntax:
        1. SELECT {attribute to select} FROM {table name} WHERE {attribute to search} = {attribute content to search}
        2. SELECT {attribute to select} FROM {table name} WHERE {attribute to search} = {attribute content to search} LIMIT {start}, {range}
        Output:
        1. Relevent data with selected column and one or some attributes (Value)
        2. Relevent data with selected column and one or some attributes within range set (Value)
    */
    protected function dbSelectAttribute($tableName, $attrToSelect, $attrToSearch, $attrContentToSearch){

        $hasMultipleSearch = false;

        // If $attrToSearch and $attrContentToSearch are array, enable multiple search
        if(is_array($attrToSearch) or is_array($attrContentToSearch)){
            $hasMultipleSearch = true;

            // Error when one of it is not array
            if(!is_array($attrToSearch) or !is_array($attrContentToSearch)){
                $this->handleException("Error when selecting attribute from $tableName.", "Both variables should be array for multiple search!");
            }

            // Error when two array have difference size
            if(sizeof($attrToSearch) != sizeof($attrContentToSearch)){
                $this->handleException("Error when selecting attribute from $tableName.", "You must have same amount of attribute and attribute content for WHERE clause!");
            }
        }

        if($hasMultipleSearch){
            $whereClause = $this->clauseConnector($attrToSearch, "AND");
            $sql = "SELECT $attrToSelect FROM $tableName WHERE $whereClause";
        } else{
            $sql = "SELECT $attrToSelect FROM $tableName WHERE $attrToSearch LIKE ?";
        }

        $c = $hasMultipleSearch ? "with" : "without";
        $this->log("[Info] Selecting data from $tableName $c multiple condition set.");

        // Prepare the query
        $stmt = $this->connect()->prepare($sql);

        // Execute the query, put it as array when it is array
        if(!$stmt->execute(is_array($attrContentToSearch) ? $attrContentToSearch : [$attrContentToSearch])){
            $this->handleException("Error when selecting attribute from $tableName.", $stmt->errorInfo()[2]);
        }

        // Return the results into php variable
        $results = $stmt->fetchAll();
        // Log for warning if the row get is more than 1
        if(!empty($results[1])){
            $this->log("[Warning] The attribute to select have more than 2 rows in results, this will only return first result.");
        }
        // If nothing is found, directly return null to avoid array indexing error
        if($results != null) return $results[0][$attrToSelect];
        else return null;
    }

    protected function dbSelectCount($tableName, $attrToSearch = array(), $attrContentToSearch = array()){

        $hasMultipleSearch = false;

        // If $attrToSearch and $attrContentToSearch are array, enable multiple search
        if((is_array($attrToSearch) or is_array($attrContentToSearch)) and (!empty($attrToSearch) and !empty($attrContentToSearch))){
            $hasMultipleSearch = true;

            // Error when one of it is not array
            if(!is_array($attrToSearch) or !is_array($attrContentToSearch)){
                $this->handleException("Error when selecting count from $tableName.", "Both variables should be array for multiple search!");
            }

            // Error when two array have difference size
            if(sizeof($attrToSearch) != sizeof($attrContentToSearch)){
                $this->handleException("Error when selecting count from $tableName.", "You must have same amount of attribute and attribute content for WHERE clause!");
            }
        }

        $c = $hasMultipleSearch ? "with" : "without";
        $this->log("[Info] Selecting count of $tableName $c multiple condition set.");

        if($hasMultipleSearch){
            $whereClause = $this->clauseConnector($attrToSearch, "AND");
            $sql = "SELECT COUNT(*) AS count FROM $tableName WHERE $whereClause";
        } else{
            $sql = "SELECT COUNT(*) AS count FROM $tableName";
        }

        // Prepare the query
        $stmt = $this->connect()->prepare($sql);

        // Execute the query, put it as array when it is array
        if(!$stmt->execute(is_array($attrContentToSearch) ? $attrContentToSearch : [$attrContentToSearch])){
            $this->handleException("Error when selecting count from $tableName.", $stmt->errorInfo()[2]);
        }

        // Return the results into php variable
        $results = $stmt->fetchAll();
        return $results['count'];
    }

    /*  Update database
        Syntax:
        dbUpdate: UPDATE {table name} SET {attribute to update} = {attribute content to update} WHERE {attribute to search} = {attribute content to search}
    */
    protected function dbUpdate($tableName, $attrToUpdate, $attrContentToUpdate, $attrToSearch, $attrContentToSearch){

        $hasMultipleSearch = false;

        // If $attrToSearch and $attrContentToSearch are array, enable multiple search
        if(is_array($attrToSearch) or is_array($attrContentToSearch)){
            $hasMultipleSearch = true;

            // Error when one of it is not array
            if(!is_array($attrToSearch) or !is_array($attrContentToSearch)){
                $this->handleException("Error when updating $attrToUpdate from $tableName.", "Both variables should be array for multiple search!");
            }

            // Error when two array have difference size
            if(sizeof($attrToSearch) != sizeof($attrContentToSearch)){
                $this->handleException("Error when updating $attrToUpdate from $tableName.", "You must have same amount of attribute and attribute content for WHERE clause!");
            }
        }

        $c = $hasMultipleSearch ? "with" : "without";
        $this->log("[Info] Updating $attrToUpdate to $attrContentToUpdate from $tableName $c multiple condition set.");

        if($hasMultipleSearch){
            $whereClause = $this->clauseConnector($attrToSearch, "AND");
            $sql = "UPDATE $tableName SET $attrToUpdate = ? WHERE $whereClause";
        } else{
            $sql = "UPDATE $tableName SET $attrToUpdate = ? WHERE $attrToSearch LIKE ?";
        }

        // Prepare the query
        $stmt = $this->connect()->prepare($sql);

        // Execute the query, put it as array when it is array
        if(!$stmt->execute(array_merge([$attrContentToUpdate], is_array($attrContentToSearch) ? $attrContentToSearch : [$attrContentToSearch]))){
            $this->handleException("Error when updating $attrToUpdate from $tableName.", $stmt->errorInfo()[2]);
        }
    }

    /*  Delete database data
        Syntax:
        dbDelete: DELETE FROM {table name} WHERE {attribute to search} = {attribute content to search}
    */
    protected function dbDelete($tableName, $attrToSearch, $attrContentToSearch){

        $hasMultipleSearch = false;

        // If $attrToSearch and $attrContentToSearch are array, enable multiple search
        if(is_array($attrToSearch) or is_array($attrContentToSearch)){
            $hasMultipleSearch = true;

            // Error when one of it is not array
            if(!is_array($attrToSearch) or !is_array($attrContentToSearch)){
                $this->handleException("Error when deleting row from $tableName.", "Both variables should be array for multiple search!");
            }

            // Error when two array have difference size
            if(sizeof($attrToSearch) != sizeof($attrContentToSearch)){
                $this->handleException("Error when deleting row from $tableName.", "You must have same amount of attribute and attribute content for WHERE clause!");
            }
        }

        $c = $hasMultipleSearch ? "with" : "without";
        $this->log("[Info] Deleting row from $tableName $c multiple condition set.");

        if($hasMultipleSearch){
            $whereClause = $this->clauseConnector($attrToSearch, "AND");
            $sql = "DELETE FROM $tableName WHERE $whereClause";
        } else{
            $sql = "DELETE FROM $tableName WHERE $attrToSearch LIKE ?";
        }

        // Prepare the query
        $stmt = $this->connect()->prepare($sql);

        // Execute the query, put it as array when it is array
        if(!$stmt->execute(is_array($attrContentToSearch) ? $attrContentToSearch : [$attrContentToSearch])){
            $this->handleException("Error when deleting row from $tableName.", $stmt->errorInfo()[2]);
        }
        return true;
    }



























    /*  MVC Model Version v0.2.1-alpha
    *  Old version code will remain until all codes are tested perfectly
    */

    protected function dbSelectAllRange($tableName, $start, $range){
        $sql = "SELECT * FROM $tableName LIMIT ".$start.", ".$range;
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute()) die("Database selecting $tableName error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetchAll();
        return $results;
    }

    private $DATABASE_TABLE = [

        "items" => [
            "tableName" => "items",
            "columnsToInsert" => "items(i_name, i_desc, i_brand, i_origin, i_property_name, i_image_count)",
            "columnsCountToInsert" => 6
        ],

        "varieties" => [
            "tableName" => "varieties",
            "columnsToInsert" => "varieties(v_barcode, v_property, v_price, v_weight, v_discount_rate, i_id)",
            "columnsCountToInsert" => 6
        ],

        "categories" => [
            "tableName" => "categories",
            "columnsToInsert" => "categories(cat_name)",
            "columnsCountToInsert" => 1
        ],

        "inventories" => [
            "tableName" => "inventories",
            "columnsToInsert" => "inventories(v_barcode, inv_expire_date, inv_quantity)",
            "columnsCountToInsert" => 3
        ],

        "classifications" => [
            "tableName" => "classifications",
            "columnsToInsert" => "classifications(i_id, cat_id)",
            "columnsCountToInsert" => 2
        ],

        "orders" => [
            "tableName" => "orders",
            "columnsToInsert" => "orders(o_id, o_date_time, o_payment_method, o_note, c_name, c_phone_mcc, c_phone, c_address, c_state, c_area, c_postal_code)",
            "columnsCountToInsert" => 11
        ],

        "order_items" => [
            "tableName" => "order_items",
            "columnsToInsert" => "order_items(o_id, v_barcode, oi_quantity)",
            "columnsCountToInsert" => 3
        ],

        "users" => [
            "tableName" => "users",
            "columnsToInsert" => "users(user_name, user_password)",
            "columnsCountToInsert" => 2
        ]

    ];

    protected function dbInsert_old($configName, $data){
        $sql = "INSERT INTO ".$this->DATABASE_TABLE[$configName]["columnsToInsert"]." VALUE(".$this->concatString('?', ', ', $this->DATABASE_TABLE[$configName]["columnsCountToInsert"]).")";
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute($data)) die("Database inserting " . $this->DATABASE_TABLE["$configName"]["tableName"] . "error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
    }

    protected function dbSelectRowRange($tableName, $attrToSearch, $attrContentToSearch, $start, $range){
        // Check is multiple search or not
        if(is_array($attrToSearch) or is_array($attrContentToSearch)){
            // Make number of attribute and number of content are the same
            if(sizeof($attrToSearch) !== sizeof($attrContentToSearch)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
            $sql = "SELECT * FROM $tableName WHERE " . $this->clauseConnector($attrToSearch, "AND") . " LIMIT $start, $range";
        } else {
            $sql = "SELECT * FROM $tableName WHERE $attrToSearch LIKE ? LIMIT $start, $range";
        }

        $stmt = $this->connect()->prepare($sql);

        //  Follow the mysql syntax
        if(!$stmt->execute(is_array($attrContentToSearch) ? $attrContentToSearch : [$attrContentToSearch])) die("Database selecting $tableName error. MySQL error message: " . $stmt->errorInfo()[2] . "<br>");

        $results = $stmt->fetchAll();
        return $results;
    }

    protected function dbSelectAttributeCount($tableName, $attrToSearch, $attrContentToSearch){
        // Check is multiple search or not
        if(is_array($attrToSearch) or is_array($attrContentToSearch)){
            // Make number of attribute and number of content are the same
            if(sizeof($attrToSearch) !== sizeof($attrContentToSearch)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
            $sql = "SELECT COUNT(*) AS count FROM $tableName WHERE " . $this->clauseConnector($attrToSearch, "AND");
        } else {
            $sql = "SELECT COUNT(*) AS count FROM $tableName WHERE $attrToSearch LIKE ?";
        }

        $stmt = $this->connect()->prepare($sql);

        //  Follow the mysql syntax
        if(!$stmt->execute(is_array($attrContentToSearch) ? $attrContentToSearch : [$attrContentToSearch])) die("Database selecting $tableName error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");

        $results = $stmt->fetch();
        return $results['count'];
    }

    protected function dbSelectAllRange_JoinTable($tableNameA, $tableNameB, $tableNameC, $foreignKeyAB, $foreignKeyBC, $attrToSearch, $attrContentToSearch, $start, $range){
        // Check is multiple search or not
        if(is_array($attrToSearch) or is_array($attrContentToSearch)){
            // Make number of attribute and number of content are the same
            if(sizeof($attrToSearch) !== sizeof($attrContentToSearch)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
            $sql = "SELECT * FROM $tableNameA a, $tableNameB b, $tableNameC c WHERE a.$foreignKeyAB = b.$foreignKeyAB AND b.$foreignKeyBC = c.$foreignKeyBC AND " . $this->clauseConnector($attrToSearch, "AND") . " LIMIT $start, $range";
        } else {
            $sql = "SELECT * FROM $tableNameA a, $tableNameB b, $tableNameC c WHERE a.$foreignKeyAB = b.$foreignKeyAB AND b.$foreignKeyBC = c.$foreignKeyBC AND $attrToSearch LIKE ? LIMIT $start, $range";
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
            $sql = "SELECT $attrToSelect FROM $tableNameMain JOIN ($tableNameA, $tableNameB) USING ($foreignKeyFromTableA, $foreignKeyFromTableB) WHERE $attrToSearch LIKE ?";
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
            $sql = "SELECT $attrToSelect FROM $tableNameA a, $tableNameB b, $tableNameC c WHERE a.$foreignKeyAB = b.$foreignKeyAB AND b.$foreignKeyBC = c.$foreignKeyBC AND $attrToSearch LIKE ?";
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
            $sql = "SELECT $attrToSelect FROM $tableNameA a, $tableNameB b, $tableNameC c WHERE a.$foreignKeyAB = b.$foreignKeyAB AND b.$foreignKeyBC = c.$foreignKeyBC AND $attrToSearch LIKE ? LIMIT $start, $range";
        }

        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute(is_array($attrContentToSearch) ? $attrContentToSearch : [$attrContentToSearch])) die("Database selecting ".$tableNameA." or ".$tableNameB." error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
        $results = $stmt->fetchAll();
        return $results;
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

    protected function dbDelete_MultiSearch($tableName, $attrToSearchList, $attrContentToSearchList){
        if(sizeof($attrToSearchList) !== sizeof($attrContentToSearchList)) die("Database query error: You must have same amount of attribute and attribute content for WHERE clause!");
        $sql = "DELETE FROM $tableName WHERE ".$this->clauseConnector($attrToSearchList, "AND");
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute($attrContentToSearchList)) die("Database deleting from $tableName error. MySQL error message: ".$stmt->errorInfo()[2]."<br>");
    }

}

?>
