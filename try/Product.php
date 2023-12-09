<?php
include_once "./connection.php";

class Product
{
    private $id;
    private $name;
    private $price;
    private $description;
    private $quantity;

    public function __construct($name, $price, $description, $quantity = 0)
    {
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public static function getAllProducts()
    {
        $database = new Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $conn = $database->getConnection();

        $query = "SELECT * FROM products";
        $result = $conn->query($query);

        $productList = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $product = new Product($row['name'], $row['price'], $row['description'], $row['quantity']);
                $product->id = $row['id'];
                $productList[] = $product;
            }
        }

        return $productList;
    }
    public static function getProductById($productId)
    {
        $database = new Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $conn = $database->getConnection();

        $query = "SELECT * FROM products WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $product = new Product($row['name'], $row['price'], $row['description'], $row['quantity']);
            $product->id = $row['id'];
            return $product;
        }

        return null; // Return null if the product is not found
    }
    public function deleteProduct()
{
    $database = new Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $conn = $database->getConnection();

    try {
        // Check if the product has a valid ID
        if (!$this->id) {
            throw new Exception("Invalid product ID");
        }

        // Prepare the delete query
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param("i", $this->id);

        // Execute the statement
        if (!$stmt->execute()) {
            throw new Exception("Execute statement failed: " . $stmt->error);
        }

        // Deletion successful
        return true;
    } catch (Exception $e) {
        // Log the error (you can customize this based on your logging system)
        error_log("Error deleting product: " . $e->getMessage());

        // Deletion failed
        return false;
    } finally {
        // Close the statement and connection
        if (isset($stmt)) {
            $stmt->close();
        }
        $conn->close();
    }
}

}
?>
