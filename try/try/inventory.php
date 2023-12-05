<?php
include_once "./connection.php";
include_once "./Product.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bakery Inventory System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./addProducts.js"></script>
    <script src="./quantityUpdate.js"></script>
    <link rel="stylesheet" href="./addProduct.css">
    <style>
        
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="#">Bakery Inventory</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse" id="navbarNav">
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 col-sm-12 d-md-block sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                    <li class="nav-item">
                         <a class="nav-link" href="#product-table">
                          Products
                        </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Transactions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Users
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 col-sm-12 ml-sm-auto col-lg-10 px-md-4 main-content">
                <h2>Product List</h2>
                <button id="addProductButton" class="btn btn-primary">Add Product</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
            // Fetch and display product information from the database
            $productList = Product::getAllProducts();
            if (!empty($productList)) {
                foreach ($productList as $product) {
                    echo '<tr>';
                    echo '<td>' . $product->getId() . '</td>';
                    echo '<td>' . $product->getName() . '</td>';
                    echo '<td>' . $product->getPrice() . '</td>';
                    echo '<td>' . $product->getDescription() . '</td>';
                    echo '<td id="quantity-' . $product->getId() . '">' . $product->getQuantity() . '</td>';
                    echo '<td><button onclick="updateQuantity(' . $product->getId() . ', \'in\')">In</button>';
                    echo ' <button onclick="updateQuantity(' . $product->getId() . ', \'out\')">Out</button></td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6">No products found</td></tr>';
            }
            ?>
            <?php
                $database = new Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$conn = $database->getConnection();

// Fetch and display transactions from the database
$query = "SELECT * FROM transactions ORDER BY created_at DESC";
$result = $conn->query($query);
            ?>
            <div class="container-fluid">
    <h2>Transactions Report</h2>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Action</th>
            <th>Quantity</th>
            <th>Timestamp</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['product_name'] . '</td>';
                echo '<td>' . $row['action'] . '</td>';
                echo '<td>' . $row['quantity'] . '</td>';
                echo '<td>' . $row['created_at'] . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="5">No transactions found</td></tr>';
        }
        ?>
        </tbody>
            </main>
            
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Your other scripts here -->
</body>
</html>
