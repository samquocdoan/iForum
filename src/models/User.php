<?php

namespace App\Models;

use PDO;

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
    public $createdAt;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getById() {
        $query = "SELECT name, birthday, gender, address, email, status, role, avatar_path, cover_path, created_at WHERE uid=:uid";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':uid', $this->uid);
        $stmt->execute();
        return $stmt;
    }

    public function login()
    {
        $query = "SELECT uid, name, email, password, role, status
        FROM {$this->tableName} WHERE email=:email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        return $stmt;
    }

    public function create()
    {
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

    public function delete() {
        $query = "SELECT password FROM {$this->tableName} WHERE id=:id AND email =:email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->uid);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        return $stmt;
    }

    public function getAll()
    {
        $query = "SELECT * FROM {$this->tableName}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
