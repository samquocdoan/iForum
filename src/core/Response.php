<?php

class Response {
    public static function json($data, $code) {
        header('Contetnt-type: application/json');
        echo json_encode($data);
        http_response_code($code);
        exit();
    }
}