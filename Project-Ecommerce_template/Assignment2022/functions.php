<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
</body>
</html>
<?php
require_once 'classes/class_Database.php';


function displayNavBar()
{
    $shopping = 'ShoppingCart.json';
    $cart = json_decode(file_get_contents($shopping), true);
    $count = count($cart);
    session_start();
    echo "<header>";
    echo "<nav>";
    echo "<a href='mainPage.php'>Home</a>  ";
    echo "<a href='shoppingCart.php'>Shopping Cart (" . $count . ") </a>";
    echo "<a href='login.php'>Log in</a> ";
    
    
    if (isset($_SESSION['isloggedin'])) {
        if ((isset($_SESSION['name'])) && ($_SESSION['role'] == '0')) {
            echo "<a href='adminPage.php'>Admin Page</a>  ";
            echo "<form method='post'>";
            echo "<input type='submit' value='LogOut' name='logOut'>";
            echo "</form>";
            
        } else {
            echo "<form method='post'>";
            echo "<input type='submit' value='LogOut' name='logOut'>";
            echo "</form>";
            
        }
    } 
    
    echo "</nav>";
    echo "</header>";
    echo "<br><br>";
}

// log out
if (isset($_POST['logOut'])) {
    // Unset all of the session variables.
    $_SESSION = array();
    // delete the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    // Finally, destroy the session.
    session_destroy();
    // direct user to login page after logout
    header('Location: login.php');
}

// function to read file and return headers and entries
function readThisFile($filename)
{
    //echo "In readThisFile <br>";

    $file = fopen($filename, "r") or die("Unable to open file");

    //Output one line until end-of-file
    $idx = 0;
    while (!feof($file)) {

        if ($idx == 0) {
            $headersArray = fgetcsv($file);
        } else {
            $line = fgetcsv($file);

            if (!(is_null($line[1]))) {
                $valuesArray[$idx - 1] = $line;
            }
        }

        $idx++;
    }

    fclose($file);

    return array(
        'headersArray' => $headersArray,
        'valuesArray' => $valuesArray
    );
}

// creates a 2 dimensional associative array, given a headers array and a values array. 
function createAssocArray($headersArray, $valuesArray)
{
    // create an associative Array given headers and Values
    foreach ($valuesArray as $item => $value) {
        //print_r($item);print_r($value);echo "<br>";
        $idx = 0;
        foreach ($headersArray as $key) {
            $resArray[$item][$key] = $value[$idx];
            $idx++;
        }
    }

    return $resArray;
}


// take an associative array as input and creates a table from it. 
function createTable($resArray)
{
    echo "<table>";
    $isFirstRow = False;
    foreach ($resArray as $item) {

        if ($isFirstRow == FALSE) {
            // first print headers
            echo "<tr>";
            foreach ($item as $key => $value) {
                echo "<th> $key </th>";
            }
            echo "</tr>";

            //then print first row of values
            echo "<tr>";
            foreach ($item as $key => $value) {
                if ($key === "image_name") {
                    echo '<td><img src="pic/' . $value . '" width="100px" height="100px"></td>';
                } else {
                    echo "<td>$value</td>";
                }
            }
            echo "</tr>";

            $isFirstRow = TRUE;
        } else {
            // then print every subsequent row of values
            echo "<tr>";
            foreach ($item as $key => $value) {
                if ($key === "image_name") {
                    echo '<td><img src="pic/' . $value . '"width="100px" height="100px"></td>';
                } else {
                    echo "<td>$value</td>";
                }
                // echo "<td> '<a href=" . "./productPage.php=" . $value . ">$value</a>';</td>";
            }
            echo "</tr>";
        }
    }
    echo "</table>";
}

