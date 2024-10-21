<?php

namespace App\Services;

use PDO;

class UserService {
    private $db;
    private $user;

    public function __construct($db, $user) {
        $this->db = $db;
        $this->user = $user;
    }

    public function emailExists() {
        $query = "SELECT COUNT(*) as count FROM users WHERE email=:email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $this->user->email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
}