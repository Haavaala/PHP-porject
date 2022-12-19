<?php
include_once "functions.php";
session_start();
displayNavBar();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ecommerce - Main Page </title>
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

    // Have a table to display current products
    $database = new Database;
    $connection = $database->connect();

    $display = $database->imageAndName('products');

    tableMain($display);



    ?>



</body>

</html>