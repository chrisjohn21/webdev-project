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
<body style="padding-top: 56px;">
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
                            <a class="nav-link" href="#product-table">Products</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="transact.php">Transactions</a>
                            </li>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="#UsersList">Users</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="userLogin.php">
                                Log Out
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 col-sm-12 ml-sm-auto col-lg-10 px-md-4 main-content">
                <h2 id="product-table" class="bg-primary text-white p-3">Product List</h2><br>
                <button id="addProductButton" class="btn btn-primary mb-3">Add Product</button>
                <div class="table-responsive" style="max-height: 450px; min-height: 430px; overflow-y: auto;">
                         <table class="table table-striped table-bordered" style="font-size: 16px;">
                        <thead class="thead-secondary bg-info">
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
                                        echo '<td>₱ ' . $product->getPrice() . '</td>';
                                        echo '<td>' . $product->getDescription() . '</td>';
                                        echo '<td id="quantity-' . $product->getId() . '">' . $product->getQuantity() . '</td>';
                                        echo '<td>
                                                <button class="btn btn-sm btn-success" onclick="updateQuantity(' . $product->getId() . ', \'in\')">In</button>
                                                <button class="btn btn-sm btn-danger" onclick="updateQuantity(' . $product->getId() . ', \'out\')">Out</button>
                                                <button class="btn btn-sm btn-warning" onclick="confirmDelete(' . $product->getId() . ', \'' . $product->getName() . '\')">Delete</button>
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

                <div class="container-fluid mt-4">
        <br><br><h2 id="UsersList" class="bg-primary text-white p-3">Users List</h2><br>
        <button id="addUserButton" class="btn btn-primary mb-3" onclick="addUser()">Add User</button>
        <div class="table-responsive" style="max-height: 400px; min-height: 430px; overflow-y: auto;">
            <table class="table table-striped table-bordered">
                <thead class="thead-secondary bg-info">
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch and display user information from the database
                    $userList = getAllUsers();

                    if (!empty($userList)) {
                        foreach ($userList as $user) {
                            echo '<tr>';
                            echo '<td>' . $user->getId() . '</td>';
                            echo '<td>' . $user->getUsername() . '</td>';
                            echo '<td>' . str_repeat('*', strlen($user->getPassword())) . '</td>';
                            echo '<td>
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal" data-userid="' . $user->getId() . '">Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="confirmDelete(' . $user->getId() . ', \'' . $user->getUsername() . '\')">Delete</button>
                            </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="3">No users found</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Edit Password Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editUserId">
                <label for="editPassword">New Password:</label>
                <input type="password" class="form-control" id="editPassword">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="editPassword()">Save changes</button>
            </div>
        </div>
    </div>
</div>

            </main>
        </div>
    </div>
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var userId = button.data('userid');
            $('#editUserId').val(userId);
        });

        function editPassword() {
            var userId = $('#editUserId').val();
            var newPassword = $('#editPassword').val();

            // AJAX request for password update
            $.ajax({
                type: "POST",
                url: "./updateUser.php", // Replace with the actual server-side file handling password update
                data: { userId: userId, newPassword: newPassword },
                success: function (response) {
                    alert('Password updated!');
                    // Optionally, you can reload the page or update the user list here
                    $('#editModal').modal('hide');
                },
                error: function () {
                    alert('Error updating password!');
                }
            });
        }
    </script>
</body>
</html>
