<?php // superclass definition : Database
// contains Database related methods. 

// echo "In class: Database<br>";

class Database{
    
    public function connect(){
        // echo "Database : connect<br>";
        
        $host = 'localhost';
        $username = 'root';
        $password = 'root';
        $database = 'ecommerce';

        $connection = mysqli_connect($host,$username,$password,$database);

        if($connection){
            // echo "We are connected!<br>";
        }else {
            die ("Database connection failed");
        }
        return $connection;
    }
    

    public function imageAndName($tableName){
        // echo "Database:readFromTable<br>";
        $database = new Database;
        $connection = $database->connect();
        //query the database
        $query = "SELECT image_name, product_name, product_id FROM $tableName";

        $result = mysqli_query($connection, $query);
        
        // printing error message in case of query failure
        if(!$result){
            die('Query failed!' . mysqli_error($connection));
        }else {
            echo "Entries Retrieved!<br>";
        }
        $idx = 0;
        while($row=mysqli_fetch_assoc($result)){
            //print_r($row);echo "<br>";
            $resArray[$idx] = $row;
            $idx++;
        }
        return $resArray;
    }

    public function disconnect($connection){
        mysqli_close($connection);
    }
    
    public function readFromTable($tableName){
        // echo "Database:readFromTable<br>";
        $connection = Database::connect();
        //query the database
        $query = "SELECT * FROM $tableName";

        $result = mysqli_query($connection, $query);

        // printing error message in case of query failure
        if(!$result){
            die('Query failed!' . mysqli_error($connection));
        }else {
            //echo "Entries Retrieved!<br>";
        }

        //read 1 row at a time
        $idx = 0;
        while($row=mysqli_fetch_assoc($result)){
            //print_r($row);echo "<br>";
            $resArray[$idx] = $row;
            $idx++;
        }

        Database::disconnect($connection);
        return $resArray;

    }
    
    // sanitize input
    protected function cleanVar($var, $connection){
        
        

    }
    
}
