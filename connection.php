<?php
class Database {
    public static $connection;

    // Set up the database connection
    public static function SetupConnection() {
        if (!isset(Database::$connection)) {
            Database::$connection = new mysqli("localhost", "root","Sahan2005@mysql", "victore", 3306);

            // Check connection and throw an error if it fails
            if (Database::$connection->connect_error) {
                die("Database connection failed: " . Database::$connection->connect_error);
            }
        }
    }

    // Search function for SELECT queries
    public static function Search($q) {
        Database::SetupConnection();
        $resultset = Database::$connection->query($q);

        if ($resultset === false) {
            die("Error executing query: " . Database::$connection->error);
        }

        return $resultset;
    }

    // Improved IUD method for INSERT, UPDATE, DELETE queries using prepared statements
    public static function IUD($query, $params = [], $types = "") {
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

    public static function InsertID() {
        return self::$connection->insert_id;
    }

    // Close the database connection
    public static function CloseConnection() {
        if (isset(Database::$connection)) {
            Database::$connection->close();
            Database::$connection = null;
        }
    }
}
?>
