<?php
class Databases {
    public static $connection;

    // Set up the database connection
    public static function SetupConnection() {
        if (!isset(Databases::$connection)) {

            if (file_exists(__DIR__ . '/.env')) {
                $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach ($lines as $line) {
                    // Skip comments and empty lines
                    $line = trim($line);
                    if (empty($line) || strpos($line, '#') === 0) {
                        continue;
                    }

                    // Split line into key and value
                    $parts = explode('=', $line, 2);

                    // Ensure we have both key and value parts
                    if (count($parts) === 2) {
                        list($key, $value) = $parts;
                        $_ENV[$key] = trim($value);
                    } else {
                   
                    }
                }
            }

            $host = isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : 'localhost';
            $port = isset($_ENV['DB_PORT']) ? $_ENV['DB_PORT'] : 3306;
            $username = isset($_ENV['DB_USERNAME']) ? $_ENV['DB_USERNAME'] : 'root';
            $password = isset($_ENV['DB_PASSWORD']) ? $_ENV['DB_PASSWORD'] : '';
            $database = isset($_ENV['DB_DATABASE']) ? $_ENV['DB_DATABASE'] : 'victore';

            Databases::$connection = new mysqli($host, $username, $password, $database, $port);
            
            // Databases::$connection = new mysqli("localhost", "root", "", "victore", 3306);


            // Check connection and throw an error if it fails
            if (Databases::$connection->connect_error) {
                die("Database connection failed: " . Databases::$connection->connect_error);
            }
        }
    }

    // Search function for SELECT queries with prepared statements
    public static function Search($query, $params = [], $types = "") {
        Databases::SetupConnection();
        
        // Prepare the statement
        if ($stmt = Databases::$connection->prepare($query)) {
            // Bind parameters if they exist
            if (!empty($params) && !empty($types)) {
                $stmt->bind_param($types, ...$params);
            }

            // Execute the query
            $stmt->execute();
            // Get result set
            $resultset = $stmt->get_result();

            $stmt->close();
            return $resultset;
        } else {
            die("Error preparing statement: " . Databases::$connection->error);
        }
    }

    // Improved IUD method for INSERT, UPDATE, DELETE queries using prepared statements
    public static function IUD($query, $params = [], $types = "") {
        Databases::SetupConnection();

        // Prepare the statement
        if ($stmt = Databases::$connection->prepare($query)) {
            // Bind parameters if they exist
            if (!empty($params) && !empty($types)) {
                $stmt->bind_param($types, ...$params);
            }

            // Execute the query
            if ($stmt->execute()) {
                $inserted_id = Databases::$connection->insert_id; // Get last inserted ID
                $stmt->close();
                return $inserted_id; // Return the ID instead of true
            } else {
                die("Error executing statement: " . $stmt->error);
            }
        } else {
            die("Error preparing statement: " . Databases::$connection->error);
        }
    }

    // Close the database connection
    public static function CloseConnection() {
        if (isset(Databases::$connection)) {
            Databases::$connection->close();
            Databases::$connection = null;
        }
    }
}
?>
