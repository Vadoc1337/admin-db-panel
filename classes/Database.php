<?php

class Database
{
    private $conn;
    private static $instance = null;

    // Database constructor.Establishes a database connection using PDO.
    private function __construct()
    {
        $config = require_once __DIR__ . '/../config/database.php';

        try {
            $this->conn = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4",
                $config['username'],
                $config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
                ]
            );
        } catch (PDOException $e) {
            die("Database connection error: " . $e->getMessage());
        }
    }

    // Get the instance of the Database class. If an instance doesn't exist, create a new one.
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Execute a SQL query with optional parameters.
     * @param string $sql The SQL query to execute
     * @param array $params An associative array of parameters for the query
     * @return PDOStatement The prepared statement after execution
     */
    public function query($sql, $params = [])
    {
        $stmt = $this->conn->prepare($sql);
        foreach ($params as $key => $value) {
            $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            if (is_string($key)) {
                $stmt->bindValue($key, $value, $type);
            } else {
                $stmt->bindValue($key + 1, $value, $type);
            }
        }
        $stmt->execute();
        return $stmt;
    }
}