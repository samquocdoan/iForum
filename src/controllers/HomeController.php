<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Post.php';
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
