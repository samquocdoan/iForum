<?php

namespace App\Core;

class Controller
{
    protected function render($view, $data = [])
    {
        extract($data);
        $viewPath = explode('/', $view);
        $viewFolder = $viewPath[0];
        $viewFile = $viewPath[1];
        $fullPath = __DIR__ . "/../views/$viewFolder/$viewFile.php";

        if (file_exists($fullPath)) {
            require_once $fullPath;
        } else {
            http_response_code(404);
            require_once __DIR__ . '/../views/404.php';
        }
    }
}
