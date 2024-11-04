<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;
use App\Models\Comment;

use PDO;

class PostController
{
    use Controller;
    private $db;
    private $post;
    private $comment;

    public function __construct($db)
    {
        $this->db = $db;
        $this->post = new Post($db);
        $this->comment = new Comment($db);
    }

    public function getPosts($sort = 'newest', $timeFrame = null, $page = 1)
    {
        $limit = 12;
        $this->post->setPagination(page: $page, limit: $limit);

        $stmt = null;
        $popularityMethods = [
            'week' => 'sortWeek',
            'month' => 'sortMonth',
            'year' => 'sortYear',
            'infinite' => 'sortPopularity'
        ];

        switch ($sort) {
            case "newest":
                $stmt = $this->post->sortNewest();
                break;
            case "oldest":
                $stmt = $this->post->sortOldest();
                break;
            case "popularity":
                if (isset($popularityMethods[$timeFrame])) {
                    $stmt = $this->post->{$popularityMethods[$timeFrame]}();
                } else {
                    return $this->render('errors/404');
                }
                break;
            default:
                return $this->render('errors/404');
        }

        if (!$stmt) {
            return ['message' => 'Không có dữ liệu bài viết.'];
        }

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $hasPost = count($result);
        $hasNextPage = $hasPost > $limit;

        if ($hasNextPage) {
            array_pop($result);
        }

        $params = [
            'page' => $this->post->page,
            'sort' => $sort,
            'timeFrame' => $timeFrame,
            'hasNextPage' => $hasNextPage,
        ];

        if ($hasPost) {
            $params['posts'] = $result;

            foreach ($params['posts'] as &$post) {
                if (isset($post['tags'])) {
                    $post['tags'] = explode(',', $post['tags']);
                }
                if (isset($post['created'])) {
                    $post['created'] = $this->timeAgo($post['created']);
                }
            }

            $params['postCount'] = $hasPost;
            $params['isShowPagination'] = true;
        } else {
            $params['isShowPagination'] = false;
            $params['message'] = 'Chưa có bài viết nào.';
        }

        return $this->render('home/index', $params);
    }

    public function postDetail($postId)
    {
        $this->post->id = $postId;
        $this->comment->id = $postId;

        $postDetail = $this->getPostById();
        $comments = $this->getCommentByPostId();

        $data = [
            'postData' => $postDetail,
            'comments' => $comments,
        ];
        $this->render('posts/detail', $data);
    }

    public function getPostById()
    {
        $stmt = $this->post->getById();
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($post) {
            $post['tags'] = explode(',', $post['tags']);
            $post['created'] = $this->timeAgo($post['created']);
            return $post;
        }
        return [];
    }

    public function getCommentByPostId()
    {
        $stmt = $this->comment->sortNewest();
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($comments) {
            foreach ($comments as &$comment) {
                $comment['commented'] = $this->timeAgo($comment['commented']);
            }
            return $comments;
        }
        return [];
    }
}
