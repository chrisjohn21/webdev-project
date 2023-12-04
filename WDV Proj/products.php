<?php
// products.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bakery_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a search query is provided
if (isset($_GET['search'])) {
    $keyword = $conn->real_escape_string($_GET['search']);
    $keyword = str_replace(' ', '', $keyword); // Remove spaces from the search keyword
    $sql_search_products = "SELECT * FROM product_tbl WHERE LOWER(REPLACE(product_name, ' ', '')) LIKE LOWER('%$keyword%')";
    $result_products = $conn->query($sql_search_products);
} else {
    // Retrieve all products if no search query
    $sql_select_products = "SELECT * FROM product_tbl";
    $result_products = $conn->query($sql_select_products);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/products.css">
    <link rel="stylesheet" href="/common.css">
    <script src="/search.js"></script>
    <title>Products</title>
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
    <div class="search-bar">
    <form id="searchForm" action="#" method="get">
        <label for="search">Search:</label>
        <input type="text" id="search" name="search" placeholder="Enter keyword...">
        <input type="submit" value="Search">
    </form>
</div>

        <h2>Product List</h2>

        <?php
        if ($result_products->num_rows > 0) {
            while ($row = $result_products->fetch_assoc()) {
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
            echo '<p>No products available</p>';
        }
        ?>
    </div>
</body>
</html>
