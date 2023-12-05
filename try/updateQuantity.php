<?php
include "./connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the request
    $productId = $_POST['productId'];
    $action = $_POST['action'];
    $quantity = $_POST['quantity'];

    // Validate the data (you may add more validation as needed)
    if (!is_numeric($productId) || !is_numeric($quantity) || !in_array($action, ['in', 'out'])) {
        header("HTTP/1.1 400 Bad Request");
        exit('Invalid data received.');
    }

    // Perform the quantity update
    $database = new Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $conn = $database->getConnection();

    $query = "SELECT quantity FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $stmt->bind_result($currentQuantity);
    $stmt->fetch();
    $stmt->close();

    if ($action === 'in') {
        $newQuantity = $currentQuantity + $quantity;
    } else {
        // Ensure the quantity does not go below zero
        $newQuantity = max(0, $currentQuantity - $quantity);
    }

    $updateQuery = "UPDATE products SET quantity = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ii", $newQuantity, $productId);

    if ($updateStmt->execute()) {
        echo 'success';
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo 'Error updating quantity.';
    }

    $updateStmt->close();
    $conn->close();
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo 'Method not allowed.';
}
?>
