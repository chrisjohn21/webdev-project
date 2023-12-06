<?php
include_once "./connection.php";
include_once "./Product.php";

if (isset($_GET['productId'])) {
    $productId = $_GET['productId'];
    $product = Product::getProductById($productId);

    if ($product) {
        echo $product->getQuantity();
    } else {
        echo '0'; // Return 0 if the product is not found
    }
} else {
    echo '0'; // Return 0 if productId is not set in the request
}
?>
