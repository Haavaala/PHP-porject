<?php
include_once "functions.php";
include "classes/class_User.php";
session_start();
displayNavBar();

echo '<form name="myForm" method="post">';
echo 'Username: <input type= "text" name= "username">';
echo "<br>";
echo 'Email: <input type= "text" name= "email">';
echo "<br>";
echo 'Password: <input type="password" name= "password">';
echo "<br>";
echo ' <input type="submit" name="register" value="register">';
echo '</form>';
echo "<br>";
echo "already a user? " . "<a href='./login.php'>Log in here</a> <br>";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
$register = new User;
$register->register($username, $email, $password);
    header('location: login.php');
}
