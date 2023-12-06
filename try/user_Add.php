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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if the username already exists
    $checkSql = "SELECT * FROM users WHERE username='$username'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult === false) {
        // Query execution failed
        die("Error checking username: " . $conn->error);
    }

    if ($checkResult->num_rows > 0) {
        // Username already exists
        $_SESSION['registration_error'] = "Username already exists. Choose a different username.";
        header("Location: user.php?action=register");
        exit;
    }

    // Insert new user details into the database
    $insertSql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    // Log the SQL query
    error_log("SQL Query: " . $insertSql);

    if ($conn->query($insertSql) === TRUE) {
        // Registration successful
        $_SESSION['username'] = $username;
        header("Location: inventory.php");
        exit;
    } else {
        // Registration failed
        $_SESSION['registration_error'] = "Registration failed. Please try again. Error: " . $conn->error;
        error_log("Error: " . $conn->error);
        header("Location: user.php?action=register");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>

<body>
    <h2>Register</h2>

    <?php
    if (isset($_SESSION['registration_error'])) {
        echo "<p style='color: red;'>{$_SESSION['registration_error']}</p>";
        unset($_SESSION['registration_error']);
    }
    ?>

    <form method="post" action="user.php?action=register">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <input type="submit" name="register" value="Register">
    </form>
</body>

</html>
