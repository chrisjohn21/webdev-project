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
<body style="padding-top: 56px;">
<div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 col-sm-12 bg-light sidebar">
                <div class="sidebar-sticky">
                    <!-- Move the upper navbar content here -->
                    <h5 class="navbar-brand">Bakery Inventory</h5>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Home</a>
                            </li>
                            <!-- Add your other navbar items here -->
                        </ul>
                    </div>
                    <!-- End of upper navbar content -->

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#product-table">Products</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="#transactions">Transactions</a>
                            </li>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="user.php?action=logout">
                                Log Out
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 col-sm-12 ml-sm-auto col-lg-10 px-md-4 main-content">
                <h2 id="product-table">Product List</h2>
                <button id="addProductButton" class="btn btn-primary mb-3">Add Product</button>
                
                <!-- Wrap the table in a div with the table-responsive class -->
                <div class="table-responsive" style="max-height: 450px; min-height: 430px; overflow-y: auto;">
                         <table class="table table-striped table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // Fetch and display product information from the database
                                $productList = Product::getAllProducts();
                                if (!empty($productList)) {
                                    foreach ($productList as $product) {
                                        echo '<tr>';
                                        echo '<td>' . $product->getName() . '</td>';
                                        echo '<td>' . $product->getPrice() . '</td>';
                                        echo '<td>' . $product->getDescription() . '</td>';
                                        echo '<td id="quantity-' . $product->getId() . '">' . $product->getQuantity() . '</td>';
                                        echo '<td>
                                                <button class="btn btn-sm btn-success" onclick="updateQuantity(' . $product->getId() . ', \'in\')">In</button>
                                                <button class="btn btn-sm btn-danger" onclick="updateQuantity(' . $product->getId() . ', \'out\')">Out</button>
                                            </td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="6">No products found</td></tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- ... Your existing code ... -->

                <!-- Transactions Report Table -->
                <div class="container-fluid mt-4">
                    <br><br><h2 id="transactions">Transactions Report</h2><br>
                    <!-- Wrap the table in a div with the table-responsive class -->
                    <div class="table-responsive" style="max-height: 400px; min-height: 430px; overflow-y: auto;">
                            <table class="table table-striped table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Product Name</th>
                                    <th>Action</th>
                                    <th>Quantity</th>
                                    <th>Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // Fetch and display transactions from the database
                                    $query = "SELECT * FROM transactions ORDER BY created_at DESC";
                                    $result = $conn->query($query);

                                    if ($result && $result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<tr>';
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
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Your other scripts here -->
</body>
</html>
