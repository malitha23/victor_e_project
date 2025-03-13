<?php
class Databases {
    public static $connection;

    // Set up the database connection
    public static function SetupConnection() {
        if (!isset(Databases::$connection)) {

            Databases::$connection = new mysqli("localhost", "root", "Sahan2005@mysql", "victore", 3306);
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
