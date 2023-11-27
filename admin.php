<!-- admin.php -->
<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bakery_database";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Retrieve admin credentials from the database
    $sql = "SELECT * FROM admins WHERE username = '$input_username' AND password = '$input_password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin.php');
        exit();
    } else {
        $error_message = 'Invalid username or password';
    }
}

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    // Display the login form
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>

    <header>
    <nav>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="product.html">Products</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Admin</a></li>
        </ul>
    </nav>
    <h1>Admin Dashboard</h1>
</header>
<main>
    <div class="login-panel">
        <h2>Admin Login</h2>
        <?php if (isset($error_message)) echo '<p>' . $error_message . '</p>'; ?>
        <form action="admin.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            
            <button type="submit">Login</button>
        </form>
    </div>
</main>
    </body>
    </html>
    <?php
    exit();
}

// Display the admin dashboard
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Welcome, Admin!</h2>
    <a href="admin.php?action=logout">Logout</a>

    <h3>Order List</h3>
    <!-- Display order list here -->

    <!-- You can fetch and display orders from the database here -->
</body>
</html>
<?php

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['admin_logged_in']);
    header('Location: admin.php');
    exit();
}
?>
