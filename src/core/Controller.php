<?php

namespace App\Core;

trait Controller
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
            require_once __DIR__ . '/../views/errors/404.php';
        }
    }

    public function timeAgo($datetime)
    {
        $time = strtotime($datetime);
        $diff = time() - $time;

        $units = [
            31536000 => 'năm',
            2592000 => 'tháng',
            604800 => 'tuần',
            86400 => 'ngày',
            3600 => 'giờ',
            60 => 'phút',
            1 => 'giây'
        ];

        foreach ($units as $unit => $text) {
            if ($diff < $unit) continue;
            $numberOfUnits = floor($diff / $unit);
            return "$numberOfUnits $text trước";
        }

        return "vừa xong";
    }

    public function setPagination($page, $limit)
    {
        $page = max(1, (int)$page);
        $limit = (int)$limit + 1;
        $offset = $limit * ($page - 1);
        return ['page' => $page, 'limit' => $limit, 'offset' => $offset];
    }
}
