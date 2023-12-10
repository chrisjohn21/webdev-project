<?php
include_once "./connection.php";

// Retrieve data from the POST request
$name = $_POST['name'];
$price = $_POST['price'];
$description = $_POST['description'];
$quantity = $_POST['quantity'];

// Perform validation as needed

// Add the product to the database
$database = new Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$conn = $database->getConnection();

$query = "INSERT INTO products (name, price, description, quantity) VALUES ('$name', $price, '$description', $quantity)";
$result = $conn->query($query);

if ($result) {
    echo "Product added successfully!";
} else {
    echo "Error: " . $conn->error;
}

// Close the database connection
$conn->close();
?>