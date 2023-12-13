<?php

// Check if the class exists before defining it
if (!class_exists('Database')) {

    // Database configuration
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'bakery_inventory');

    // Database class
    class Database
    {
        // Properties encapsulate the data
        private $host;
        private $user;
        private $password;
        private $database;
        private $conn; // Connection object

        // Constructor for initializing object properties
        public function __construct($host, $user, $password, $database)
        {
            $this->host = $host;
            $this->user = $user;
            $this->password = $password;
            $this->database = $database;
            $this->connect(); // Encapsulation: calling a private method to encapsulate the connection logic
        }

        // Private method for connecting to the database
        private function connect()
        {
            // Polymorphism: using a different method for connecting to the database
            $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);

            // Encapsulation: handling connection errors without exposing details
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }

        // Public method for retrieving the database connection
        public function getConnection()
        {
            return $this->conn; // Abstraction: exposing only the necessary functionality
        }
    }

    // Encapsulation: wrapping configuration details and database instantiation within the class

    // Create an instance of the Database class
    $database = new Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $conn = $database->getConnection();
}

?>
