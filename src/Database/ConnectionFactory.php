<?php
namespace App\Database;

use PDO;
use PDOException;

class ConnectionFactory {
    private static ?PDO $connection = null;

    public static function getConnection(): PDO {
        // Check if the connection has already been established
        if (self::$connection === null) {
            try {
                // Database configuration
                $host = 'localhost';  // Database host
                $db = 'avneetdb1';    // Database name
                $user = 'root';       // Database username
                $pass = 'pass123';    // Database password

                // Data Source Name (DSN) for the MySQL connection
                $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

                // PDO options for error handling, fetch mode, and prepared statement emulation
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Throw exceptions on errors
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Fetch results as associative arrays
                    PDO::ATTR_EMULATE_PREPARES   => false,                   // Use native prepared statements                
                ];

                // Create a new PDO connection using the DSN and options
                self::$connection = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                // If the connection fails, throw a PDOException with the error message and code
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
        // Return the established connection
        return self::$connection;
    }
}
?>
