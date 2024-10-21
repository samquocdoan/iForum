<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;
use PDO;

class HomeController extends Controller
{
    private $post;

    public function __construct($db) {
        $this->post = new Post($db);
    }

    public function index() {
        $stmt = $this->post->getAll();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->render('home/index', ['posts' => $posts]);
    }
}
