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
        <link rel="stylesheet" href="common.css">
        <link rel="stylesheet" href="admin.css">
    </head>
    <body>

    <header>
    <nav>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="products.php">Products</a></li>
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
    <link rel="stylesheet" href="style.css">
    <title>Admin Dashboard</title>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Admin</a></li>
        </ul>
    </nav>
    <h2>Welcome Admin!</h2>
</header>
    <form action="admin.php?action=logout" method="post">
        <button type="submit" name="logout">Logout</button>
    </form>

    <h3>Order List</h3>
    <!-- Display order list here -->

    <!-- You can fetch and display orders from the database here -->
    <?php
    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        // Get product details from the form
        $product_name = $_POST['product_name'];
        $product_description = $_POST['product_description'];
        $product_price = $_POST['product_price'];

        // Check if a file is selected for upload
        if (isset($_FILES['product_image'])) {
            $product_image = file_get_contents($_FILES['product_image']['tmp_name']); // Read the image file
            $product_image = base64_encode($product_image); // Convert to base64 for database storage

            // Insert product data into the product_tbl table
            $sql_insert_product = "INSERT INTO product_tbl (product_name, product_desc, product_price, product_photo) VALUES ('$product_name', '$product_description', $product_price, '$product_image')";
            
            if ($conn->query($sql_insert_product) === TRUE) {
                echo '<p>Product uploaded successfully!</p>';
            } else {
                echo '<p>Error uploading product: ' . $conn->error . '</p>';
            }
        } else {
            echo '<p>No image selected for upload</p>';
        }
    }
    ?>

<form action="admin.php" method="post" enctype="multipart/form-data">
    <label for="product_name">Product Name:</label>
    <input type="text" id="product_name" name="product_name" required><br>
    
    <label for="product_description">Product Description:</label>
    <textarea id="product_description" name="product_description" required></textarea><br>
    
    <label for="product_price">Product Price:</label>
    <input type="number" id="product_price" name="product_price" step="0.01" required><br>
    
    <label for="product_image">Product Image:</label>
    <input type="file" id="product_image" name="product_image" required><br>
    
    <button type="submit" name="submit">Upload Product</button>
</form>
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
