<?php
include_once "./connection.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Login successful
        $_SESSION['username'] = $username;
        header("Location: ./homepage.php"); // Redirect to a welcome page
    } else {
        // Login failed
        $error = "Invalid username or password";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="userLogin.css">
    <link rel="icon" href="/images/bakery_icon.jpg" type="image/x-icon">
</head>
<body>

<div class="container">
    <form id="loginForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div id="logo-container">
            <img src="./bakery_icon.png" alt="Crazy Whisk Logo" id="login-logo">
        </div>
        <h2>Inventory Management Login</h2>

        <?php
        if (isset($error)) {
            echo '<p class="error">' . $error . '</p>';
        }
        ?>

        <label for="username">Username:</label>
        <input type="text" name="username" placeholder="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="password" required><br>

        <input type="submit" value="Login">
    </form>
</div>

</body>
</html>