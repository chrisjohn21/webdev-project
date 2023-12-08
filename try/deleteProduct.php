<?php
include_once "./connection.php"; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $productId = $_POST['id'];

        // Perform the deletion in the database
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);

        $response = array('success' => false, 'message' => 'Failed to delete product.');

        if ($stmt->execute()) {
            $response = array('success' => true, 'message' => 'Product deleted successfully.');
        }

        $stmt->close();
        echo json_encode($response);
        exit;
    } else {
        $response = array('success' => false, 'message' => 'Product ID not provided.');
        echo json_encode($response);
        exit;
    }
}

$response = array('success' => false, 'message' => 'Invalid request.');
echo json_encode($response);
?>
