<?php

class Post {
    private $db;
    private $tableName = 'posts';

    public $id;
    public $title;
    public $content;
    public $author;
    public $like = [];
    public $view = [];
    public $comment = [];
    public $tags = [];
    public $created_at;

    public function __construct($db) {
        $this->db = $db;
    }

    public function setPostId($postId) {
        $this->id = $postId;
    }

    public function getAll() {
        $query = "SELECT p.*, u.name,
        GROUP_CONCAT(DISTINCT tags.name) AS tags,
        COUNT(DISTINCT post_view.id) AS view_count,
        COUNT(DISTINCT post_like.id) AS like_count,
        COUNT(DISTINCT post_comments.id) AS comment_count
        FROM posts p
        JOIN users u ON p.author = u.uid
        LEFT JOIN post_tags ON p.id = post_tags.post_id
        LEFT JOIN tags ON tags.id = post_tags.tag_id
        LEFT JOIN post_view ON p.id = post_view.post_id
        LEFT JOIN post_like ON p.id = post_like.post_id
        LEFT JOIN post_comments ON p.id = post_comments.post_id
        GROUP BY p.id
        ORDER BY p.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getById() {
        $query = "SELECT p.*, u.name,
        GROUP_CONCAT(DISTINCT tags.name) AS tags,
        COUNT(post_view.id) AS view_count,
        COUNT(post_like.id) AS like_count,
        COUNT(post_comments.id) AS comment_count
        FROM posts p
        JOIN users u ON p.author = u.uid
        LEFT JOIN post_tags ON p.id = post_tags.post_id
        LEFT JOIN tags ON tags.id = post_tags.tag_id
        LEFT JOIN post_view ON p.id = post_view.id
        LEFT JOIN post_like ON p.id = post_like.id
        LEFT JOIN post_comments ON p.id = post_comments.id
        WHERE p.id=:id
        GROUP BY p.id
        ORDER BY p.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
    }
}