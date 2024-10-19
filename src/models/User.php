<?php

class User
{
    private $db;
    private $tableName = 'users';

    public $uid;
    public $name;
    public $birthday;
    public $gender;
    public $address;
    public $email;
    public $password;
    public $role;
    public $status;
    public $avatarPath;
    public $coverPath;
    public $created_at;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function setUID($uid) {
        $this->uid = $uid;
    }

    public function create() {
        $query = "INSERT INTO {$this->tableName}
        (`name`, `email`, `password`)
        VALUES (:name, :email, :password)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAll()
    {
        $query = "SELECT * FROM " . $this->tableName;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
