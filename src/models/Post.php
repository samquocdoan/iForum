<?php

namespace App\Models;

use PDO;

class Post
{
    private $db;
    private $tableName = 'posts';

    public $id;
    public $title;
    public $content;
    public $author;
    public $sort_frame = 'week';
    public $page = 0;
    public $limit = 10;
    public $offset;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $query = "SELECT p.*, u.avatar, u.name,
        GROUP_CONCAT(DISTINCT tags.name) AS tags,
        COUNT(DISTINCT post_like.id) AS like_count,
        COUNT(DISTINCT post_comment.id) AS comment_count
        FROM {$this->tableName} p
        JOIN users u ON p.author = u.id
        LEFT JOIN post_tag ON p.id = post_tag.post_id
        LEFT JOIN tags ON tags.id = post_tag.tag_id
        LEFT JOIN post_like ON p.id = post_like.post_id
        LEFT JOIN post_comment ON p.id = post_comment.post_id
        GROUP BY p.id
        ORDER BY p.created DESC
        LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $this->limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $this->offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function sortNewest()
    {
        $query = "SELECT p.*, u.avatar, u.name,
        GROUP_CONCAT(DISTINCT tags.name) AS tags,
        COUNT(DISTINCT post_like.id) AS like_count,
        COUNT(DISTINCT post_comment.id) AS comment_count
        FROM {$this->tableName} p
        JOIN users u ON p.author = u.id
        LEFT JOIN post_tag ON p.id = post_tag.post_id
        LEFT JOIN tags ON tags.id = post_tag.tag_id
        LEFT JOIN post_like ON p.id = post_like.post_id
        LEFT JOIN post_comment ON p.id = post_comment.post_id
        GROUP BY p.id
        ORDER BY p.created DESC
        LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $this->limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $this->offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function sortOldest()
    {
        $query = "SELECT p.*, u.avatar, u.name,
        GROUP_CONCAT(DISTINCT tags.name) AS tags,
        COUNT(DISTINCT post_like.id) AS like_count,
        COUNT(DISTINCT post_comment.id) AS comment_count
        FROM {$this->tableName} p
        JOIN users u ON p.author = u.id
        LEFT JOIN post_tag ON p.id = post_tag.post_id
        LEFT JOIN tags ON tags.id = post_tag.tag_id
        LEFT JOIN post_like ON p.id = post_like.post_id
        LEFT JOIN post_comment ON p.id = post_comment.post_id
        GROUP BY p.id
        ORDER BY p.created ASC
        LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $this->limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $this->offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function sortPopularity()
    {
        $query = "SELECT p.*, u.avatar, u.name,
        GROUP_CONCAT(DISTINCT tags.name) AS tags,
        COUNT(DISTINCT post_like.id) AS like_count,
        COUNT(DISTINCT post_comment.id) AS comment_count,
        (COUNT(DISTINCT post_like.id) + COUNT(DISTINCT post_comment.id)) AS popularity
        FROM posts p
        JOIN users u ON p.author = u.id
        LEFT JOIN post_tag ON p.id = post_tag.post_id
        LEFT JOIN tags ON tags.id = post_tag.tag_id
        LEFT JOIN post_like ON p.id = post_like.post_id
        LEFT JOIN post_comment ON p.id = post_comment.post_id
        GROUP BY p.id
        ORDER BY popularity DESC
        LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $this->limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $this->offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function getById()
    {
        $query = "SELECT p.*, u.avatar, u.name,
        GROUP_CONCAT(DISTINCT tags.name) AS tags,
        COUNT(DISTINCT post_like.id) AS like_count,
        COUNT(DISTINCT post_comment.id) AS comment_count
        FROM posts p
        JOIN users u ON p.author = u.id
        LEFT JOIN post_tag ON p.id = post_tag.post_id
        LEFT JOIN tags ON tags.id = post_tag.tag_id
        LEFT JOIN post_like ON p.id = post_like.post_id
        LEFT JOIN post_comment ON p.id = post_comment.post_id
        WHERE p.id=:id
        GROUP BY p.id
        ORDER BY p.created DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function week()
    {
        $query = "SELECT p.*, u.avatar, u.name,
        GROUP_CONCAT(DISTINCT tags.name) AS tags,
        COUNT(DISTINCT post_like.id) AS like_count,
        COUNT(DISTINCT post_comment.id) AS comment_count,
        (COUNT(DISTINCT post_like.id) + COUNT(DISTINCT post_comment.id)) AS popularity
        FROM {$this->tableName} p
        JOIN users u ON p.author = u.id
        LEFT JOIN post_tag ON p.id = post_tag.post_id
        LEFT JOIN tags ON tags.id = post_tag.tag_id
        LEFT JOIN post_like ON p.id = post_like.post_id
        LEFT JOIN post_comment ON p.id = post_comment.post_id
        WHERE p.created >= DATE_SUB(NOW(), INTERVAL 1 WEEK)
        GROUP BY p.id
        ORDER BY popularity DESC
        LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $this->limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $this->offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function month()
    {
        $query = "SELECT p.*, u.avatar, u.name,
        GROUP_CONCAT(DISTINCT tags.name) AS tags,
        COUNT(DISTINCT post_like.id) AS like_count,
        COUNT(DISTINCT post_comment.id) AS comment_count,
        (COUNT(DISTINCT post_like.id) + COUNT(DISTINCT post_comment.id)) AS popularity
        FROM {$this->tableName} p
        JOIN users u ON p.author = u.id
        LEFT JOIN post_tag ON p.id = post_tag.post_id
        LEFT JOIN tags ON tags.id = post_tag.tag_id
        LEFT JOIN post_like ON p.id = post_like.post_id
        LEFT JOIN post_comment ON p.id = post_comment.post_id
        WHERE p.created >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
        GROUP BY p.id
        ORDER BY popularity DESC
        LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $this->limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $this->offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function year()
    {
        $query = "SELECT p.*, u.avatar, u.name,
        GROUP_CONCAT(DISTINCT tags.name) AS tags,
        COUNT(DISTINCT post_like.id) AS like_count,
        COUNT(DISTINCT post_comment.id) AS comment_count,
        (COUNT(DISTINCT post_like.id) + COUNT(DISTINCT post_comment.id)) AS popularity
        FROM {$this->tableName} p
        JOIN users u ON p.author = u.id
        LEFT JOIN post_tag ON p.id = post_tag.post_id
        LEFT JOIN tags ON tags.id = post_tag.tag_id
        LEFT JOIN post_like ON p.id = post_like.post_id
        LEFT JOIN post_comment ON p.id = post_comment.post_id
        WHERE p.created >= DATE_SUB(NOW(), INTERVAL 1 YEAR)
        GROUP BY p.id
        ORDER BY popularity DESC
        LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $this->limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $this->offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
}
