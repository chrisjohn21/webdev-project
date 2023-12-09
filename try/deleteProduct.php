<?php
include_once "./connection.php";
include_once "./Product.php";

// Check if the product ID is provided
if (isset($_POST['productId'])) {
    $productId = $_POST['productId'];

    // Instantiate a Product object and set its ID
    $product = new Product("", 0, "", 0);
    $product->setId($productId);

    // Perform the delete operation
    $result = $product->deleteProduct();

    // Check if the delete operation was successful
    if ($result) {
        // Provide a success message (you can customize this)
        echo json_encode(['status' => 'success', 'message' => 'Product deleted successfully']);
    } else {
        // Provide an error message (you can customize this)
        echo json_encode(['status' => 'error', 'message' => 'Error deleting product']);
    }
} else {
    // Handle the case when product ID is not provided
    echo json_encode(['status' => 'error', 'message' => 'Product ID not provided']);
}
?>
