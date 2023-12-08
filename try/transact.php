<?php
include_once "./connection.php";
include_once "./Product.php";
include_once "./user.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Crazy Whisk Inventory System</title>
    <link rel="icon" href="/images/bakery_icon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="./addProducts.js"></script>
    <script src="./quantityUpdate.js"></script>
    <script src="./deleteProduct.js"></script>
    <script src="./addUser.js"></script>
    <link rel="stylesheet" href="./addProduct.css">
    <style>
        body {
            background: linear-gradient( #6DB9EF, #00BFFF);
            padding-left: 250px; 
        }
            /* Style for custom scrollbar */
        ::-webkit-scrollbar {
            width: 12px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #87C4FF;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>
<body>
<body style="padding-top: 0px;">
<div class="container-fluid" >
        <div class="row">
            <nav class="col-md-2 col-sm-12  sidebar" style="background-color:#96EFFF;">
                <div class="sidebar-sticky" >
                    <!-- Move the upper navbar content here -->
                    <h5 class="navbar-brand" style="color: #3498db; font-size: 32px; font-weight: bold;">Crazy Whisk<br> Inventory</h5>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <ul class="nav flex-column"  >
                        <li class="nav-item">
                            <a class="nav-link" href="inventory.php">Products</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="transact.php">Transactions</a>
                            </li>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="#UsersList">Users</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="userLogin.php?action=logout">
                                Log Out
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

                <!-- Transactions Report Table -->
                <div class="container-fluid mt-4">
                    <br><br><h2 id="transactions" class="bg-primary text-white p-3">Transactions Report</h2><br>
                    <!-- Wrap the table in a div with the table-responsive class -->
                    <div class="table-responsive" style="max-height: 400px; min-height: 490px; overflow-y: auto;">
                            <table class="table table-striped table-bordered">
                            <thead class="thead-secondary bg-info">
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
