<?php
include_once "./connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you have a function to sanitize and validate input
    $userId = filter_input(INPUT_POST, 'userId', FILTER_VALIDATE_INT);

    // Validate the user ID
    if (!$userId || $userId <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid user ID']);
        exit;
    }

    // Delete the user from the database
    $query = "DELETE FROM users WHERE id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $userId);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'User deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting user']);
    }

    $stmt->close();
    $conn->close();
} else {
    // Invalid request method
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
