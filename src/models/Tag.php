<?php

namespace App\Models;

use App\Models\Post;

use PDO;

class Tag extends Post
{
    public $tagName;

    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function getTagPopularity()
    {
        $query = "SELECT * FROM tags";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getTagByPostId()
    {
        $query = "SELECT tags.* FROM post_tag JOIN tags ON tags.id = post_tag.tag_id WHERE post_tag.post_id = :postId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':postId', $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function getTagInfoByTagName()
    {
        $query = "SELECT tags.*, COUNT(DISTINCT posts.id) AS post_count
        FROM tags
        LEFT JOIN post_tag ON tags.id = post_tag.tag_id
        LEFT JOIN posts ON post_tag.post_id = posts.id
        WHERE tags.name = :tagName
        GROUP BY tags.id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':tagName', $this->tagName);
        $stmt->execute();
        return $stmt;
    }

    public function tagBaseQuery($orderBy, $interval = null)
    {
        $dateCodition = $interval ? " AND p.created >= DATE_SUB(NOW(), INTERVAL $interval)" : "";

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
        WHERE 1=1 $dateCodition
        GROUP BY p.id
        HAVING FIND_IN_SET(:tagName, tags) > 0
        ORDER BY $orderBy
        LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':tagName', $this->tagName, PDO::PARAM_STR);
        $stmt->bindParam(':limit', $this->limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $this->offset, PDO::PARAM_INT);
        return $stmt;
    }

    public function sortNewest()
    {
        $stmt = $this->tagBaseQuery("p.created DESC");
        $stmt->execute();
        return $stmt;
    }

    public function sortOldest()
    {
        $stmt = $this->tagBaseQuery("p.created ASC");
        $stmt->execute();
        return $stmt;
    }

    public function sortPopularity()
    {
        $stmt = $this->tagBaseQuery("popularity DESC");
        $stmt->execute();
        return $stmt;
    }

    public function sortWeek()
    {
        $stmt = $this->tagBaseQuery("popularity DESC", "1 WEEK");
        $stmt->execute();
        return $stmt;
    }

    public function sortMonth()
    {
        $stmt = $this->tagBaseQuery("popularity DESC", "1 MONTH");
        $stmt->execute();
        return $stmt;
    }

    public function sortYear()
    {
        $stmt = $this->tagBaseQuery("popularity DESC", "1 YEAR");
        $stmt->execute();
        return $stmt;
    }
}
