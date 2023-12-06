<?php
include_once "./connection.php";

// Fetch product IDs from the database
$database = new Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$conn = $database->getConnection();

$query = "SELECT id FROM products";
$result = $conn->query($query);

$productIds = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productIds[] = $row['id'];
    }
}

echo json_encode($productIds);
?>
