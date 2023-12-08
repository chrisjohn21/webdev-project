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
    public function delete()
    {
        $database = new Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $conn = $database->getConnection();

        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $this->id);

        if ($stmt->execute()) {
            // Deletion successful
            return true;
        } else {
            // Deletion failed
            return false;
        }
    }

}
?>
