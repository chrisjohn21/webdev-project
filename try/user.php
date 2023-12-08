<?php
include_once "./connection.php";
// Assume you have a User class with relevant methods
class User
{
    private $id;
    private $username;
    private $password;

    public function __construct($id, $username, $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }
}
 function addUser($username, $hashedPassword)
    {
        // Assume you have a database connection in the connection.php file
        include_once "./connection.php";

        // You should add proper validation and sanitation here

        $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";

        // Execute the query
        $result = $conn->query($query);

        // Check if the query was successful
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
// Function to retrieve user data from the database
function getAllUsers()
{
    // Replace this with your database connection logic
    $conn = new mysqli("localhost", "root", "", "bakery_inventory");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $users = array();

    $query = "SELECT * FROM users"; // Replace 'users' with your actual user table name
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user = new User($row['id'], $row['username'], $row['password']);
            $users[] = $user;
        }
    }

    $conn->close();

    return $users;
}
?>
