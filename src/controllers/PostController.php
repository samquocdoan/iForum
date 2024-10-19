<?php

require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../core/Controller.php';

class PostController extends Controller {
    public $db;
    public $post;

    public function __construct($db) {
        $this->db = $db;
        $this->post = new Post($db);
    }

    public function getAll() {
        $stmt = $this->post->getAll();
        $postDatas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($postDatas) {
            Response::json($postDatas, 200);
        } else {
            Response::json(["message" => "Khong Co Bai Viet Nao"], 404);
        }
        exit();
    }

    public function getPostById($postId) {
        $this->post->setPostId($postId);
        $stmt= $this->post->getById();
        $postData = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->render('post/post_detail', ['post' => $postData]);
        exit();
    }
}