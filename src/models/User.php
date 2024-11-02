<?php

namespace App\Models;

use PDO;
use PDOException;

class User
{
    private $db;
    private $tableName = 'users';

    public $id;
    public $name;
    public $birthday;
    public $gender;
    public $address;
    public $email;
    public $password;
    public $role;
    public $avatar;
    public $created;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getById()
    {
        $query = "SELECT * FROM {$this->tableName} WHERE id=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function login()
    {
        $query = "SELECT id, name, email, password, role
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

    public function delete()
    {
        $query = "SELECT password FROM {$this->tableName} WHERE id=:id AND email =:email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        return $stmt;
    }

    public function update()
    {
        $query = "UPDATE users SET";
        $setClauses = [];
        $params = [];

        if ($this->name !== null) {
            $setClauses[] = "name=:name";
            $params[':name'] = $this->name;
        }

        if ($this->birthday !== null) {
            $setClauses[] = 'birthday=:birthday';
            $params[':birthday'] = $this->birthday;
        }

        if ($this->gender !== null) {
            $setClauses[] = 'gender=:gender';
            $params[':gender'] = $this->gender;
        }

        if ($this->address !== null) {
            $setClauses[] = 'address=:address';
            $params[':address'] = $this->address;
        }

        if ($this->email !== null) {
            $setClauses[] = 'email=:email';
            $params[':email'] = $this->email;
        }

        if ($this->role !== null) {
            $setClauses[] = 'role=:role';
            $params[':role'] = $this->role;
        }

        if ($this->avatar !== null) {
            $setClauses[] = 'avatar=:avatar';
            $params[':avatar'] = $this->avatar;
        }

        $query .= ' ' . implode(',', $setClauses);
        $query .= ' WHERE id = :id';
        $params[':id'] = $this->id;

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    public function getAll()
    {
        $query = "SELECT * FROM {$this->tableName}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function updatePassword()
    {
        $query = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}
