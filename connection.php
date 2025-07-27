<?php
class Database
{
    public static $connection;

    // Set up the database connection
    public static function SetupConnection()
    {
        if (!isset(Database::$connection)) {

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
            $username = isset($_ENV['DB_USERNAME']) ? $_ENV['DB_USERNAME'] : 'u247981053_ampy';
            $password = isset($_ENV['DB_PASSWORD']) ? $_ENV['DB_PASSWORD'] : 'vics2025IIdb@#';
            $database = isset($_ENV['DB_DATABASE']) ? $_ENV['DB_DATABASE'] : 'u247981053_shelf';

            // Establish the database connection
            Database::$connection = new mysqli($host, $username, $password, $database, $port);

            // Database::$connection = new mysqli("localhost", "root", "", "victore", 3306);

            // Check connection and throw an error if it fails
            if (Database::$connection->connect_error) {
                die("Database connection failed: " . Database::$connection->connect_error);
            }
        }
    }

    // Search function for SELECT queries
    public static function Search($q)
    {
        Database::SetupConnection();
        $resultset = Database::$connection->query($q);

        if ($resultset === false) {
            die("Error executing query: " . Database::$connection->error);
        }

        return $resultset;
    }

    // Improved IUD method for INSERT, UPDATE, DELETE queries using prepared statements
    public static function IUD($query, $params = [], $types = "")
    {
        Database::SetupConnection();

        // Prepare the statement
        if ($stmt = Database::$connection->prepare($query)) {
            // Bind parameters if they exist
            if (!empty($params) && !empty($types)) {
                $stmt->bind_param($types, ...$params);
            }

            // Execute the query
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            } else {
                die("Error executing statement: " . $stmt->error);
            }
        } else {
            die("Error preparing statement: " . Database::$connection->error);
        }
    }

    public static function InsertID()
    {
        return self::$connection->insert_id;
    }

    // Close the database connection
    public static function CloseConnection()
    {
        if (isset(Database::$connection)) {
            Database::$connection->close();
            Database::$connection = null;
        }
    }
}
?>