<?php

CLASS USER extends Database{
    
    
        public function getUser($username){
            $sql = "SELECT * FROM users WHERE username = '$username'";
            $result = $this->connect()->query($sql);
            $numRows = $result->num_rows;
            if($numRows > 0){
                $row = $result->fetch_assoc();
                return $row;
            }
        }
    
        public function getProducts(){
            $sql = "SELECT * FROM products";
            $result = $this->connect()->query($sql);
            $numRows = $result->num_rows;
            if($numRows > 0){
                while($row = $result->fetch_assoc()){
                    $data[] = $row;
                }
                return $data;
            }
        }
    

//function for sanitizing the input
public function cleanVar($var, $connection)
{
    $var = stripslashes($var);
    $var = htmlentities($var);
    $var = strip_tags($var);
    $var = mysqli_real_escape_string($connection, $var);

    return $var;
}


public function register($username, $email, $password)
{
    $database = new Database;
    $connection = $database->connect();

    //sanitizing the input
    $username_cleaned = $this->cleanVar($username, $connection);
    $email_cleaned = $this->cleanVar($email, $connection);
    $password_hashed = $this->cleanVar($password, $connection);


    //hash password
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    if (!empty($username_cleaned) && !empty($email_cleaned) && !empty($password_hashed)) {
        //query the database
        $query = "INSERT INTO users(username,email,password, role)";
        $query .= "VALUES ('$username_cleaned','$email_cleaned','$password_hashed', 1)";

        $result = mysqli_query($connection, $query);

        // printing error message in case of query failure
        if (!$result) {
            die('User Creation failed!' . mysqli_error($connection));
        } else {
            echo "New User Created!<br>";
        }
    } else {
        echo "ALL FIELDS ARE REQUIRED";
    }
}

//function for loging in to the page
public function logIn($username, $password)
{
    
    $database = new Database;
    $connection = $database->connect();
    $doesPasswordsMatch = FALSE;
    $userdata = array();

    // sanitize input first
    $username_cleaned = $this->cleanVar($username, $connection);
    if (!empty($username_cleaned) && !empty($password)) {
        
        // making the query to be sent to database
        $query = "SELECT * FROM users";
        $query .= " WHERE username = '$username_cleaned' ";


        $result = mysqli_query($connection, $query);

        // printing error message in case of query failure
        if (!$result) {
            die('Query failed!' . mysqli_error($connection));
        } else {
            $row = mysqli_fetch_assoc($result);
            $user_password = $row['password'];
            if($row['role'] == 0){
                if($password == $user_password);
                $doesPasswordsMatch = TRUE;
                $userdata['username'] = $row['username'];
                $userdata['role'] = $row['role'];
                echo "Logged in successfully!";
            }else{
            if (password_verify($password, $user_password)) {
            
                $doesPasswordsMatch = TRUE;
                $userdata['username'] = $row['username'];
                $userdata['role'] = $row['role'];
                echo "Logged in successfully!";
            }
        }
        $loginArray = array(
            "isLoggedIn" => $doesPasswordsMatch,
            "userdata" => $userdata);
        return $loginArray;
        
    }} else {
        echo "All fields are required";
        
    }
}

// creating admin user 
public static function createAdmin()
{
    $database = new Database;
    $connection = $database->connect();

    $query = "SELECT * FROM users WHERE username = 'admin'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) == 0) {
        $query = "INSERT INTO users(username, email, password, role)";
        $query .= "VALUES ('admin', 'admin@ecommerce.com', '0admin0', '0')";
        $result = mysqli_query($connection, $query);
    }
}


}
