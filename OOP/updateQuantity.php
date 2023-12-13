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

    // Get product information
    $getProductQuery = "SELECT name, quantity FROM products WHERE id = ?";
    $getProductStmt = $conn->prepare($getProductQuery);
    $getProductStmt->bind_param("i", $productId);
    $getProductStmt->execute();
    $getProductStmt->bind_result($productName, $currentQuantity);
    $getProductStmt->fetch();
    $getProductStmt->close();

    // Check if the requested quantity is valid
    if ($action === 'out' && $quantity > $currentQuantity) {
        header("HTTP/1.1 400 Bad Request");
        exit('Cannot decrease quantity by more than the current quantity.');
    }

    // Calculate new quantity
    $newQuantity = ($action === 'in') ? $currentQuantity + $quantity : max(0, $currentQuantity - $quantity);

    // Update product quantity
    $updateQuery = "UPDATE products SET quantity = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ii", $newQuantity, $productId);

    if ($updateStmt->execute()) {
        // Record transaction
        $insertTransactionQuery = "INSERT INTO transactions (product_id, product_name, action, quantity) VALUES (?, ?, ?, ?)";
        $insertTransactionStmt = $conn->prepare($insertTransactionQuery);
        $insertTransactionStmt->bind_param("issi", $productId, $productName, $action, $quantity);
        $insertTransactionStmt->execute();
        $insertTransactionStmt->close();

        // Check if the product is sold out
        $soldOut = ($newQuantity === 0);

        // Return the response as JSON
        echo json_encode(['status' => 'success', 'soldOut' => $soldOut]);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(['status' => 'error', 'message' => 'Error updating quantity.']);
    }

    $updateStmt->close();
    $conn->close();
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo 'Method not allowed.';
}
?>