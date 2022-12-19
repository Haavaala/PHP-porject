<?php
include_once "functions.php";

displayNavBar();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ecommerce - Admin Area </title>
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
</head>

<body>

    <?php
    $empty = emptyFields();

    
    // Have a table to display current products
    $database = new Database;
    $connection = $database->connect();

    $prod = $database->readFromTable('products');

    createTable($prod);
    // Add a form  to create a new product
    echo "<br>";
    echo '<form action="adminPage.php" name="myForm" method="POST">';
    echo 'Add image: <input type="file" name="uploadFile" id="fileToUpload">';
    echo "<br>";
    echo 'Product Name: <input type= "text" name= "product_name">';
    echo "<br>";
    echo 'Product Description: <input type= "text" name= "description">';
    echo "<br>";
    echo 'Price: <input type= "text" name= "price">';
    echo "<br>";
    echo ' <input type="submit" name="submit" value="Add Product">';
    echo '</form>';

    if ($empty) {
        echo "Form submitted successfully";
    } else {
        echo "All fields are required";
    }

    echo '<form method="post">';
    echo "Delete Product with Product ID:";
    echo '<select name="id" id="">';

    foreach ($prod as $item) {
        echo   $id = $item['product_id'];
        echo '<option name=" . $id . ">';
        echo $id . "</option>";
    }

    echo '</select>';
    echo '<input type="hidden"  name="formID" value=2>';
    echo '<input type="submit" name="delete" value="Delete Product">';

    echo '</form>';
    // Add functionality to delete an existing product
    if (isset($_POST['delete'])) {
        $productID = $_POST['id'];
        deleteOrder($productID);
    }
    
    $filterBetween = array("Country", "Time");
    //form that filters from the table from database
    echo '<form method="post">';
    echo "Filter from";
    echo "<select name='Sort'>";
    echo "<option value=''>Filter</option>";
    foreach ($filterBetween as $key => $value) {
        echo "<option value='$value'>$value</option>";
    }
    echo "</select>";
    echo '<input type="hidden" name="formID" value=2>';
    echo '<input type="submit" name="filter" value="Choose filter">';

    echo '</form>';



    //add a table to display current orders and the customers who made them
    if (isset($_POST['filter'])) {
        if ($_POST['Sort'] === $filterBetween[0]) {
            $sortCountry = sortCountry();
            createTable($sortCountry);
        } elseif ($_POST['Sort'] === $filterBetween[1]) {
            $sortTime = sortTime();
            createTable($sortTime);
        } else {
            $Join = createJoin();
            createTable($Join);
        }
    }




    ?>




</body>

</html>