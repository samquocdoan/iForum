<?php

namespace Config;

use PDO;
use PDOException;

require_once __DIR__ . '/../config/config.php';

class Database
{
    private $host;
    private $username;
    private $password;
    private $dbname;

    public function __construct()
    {
        $this->host = DB_HOST;
        $this->username = DB_USERNAME;
        $this->password = DB_PASSWORD;
        $this->dbname = DB_NAME;
    }

    public function getConnection()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, # Thiet lap che do loi
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, # Thiet lap kieu lay du lieu
                PDO::ATTR_EMULATE_PREPARES => false, # Khong su dung prepare gia
            ];
            $conn = new PDO($dsn, $this->username, $this->password, $options);
            return $conn;
        } catch (PDOException $e) {
            die("Ket Noi That Bai: " . $e->getMessage());
        }
    }
}
