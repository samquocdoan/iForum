<?php

namespace App\Core;

class Response
{
    public static function json($data, $code)
    {
        header('Contetnt-type: application/json');

        echo json_encode($data);
        http_response_code($code);
        exit();
    }

    public static function success($message = 'Success', $code = 200, $data = [])
    {
        header('Contetnt-type: application/json');

        http_response_code($code);
        echo json_encode([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ]);
        exit();
    }

    public static function error($message = 'Error', $code = 400, $errors = [])
    {
        header('Contetnt-type: application/json');

        http_response_code($code);
        echo json_encode([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ]);
        exit();
    }
}
