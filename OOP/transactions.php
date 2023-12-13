<?php
include_once "./connection.php";
include_once "./Product.php";

// Fetch transactions from the database
$query = "SELECT * FROM transactions ORDER BY created_at DESC";
$result = $conn->query($query);

// Check if there are transactions
$transactions = ($result && $result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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
        <h1>Transactions</h1>
        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Action</th>
                        <th>Quantity</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $transaction) : ?>
                        <tr>
                            <td><?= $transaction['product_name'] ?></td>
                            <td><?= $transaction['action'] ?></td>
                            <td><?= $transaction['quantity'] ?></td>
                            <td><?= $transaction['created_at'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
