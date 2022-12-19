<?php
include "functions.php";
include "classes/class_Order.php";

displayNavBar();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ecommerce - Shopping Cart </title>
</head>
<style>
    table {
        width: 70%;
    }


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





    if (isset($_COOKIE['cart'])) {
        $shopping = file_get_contents("shoppingCart.json");
        $details = json_decode($shopping, true);
        setcookie("cart", 1, time() + (86400 * 7), "localhost", false, "httponly");
        $total = 0;
        echo "<table>";
        foreach ($details as $key => $value) {
            $prodID = $value['product_id'];
            $query = "SELECT * FROM products WHERE product_id = $prodID;";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
            $image_name = $row['image_name'];
            $price = $row['price'];
            echo "<tr>";
            echo "<td>" . $value['product_id'] . "</td>";
            echo "<td>" . $value['quantity'] . "</td>";
            echo "<td>  <img src='./pic/$image_name' alt='product image width='100' height='100''></td>";
            echo "<td>" . $price . "</td>";
            echo "<td>" . number_format($value['quantity'] * $price, 2) . "</td>";
            echo "</tr>";
            $total += $price * $value['quantity'];
        }
    } else {
        echo  "<tr>";
        echo  "<td>No item in cart <br></td>";
        echo  "</tr>";
    }
    echo "<tr>";
    echo "<td colspan='3' align='right'>Total </td>";
    echo "<td align='right'>" . number_format($total, 2) . "</td>";
    echo "</tr>";
    echo "</table>";

    echo "<br>";
    echo "<form method='POST'>";
    echo "Firstname: <br>";
    echo "<input type='text' name='Firstname'>";
    echo "<br>";
    echo "Lastname: <br>";
    echo "<input type='text' name='Lastname'>";
    echo "<br>";
    echo "Address: <br>";
    echo "<input type='text' name='Address'>";
    echo "<br>";
    echo "Country: <br>";
    echo "<select name='Country'>";
    echo "<option value=''>Select Country</option>";
    foreach ($countries as $key => $value) {
        echo "<option value='$value'>$value</option>";
    }
    echo "</select>";
    echo "<br>";
    echo "<input type='submit' name='confirm' value='confirm order'>";
    echo "</form>";


    echo "<br>";
    echo "<a href='mainPage.php'>Continue Shopping</a>";

    // form for deleting item in the shoppingcart
    echo '<form method="post">';
    echo "Delete from shoppingcart with Product ID:";
    echo '<select name="del">';
    foreach ($details as $key => $value) {
        echo "<option value=" . $value['product_id'] . ">" . $value['product_id'] . "</option>";
    }

    echo '</select>';
    echo '<input type="hidden"  name="formID" value=2>';
    echo '<br>';
    echo '<input type="submit" name="deleteCart" value="Delete Product">';
    echo '</form>';
    // Cookie can be used to store product ID and quantity of the products in the shopping cart. 

    $order = new buy;
    if (isset($_POST['confirm'])) {
        $checkout = $order->checkout();
    }

    if (isset($_POST['deleteCart'])) {
        deleteCart();
    }



    // Add a button for "Pay", when clicked, a form should appear for the customer to fill in his details, with a final button named "confirm Pay", which adds the order onto the database. 



    ?>
</body>

</html>