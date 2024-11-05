<?php

namespace App\Models;

use App\Core\Controller;
use PDO;

class Comment extends Post
{
    use Controller;

    private $table = 'post_comment';

    public $page;
    public $limit = COMMENT_LIMIT;
    public $orderBy = 'cmt.commented DESC';
    public $interval = null;
    public $offset = 0;

    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function pagination()
    {
        $this->offset = $this->limit * ($this->page - 1);
        $this->limit += 1; // This line is required below offset.
    }

    public function baseCommentQuery()
    {
        $dateCodition = $this->interval ? " AND cmt.commented >= DATE_SUB(NOW(), INTERVAL {$this->orderBy})" : "";
        $query = "SELECT cmt.*, u.name, u.avatar
        FROM {$this->table} cmt
        JOIN users u ON cmt.user_id = u.id
        JOIN posts p ON cmt.post_id = :postId
        WHERE 1=1 $dateCodition
        GROUP BY cmt.id
        ORDER BY {$this->orderBy}
        LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':postId', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $this->limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $this->offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function sortNewest()
    {
        $this->orderBy = "cmt.commented DESC";
        return $this->baseCommentQuery();
    }

    public function sortOldest()
    {
        $this->orderBy = "cmt.commented ASC";
        return $this->baseCommentQuery();
    }

    public function countComments()
    {
        $query = "SELECT COUNT(*) as total FROM {$this->table} WHERE post_id = :postId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':postId', $this->id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}
