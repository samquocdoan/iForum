<?php

require_once 'config.php';

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
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=utf8";
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

    public function query($sql, $params = [])
    {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    public function fetch($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }

    public function execute($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }
}