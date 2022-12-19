<?php
require_once "class_Database.php";

echo "In class: Product<br>";

class Product extends Database{
    // properties example, add more properties if needed
    protected $product_Name;
    protected $description;
    
    
    // a method example, add other methods if needed. 
    protected function addProductToDB(){
        
    }
    
    public function showProduct($productID)
{
    $database = new Database;
    $connection = $database->connect();

    $query = "SELECT * FROM products WHERE product_id = $productID;";

    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Query Failed!" . mysqli_error($connection));
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $product_name = $row['product_name'];
            $image_name = $row['image_name'];
            $description = $row['description'];
            $price = $row['price'];
            echo "<div class='product'>";
            echo "<h2>$product_name</h2>";
            echo "<img src='./pic/$image_name' alt='product image width='200' height='200''>";
            echo "<p>$description</p>";
            echo "<p>Price: $price</p>";
            echo "</div>";
        }
    }
}

//function for adding the order to the json file
function addToCart($productID, $quantity)
{
    $quantity = $_POST['quantity'];
    $file = 'shoppingCart.json';
    $temp = array();
    $cart = [
        'product_id' => $productID,
        'quantity' => $quantity
    ];
    
    if (file_exists($file) && file_get_contents($file) != NULL && file_get_contents($file) != "") {
        $oldCart = file_get_contents($file);
        $oldCarttxt = json_decode($oldCart, true);
        array_push($oldCarttxt, $cart);
        $shoppingCart = json_encode($oldCarttxt);
    } else {
        array_push($temp, $cart);
        $shoppingCart = json_encode($temp);
    }
    file_put_contents($file, $shoppingCart);
}


}

