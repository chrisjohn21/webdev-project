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
        private $host;
        private $user;
        private $password;
        private $database;
        private $conn;

        public function __construct($host, $user, $password, $database)
        {
            $this->host = $host;
            $this->user = $user;
            $this->password = $password;
            $this->database = $database;
            $this->connect();
        }

        private function connect()
        {
            $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);

            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }

        public function getConnection()
        {
            return $this->conn;
        }
    }
}

?>
