<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $servername = "localhost";
    $username_db = "root";
    $password_db = "";
    $dbname = "bakery_inventory";

    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $checkSql = "SELECT * FROM users WHERE username='$username'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult === false) {
        die("Error checking username: " . $conn->error);
    }

    if ($checkResult->num_rows > 0) {
        $_SESSION['registration_error'] = "Username already exists. Choose a different username.";
        header("Location: register.php");
        exit;
    }

    $insertSql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    // Log the SQL query
    error_log("SQL Query: " . $insertSql);

    if ($conn->query($insertSql) === TRUE) {
        $_SESSION['registration_success'] = "Registration successful. You can now log in.";
        header("Location: inventory.php");
        exit;
    } else {
        $_SESSION['registration_error'] = "Registration failed. Please try again. Error: " . $conn->error;
        error_log("Error: " . $conn->error);
        header("Location: register.php");
        exit;
    }

    $conn->close();
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

    if (isset($_SESSION['registration_success'])) {
        echo "<p style='color: green;'>{$_SESSION['registration_success']}</p>";
        unset($_SESSION['registration_success']);
    }
    ?>

    <form method="post" action="register.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <input type="submit" name="register" value="Register">
    </form>
</body>

</html>