function tableMain($resArray)
{
    echo "<table>";
    $isFirstRow = False;
    foreach ($resArray as $item) {

        if ($isFirstRow == FALSE) {
            // first print headers
            echo "<tr>";
            foreach ($item as $key => $value) {
                if ($key === 'product_name' or $key === 'image_name') {
                    echo "<th> $key </th>";
                }
            }
            echo "</tr>";

            //then print first row of values
            echo "<tr>";
            foreach ($item as $key => $value) {
                if ($key === "image_name") {
                    echo '<td><img src="pic/' . $value . '" width="100px" height="100px"></td>';
                } else if ($key === 'product_name') {
                    echo "<td> <a href=" . "./productPage.php?product_id=" . $item['product_id'] . ">$value</a></td>";
                }
            }
            echo "</tr>";

            $isFirstRow = TRUE;
        } else {
            // then print every subsequent row of values
            echo "<tr>";
            foreach ($item as $key => $value) {
                if ($key === "image_name") {
                    echo '<td><img src="pic/' . $value . '"width="100px" height="100px"></td>';
                } else if ($key === 'product_name') {
                    echo "<td> <a href=" . "./productPage.php?product_id=" . $item['product_id'] . ">$value</a></td>";
                }
            }
            echo "</tr>";
        }
    }
    echo "</table>";
}




//function for adding a new product to the database and check if there are any empty fields
function emptyFields()
{
    $database = new Database;
    $connection = $database->connect();

    if (isset($_POST['submit'])) {
        $ProdImg = $_POST['uploadFile'];
        $ProdName = $_POST['product_name'];
        $ProdDesc = $_POST['description'];
        $Price = $_POST['price'];
        if (!empty($_POST['uploadFile']) && !empty($_POST['product_name']) && !empty($_POST['description']) && !empty($_POST['price'])) {

            $query = "INSERT INTO products(product_name, image_name, description, price) 
            VALUES('$ProdName', '$ProdImg', '$ProdDesc','$Price')";

            $run = mysqli_query($connection, $query) or die(mysqli_error($connection));

            if ($run) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

//function for deleting product based on the specific id from the database
function deleteOrder($productID)
{
    $database = new Database;
    $connection = $database->connect();

    // making the query to be sent to database
    $query = "DELETE FROM products ";
    // where to delete them 
    $query .= " WHERE product_id = $productID ";

    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("Query Failed!" . mysqli_error($connection));
    } else {
        echo "Product Entry Deleted!<br>";
    }
}

//function for joining the customers and orders table from the database
function createJoin()
{
    $database = new Database;
    $connection = $database->connect();

    $query = "SELECT * FROM customers 
    INNER JOIN orders ON customers.customer_id = orders.customer_id";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("Query Failed!" . mysqli_error($connection));
    } else {
        return $result;
    }
}

//function for sorting time in ascending order
function sortTime()
{
    $database = new Database;
    $connection = $database->connect();

    $query = "SELECT * FROM customers 
    INNER JOIN orders on customers.customer_id = orders.customer_id
    ORDER BY time asc";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("Query Failed!" . mysqli_error($connection));
    } else {
        return $result;
    }
}
//function for creating a table with sort asc for countries
function sortCountry()
{
    $database = new Database;
    $connection = $database->connect();

    $query = "SELECT * FROM customers 
    Inner JOIN orders ON customers.customer_id = orders.customer_id
    ORDER BY country asc";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("Query Failed!" . mysqli_error($connection));
    } else {
        return $result;
    }
}



//delete from json file based on the product id
function deleteCart()
{
    $deleteID = $_POST["del"];
    $file = 'shoppingCart.json';
    $oldCart = file_get_contents($file);
    $oldCarttxt = json_decode($oldCart, true);
    $emptyArray = array();
    $i = 0;
    foreach ($oldCarttxt as $key => $value) {
        if ($value['product_id'] == $deleteID) {
            $emptyArray[] = $key;
        }
        $i++;
    }

    foreach ($emptyArray as $keyEmpty) {
        unset($oldCarttxt[$keyEmpty]);
    }


    file_put_contents("shoppingCart.json", json_encode($oldCarttxt));
}

