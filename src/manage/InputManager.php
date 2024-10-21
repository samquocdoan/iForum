<?php

namespace App\Manage;

class InputManager {
    public static function inputJson($input) {
        $jsonDecode = json_decode(file_get_contents('php://input'), true);
        return $jsonDecode[$input];
    }
}