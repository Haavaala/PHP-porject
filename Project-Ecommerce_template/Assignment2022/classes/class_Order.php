<?php
//array of every country in the world
$countries = array(
    "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua & Deps", "Argentina", "Armenia",
    "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium",
    "Belize", "Benin", "Bhutan", "Bolivia", "Bosnia Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria",
    "Burkina", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Central African Rep", "Chad", "Chile",
    "China", "Colombia", "Comoros", "Congo", "Congo {Democratic Rep}", "Costa Rica", "Croatia", "Cuba", "Cyprus",
    "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt",
    "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Fiji", "Finland", "France", "Gabon",
    "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana",
    "Haiti", "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland {Republic}", "Israel",
    "Italy", "Ivory Coast", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea North",
    "Korea South", "Kosovo", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya",
    "Liechtenstein", "Lithuania", "Luxembourg", "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali",
    "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia",
    "Montenegro", "Morocco", "Mozambique", "Myanmar, {Burma}", "Namibia", "Nauru", "Nepal", "Netherlands",
    "New Zealand", "Nicaragua", "Niger", "Nigeria", "Norway", "Oman", "Pakistan", "Palau", "Panama",
    "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Qatar", "Romania",
    "Russian Federation", "Rwanda", "St Kitts & Nevis", "St Lucia", "Saint Vincent & the Grenadines",
    "Samoa", "San Marino", "Sao Tome & Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles",
    "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa",
    "South Sudan", "Spain", "Sri Lanka", "Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syria",
    "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Togo", "Tonga", "Trinidad & Tobago", "Tunisia", "Turkey",
    "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States",
    "Uruguay", "Uzbekistan", "Vanuatu", "Vatican City", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"
);


class buy extends Database
{

    protected $date;
    protected $customer_id;

    public function checkout()
    {
        $database = new Database;
        $connection = $database->connect();
        $firstname = $_POST['Firstname'];
        $lastname = $_POST['Lastname'];
        $address = $_POST['Address'];
        $country = $_POST['Country'];
        if (!empty($_POST['Firstname']) && !empty($_POST['Lastname']) && !empty($_POST['Address']) && !empty($_POST['Country'])) {

            $query = "INSERT INTO customers(firstname, lastname, address, country) 
        VALUES ('$firstname', '$lastname', '$address', '$country');";
            $result = mysqli_query($connection, $query);
            // printing error message in case of query failure
            if (!$result) {
                die('Order failed!' . mysqli_error($connection));
            } else {
                $this->customer_id = mysqli_insert_id($connection);
                $this->retrieveOrder();
            }
        } else {
            echo "ALL FIELDS ARE REQUIRED";
        }
    }





    //retrieve product_id and quantity from the json file and insert it to the orders table
    public function retrieveOrder()
    {
        $database = new Database;
        $connection = $database->connect();
        $this->date = time();
        $file = 'shoppingCart.json';
        $oldCart = file_get_contents($file);
        $oldCarttxt = json_decode($oldCart, true);
        foreach ($oldCarttxt as $value) {
            $productID = $value['product_id'];
            $quantity = $value['quantity'];
            $query = "INSERT INTO orders(customer_id, product_id, time, quantity) 
            VALUES ('$this->customer_id', '$productID', '$this->date', '$quantity');";
            $result = mysqli_query($connection, $query);

            // printing error message in case of query failure
            if (!$result) {
                die('Order failed!' . mysqli_error($connection));
            } else {
                echo "New Order confirmed <br>";
                file_put_contents("shoppingCart.json", json_encode([]));
                setcookie("cart", 1, time() - 3600, "localhost", false, "httponly");
            }
        }
    }
}
