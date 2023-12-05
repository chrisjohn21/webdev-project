<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bakery_inventory";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Login processing
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Login successful
        $_SESSION['username'] = $username;
        header("Location: inventory.php"); // Redirect directly to inventory.php
        exit;
    } else {
        // Login failed
        $_SESSION['login_error'] = "Invalid username or password";
        header("Location: user.php?action=login");
        exit;
    }
}

// Logout processing
if (isset($_GET["action"]) && $_GET["action"] == "logout") {
    session_destroy();
    header("Location: user.php?action=login");
    exit;
}

// Display content based on user's login status
if (isset($_SESSION['username'])) {
    // User is logged in, redirect to inventory.php
    header("Location: inventory.php");
    exit;
} else {
    // User is not logged in, show the login form
    echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>User Login</title>
        </head>
        <body>
            <h2>Login</h2>";

    if (isset($_SESSION['login_error'])) {
        echo "<p style='color: red;'>{$_SESSION['login_error']}</p>";
        unset($_SESSION['login_error']);
    }

    echo "<form method='post' action='user.php?action=login'>
            <label for='username'>Username:</label>
            <input type='text' name='username' required><br>
            <label for='password'>Password:</label>
            <input type='password' name='password' required><br>
            <input type='submit' name='login' value='Login'>
        </form>
        </body>
        </html>";
}
?>
