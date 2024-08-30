<?php
namespace App\Database;

use Dotenv\Dotenv;

class DatabaseConnection
{
    public static function getConnection()
    {
        // Load environment variables from .env file
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        // Get database credentials from environment variables
        $host = $_ENV['DB_SERVERNAME'];
        $user = $_ENV['DB_USERNAME'];
        $pass = $_ENV['DB_PASSWORD'];
        $dbname = $_ENV['DB_NAME'];

        $mysqli = new \mysqli($host, $user, $pass, $dbname);

        if ($mysqli->connect_error) {
            die('Connection failed: ' . $mysqli->connect_error);
        }
        return $mysqli;
    }
}