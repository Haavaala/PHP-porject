<?php
include "functions.php";
include "classes/class_User.php";
displayNavBar();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ecommerce - Login </title>
</head>

<body>

    <?php

    // First add a method in the User class for creating an admin account. This method should run only once, the first time, this page is loaded. Essentially, do a check on the database to check if an admin account exist. 
    $admin = new User;
    $admin->createAdmin();
    // Implement login functionality here
    echo '<form name="myForm" method="post">';
    echo 'Username: <input type= "text" name= "username">';
    echo "<br>";
    echo 'Password: <input type= "password" name= "password">';
    echo "<br>";
    echo ' <input type="submit" name="login" value="Log in">';
    echo "</form>";
    echo "<br>";
    // Implement registration functionality instead, if a register hyperlink is clicked. 
    echo "New here? " . "<a href='./registration.php'>Register here <br></a>";


    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $login = new User;
        $loginArray = $login->login($username, $password);
        if ($loginArray['isLoggedIn']) {
            $userdata = $loginArray['userdata'];
            // always regenerate session ID after Login
            session_regenerate_id();
            
            // set session parameters
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $userdata['username'];
            $_SESSION['isloggedin'] = TRUE;
            $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['ua'] = $_SERVER['HTTP_USER_AGENT'];
            $_SESSION['role'] = $userdata['role'];
            echo "<pre>";
            
            if($_SESSION['role'] == '0'){
                header("Location: adminPage.php");
        }else{
            header("Location: mainPage.php");
        }
        } else {
            echo "Invalid username or password";
        }
    }


    ?>



</body>

</html>