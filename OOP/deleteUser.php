<?php
include_once "./connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['user_id'];

    // Perform additional validation as needed

    $deleteSql = "DELETE FROM users WHERE id = $userId";

    if ($conn->query($deleteSql) === TRUE) {
        // User deleted successfully
        echo json_encode(["status" => "success", "message" => "User deleted successfully"]);
    } else {
        // Error deleting user
        $errorMessage = "Error deleting user: " . $conn->error;
        error_log($errorMessage); // Add this line for debugging
        echo json_encode(["status" => "error", "message" => $errorMessage]);
    }
}

$conn->close();
?>
