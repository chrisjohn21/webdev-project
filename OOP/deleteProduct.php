<?php

// Include the necessary files
include_once "./connection.php";
include_once "./Product.php";

// Class to handle product deletion
class ProductDeleter
{
    private $connection;

    // Constructor to initialize the database connection
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    // Method to delete a product
    public function deleteProduct($productId)
    {
        try {
            // Perform additional validation as needed

            $deleteSql = "DELETE FROM products WHERE id = $productId";

            if ($this->connection->query($deleteSql) === true) {
                // Product deleted successfully
                return ["status" => "success", "message" => "Product deleted successfully"];
            } else {
                // Error deleting product
                $errorMessage = "Error deleting product: " . $this->connection->error;
                error_log($errorMessage); // Add this line for debugging
                return ["status" => "error", "message" => $errorMessage];
            }
        } catch (Exception $e) {
            // Handle exceptions if needed
            return ["status" => "error", "message" => "An error occurred: " . $e->getMessage()];
        }
    }
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the product ID from the POST data
    $productId = $_POST['product_id'];

    // Create an instance of ProductDeleter
    $productDeleter = new ProductDeleter($conn);

    // Call the deleteProduct method and echo the JSON response
    echo json_encode($productDeleter->deleteProduct($productId));
}

// Close the database connection
$conn->close();

?>
