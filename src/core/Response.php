<?php

namespace App\Core;

class Response
{
    private function __construct()
    {
        header('Contetnt-type: application/json');
    }

    public static function json($data, $code)
    {
        echo json_encode($data);
        http_response_code($code);
        exit();
    }

    public static function success($message = 'Success', $code = 200, $data = []) {
        http_response_code($code);
        echo json_encode([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ]);
        exit();
    }

    public static function error($message = 'Error', $code = 400, $errors = []) {
        http_response_code($code);
        echo json_encode([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ]);
        exit();
    }
}
