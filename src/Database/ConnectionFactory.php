<?php
namespace App\Database;

use PDO;
use PDOException;

class ConnectionFactory {
    private static ?PDO $connection = null;

    public static function getConnection(): PDO {
        if (self::$connection === null) {
            try {
                $host = 'localhost';
                $db = 'avneetdb1';
                $user = 'root';
                $pass = 'pass123';

                $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        
                    PDO::ATTR_EMULATE_PREPARES   => false,                   
                ];

                self::$connection = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
        return self::$connection;
    }
}
?>
