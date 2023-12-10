<?php
include_once "./connection.php";
include_once "./Product.php";
include_once "./users.php";
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
    <a href="./homepage.php#product">Products</a>
    <a href="./transactions.php">Transactions</a>
    <a href="./userPage.php">Users</a>
    <a href="./loginUser.php">Log Out</a>
</div>
<div class="container mt-4 vh-100">
<h1  id="products">Transactions</h1>
<div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Password</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Fetch and display user information from the database
        $userList = getAllUsers();

        if (!empty($userList)) {
            foreach ($userList as $user) {
                echo '<tr>';
                echo '<td>' . $user['id'] . '</td>';
                echo '<td>' . $user['username'] . '</td>';
                echo '<td>' . str_repeat('*', strlen($user['password'])) . '</td>';
                echo '<td>
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal" data-userid="' . $user['id'] . '">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="confirmDelete(' . $user['id'] . ', \'' . $user['username'] . '\')">Delete</button>
                </td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="4">No users found</td></tr>';
        }
        ?>
    </tbody>
</table>
</body>
</html>
