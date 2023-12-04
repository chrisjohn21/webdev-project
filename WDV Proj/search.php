<?php
// search.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bakery_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search keyword from the AJAX request
$keyword = $_GET['keyword'];

// Use the keyword in your SQL query to fetch search results
$sql_search_products = "SELECT * FROM product_tbl WHERE product_name LIKE '%$keyword%' OR product_desc LIKE '%$keyword%'";
$result_search = $conn->query($sql_search_products);

// Display the search results
if ($result_search->num_rows > 0) {
    while ($row = $result_search->fetch_assoc()) {
        echo '<div class="product-item">';
        echo '<img src="data:image/jpeg;base64,' . $row['product_photo'] . '" alt="Product Image">';
        echo '<div class="product-info">';
        echo '<h3>' . $row['product_name'] . '</h3>';
        echo '<p>' . $row['product_desc'] . '</p>';
        echo '<p>Price: $' . $row['product_price'] . '</p>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p>No products found</p>';
}

$conn->close();
?>
