
<?php
include_once "./connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['user_id'];
    $newPassword = $_POST['new_password'];

    // Perform additional validation as needed

    // Store the password in plaintext (not recommended for production)
    $plaintextPassword = $newPassword;

    // Debugging: Log input values
    error_log("User ID: $userId, New Password: $plaintextPassword");

    $updateSql = "UPDATE users SET password = '$plaintextPassword' WHERE id = $userId";

    if ($conn->query($updateSql) === TRUE) {
        // Password updated successfully
        echo json_encode(["status" => "success", "message" => "Password updated successfully"]);
    } else {
        // Error updating password
        $errorMessage = "Error updating password: " . $conn->error;
        error_log($errorMessage); // Debugging: Log error message
        echo json_encode(["status" => "error", "message" => $errorMessage]);
    }
}

$conn->close();
?>
