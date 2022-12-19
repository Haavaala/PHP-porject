<?php
include "functions.php";
include "classes/class_Product.php";
session_start();
displayNavBar();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ecommerce - Product Page </title>
</head>
<style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 5px;
    }

    th {
        text-align: left;
    }
</style>

<body>

    <?php
    $database = new Database;
    $connection = $database->connect();



    // Display specific information about product selected in the previous page. 

    $productID = $_GET['product_id'];
    $show = new Product;
    $show->showProduct($productID);

    // Note that the product page can only be accessed from the main page. 
    // Add a form : with a select field to choose quantity, and a submit button named "Add to cart", which will populate the shopping cart. 
    echo "<form name='addToCart' method='POST'>";
    echo "<br>";
    echo "Quantity:";
    echo '<input type="number" id="quantity" name="quantity" min="1" max="50">';
    echo '</select>';
    echo "<br>";
    echo '<input type="submit" name="cart" value="Add to cart">';
    echo "</form>";
    // Shopping cart information can be preserved in a cookie. If the user closes the browser and reopens the page, the shopping cart information can be repopulated from the cookie. 
    // Modify the shopping cart link in the navigation bar when an item is added to it. 






    if (isset($_POST['cart'])) {
        $quantity = $_POST['quantity'];
        $addToCart = new Product;
        $addToCart->addToCart($productID, $quantity);
        setcookie("cart", $quantity, time() + (86400 * 7), "localhost", false, "httponly");
    }


    session_destroy();

    ?>
</body>

</html>