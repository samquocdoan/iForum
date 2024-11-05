<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;
use PDO;

class HomeController
{
    use Controller;
    private $post;

    public function __construct($db) {
        $this->post = new Post($db);
    }

    public function index() {
        $this->render('posts/tag');
    }
}
