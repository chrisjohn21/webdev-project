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
    <script src="./users.js"></script>
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
<h1  id="products">User List</h1>
<button id="addUserButton" class="btn custom-bg-gradient mb-3" style="font-weight: bold; font-size:20px;">Add User</button>
<div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
<table class="table table-striped table-bordered">
    <thead>
        <tr>    
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
                echo '<td>' . $user['username'] . '</td>';
                echo '<td>' . str_repeat('*', strlen($user['password'])) . '</td>';
                echo '<td>
                <button class="btn btn-sm btn-primary" onclick="editPassword(' . $user['id'] . ')">Edit Password</button>
                <button class="btn btn-sm btn-danger" onclick="deleteUser(' . $user['id'] . ')">Delete User</button>
                </td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="4">No users found</td></tr>';
        }
        ?>
    </tbody>
</table>
<script>
    //adding a new user
    document.getElementById('addUserButton').addEventListener('click', function() {
        
        Swal.fire({
            title: 'Add User',
            html:
                '<input id="swal-input1" class="swal2-input" placeholder="Username">' +
                '<input id="swal-input2" class="swal2-input" type="password" placeholder="Password">',
            focusConfirm: false,
            preConfirm: () => {
                const newUsername = Swal.getPopup().querySelector('#swal-input1').value;
                const newPassword = Swal.getPopup().querySelector('#swal-input2').value;

                // Perform AJAX request to add user
                $.ajax({
                    url: './addUser.php',
                    type: 'GET',
                    data: {
                        new_username: newUsername,
                        new_password: newPassword
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Success', response.message, 'success');
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'An error occurred during the request.', 'error');
                    }
                });
            }
        });
    });
</script>
<script>
    // Add this JavaScript function for handling password edits
    function editPassword(userId) {
        Swal.fire({
            title: 'Edit Password',
            input: 'password',
            inputLabel: 'New Password',
            showCancelButton: true,
            confirmButtonText: 'Save',
            preConfirm: (newPassword) => {
                // Return the promise for the AJAX request
                return $.ajax({
                    url: './editPassword.php',
                    type: 'POST',
                    data: {
                        user_id: userId,
                        new_password: newPassword
                    },
                    dataType: 'json'
                });
            }
        }).then((result) => {
    console.log('SweetAlert callback executed');
    console.log(result.value); // Log the response
    if (result.isConfirmed && result.value && result.value.status === 'success') {
        Swal.fire('Password Changed', result.value.message, 'success');
        // You can optionally reload the page or update the UI here
    } else {
        Swal.fire('Error', 'An error occurred during the password update.', 'error');
    }
});

    }
</script>
</body>
</html>
