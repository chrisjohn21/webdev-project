<?php
include_once "./connection.php";
include_once "./Product.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="./homepage.css">
    <script src="./java/quantityUpdate.js"></script>
    <title>Crazy Whisk</title>
</head>
<body>

<div id="navbar">
    <img src="./bakery_icon.png" alt="Crazy Whisk Logo" id="logo">
    <a href="./homepage.php">Products</a>
    <a href="./transactions.php">Transactions</a>
    <a href="./userPage.php">Users</a>
    <a href="./loginUser.php">Log Out</a>
</div>
    <div class="container mt-4 vh-100">
    <h1 >Transactions</h1>
    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
    <table class="table table-striped table-bordered">
            <thead class="">
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
    </table>
</body>
</html>