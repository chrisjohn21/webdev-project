<?php
include_once "./connection.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $newUsername = isset($_GET['new_username']) ? trim($_GET['new_username']) : '';
    $newPassword = isset($_GET['new_password']) ? trim($_GET['new_password']) : '';

    // Check if both username and password are not empty
    if (empty($newUsername) || empty($newPassword)) {
        echo json_encode(["status" => "error", "message" => "Username and password cannot be empty"]);
        exit();
    }

    // Perform additional validation as needed

    // Store the password in plaintext (not recommended for production)
    $plaintextPassword = $newPassword;

    $insertSql = "INSERT INTO users (username, password) VALUES ('$newUsername', '$plaintextPassword')";

    if ($conn->query($insertSql) === TRUE) {
        // User added successfully
        echo json_encode(["status" => "success", "message" => "User added successfully"]);
    } else {
        // Error adding user
        $errorMessage = "Error adding user: " . $conn->error;
        error_log($errorMessage); // Add this line for debugging
        echo json_encode(["status" => "error", "message" => $errorMessage]);
    }
}

$conn->close();
?>
