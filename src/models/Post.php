<?php

namespace App\Models;

use PDO;

class Post
{
    protected $db;
    protected $tableName = 'posts';

    public $id;
    public $title;
    public $content;
    public $author;
    public $tag;

    public $page = 0;
    public $limit = POST_LIMIT;
    public $offset;

    public $sort = 'newest';
    public $timeFrame = 'week';

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function setPagination($page, $limit)
    {
        $this->page = max(1, (int)$page);
        $this->limit = (int)$limit + 1;
        $this->offset = $limit * ($this->page - 1);
    }

    protected function baseQuery($orderBy, $interval = null)
    {
        $dateCondition = $interval ? " AND p.created >= DATE_SUB(NOW(), INTERVAL $interval)" : "";

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
        WHERE 1=1 $dateCondition
        GROUP BY p.id
        ORDER BY $orderBy
        LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $this->limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $this->offset, PDO::PARAM_INT);
        return $stmt;
    }

    public function sortNewest()
    {
        $stmt = $this->baseQuery("p.created DESC");
        $stmt->execute();
        return $stmt;
    }

    public function sortOldest()
    {
        $stmt = $this->baseQuery("p.created ASC");
        $stmt->execute();
        return $stmt;
    }

    public function sortPopularity()
    {
        $stmt = $this->baseQuery("popularity DESC");
        $stmt->execute();
        return $stmt;
    }

    public function sortWeek()
    {
        $stmt = $this->baseQuery("popularity DESC", "1 WEEK");
        $stmt->execute();
        return $stmt;
    }

    public function sortMonth()
    {
        $stmt = $this->baseQuery("popularity DESC", "1 MONTH");
        $stmt->execute();
        return $stmt;
    }

    public function sortYear()
    {
        $stmt = $this->baseQuery("popularity DESC", "1 YEAR");
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
}
