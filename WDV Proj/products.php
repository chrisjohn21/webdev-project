<?php
// products.php

// Database connection (similar to admin.php)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bakery_database";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve products from the product_tbl table
$sql_select_products = "SELECT * FROM product_tbl";
$result_products = $conn->query($sql_select_products);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/products.css">
    <link rel="stylesheet" href="/common.css">
    <title>Products</title>
    <script src="/search.js"></script>
</head>
<body>
<header class="product">
    <nav>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="admin.php">Admin</a></li>
        </ul>
    </nav>
    <h1>Products</h1>
</header> 
    
<div class="product-list-container">
    <h2>Product List</h2>

    <?php
    // Display product information
    if ($result_products->num_rows > 0) {
        while ($row = $result_products->fetch_assoc()) {
            echo '<div>';
            echo '<h3>' . $row['product_name'] . '</h3>';
            echo '<p>' . $row['product_desc'] . '</p>';
            echo '<p>Price: $' . $row['product_price'] . '</p>';
            echo '<img src="data:image/jpeg;base64,' . $row['product_photo'] . '" alt="Product Image" style="max-width: 200px;">'; // Change this line to display the image correctly
            echo '</div>';
        }
    } else {
        echo '<p>No products available</p>';
    }
    ?>
</body>
</html>