<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Comment;
use PDO;

class CommentController extends Comment {
    use Controller;
    private $db;
    private $comment;

    public function __construct($db) {
        $this->db = $db;
        $this->comment = new Comment($db);
    }

    public function getComments($postId, $sort, $page) {
        
    }
}