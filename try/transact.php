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
            background: linear-gradient( #FFBB5C, #E25E3E);
            padding-left: 220px; 
        }

            /* Style for custom scrollbar */
        ::-webkit-scrollbar {
            width: 12px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #FFBB5C;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #C63D2F;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>
<body>
<body>
<div class="container-fluid" >
        <div class="row">
            <nav class="col-md-2 col-sm-12  sidebar" style="background-color:#FFC47E; ">
                <div class="sidebar-sticky" >
                    <!-- Move the upper navbar content here -->
                    <h5 class="navbar-brand" style="font-size: 32px; font-weight: bold; color: #6B240C ;text-shadow: 4px 4px 8px rgba(0, 0, 0, 0.8)">Crazy Whisk<br> Inventory</h5>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <ul class="nav flex-column"  >
                        <li class="nav-item" >
                            <a class="nav-link" href="inventory.php" style="color:#6B240C; font-weight:bold;">Products</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="transact.php" style="color:#6B240C; font-weight:bold;">Transactions</a>
                            </li>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="inventory.php#UsersList" style="color:#6B240C; font-weight:bold;">Users</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="userLogin.php?action=logout" style="color:#6B240C; font-weight:bold;">Log Out
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

                <!-- Transactions Report Table -->
                <div class="container-fluid mt-4">
                    <h2 id="transactions" class="custom-bg-gradient p-3">Transactions Report</h2><br>
                    <!-- Wrap the table in a div with the table-responsive class -->
                    <div class="table-responsive" style="max-height: 400px; min-height: 450px; overflow-y: auto;">
                            <table class="table table-striped table-bordered">
                            <thead class="custom-bg-gradient p-3">
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
                <style>
                  /* Add your gradient styles here */
                     .custom-bg-gradient {
                         background: linear-gradient(to right, #C63D2F, #FF9B50);
                        color: white; /* Set the text color to white or another suitable color */
                         padding: 1rem; /* Adjust the padding as needed */
                         }
                             </style>
