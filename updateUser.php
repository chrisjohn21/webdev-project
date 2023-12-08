<?php
include_once "./connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you have a function to sanitize and validate input
    $userId = filter_input(INPUT_POST, 'userId', FILTER_VALIDATE_INT);
    $newPassword = $_POST['newPassword'];

    // Validate the user ID and new password (add more validation if needed)
    if (!$userId || $userId <= 0 || empty($newPassword)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid user ID or new password']);
        exit;
    }

    // Update the user's password in the database
    $query = "UPDATE users SET password = ? WHERE id = ?";

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $hashedPassword, $userId);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Password updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating password']);
    }

    $stmt->close();
    $conn->close();
} else {
    // Invalid request method
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
