<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;
use PDO;

class PostController extends Controller
{
    public $db;
    public $post;

    public function __construct($db)
    {
        $this->db = $db;
        $this->post = new Post($db);
    }

    public function getPosts($sort = 'newest', $time_frame = null, $page = 1)
    {
        $limit = 10;
        $this->post->page = max(1, intval($page));
        $this->post->limit = $limit + 1;
        $this->post->offset = $limit * ($this->post->page - 1);

        $stmt = null;
        $popularityMethods = [
            'week' => 'week',
            'month' => 'month',
            'year' => 'year',
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
                if (isset($popularityMethods[$time_frame])) {
                    $stmt = $this->post->{$popularityMethods[$time_frame]}();
                } else {
                    return $this->render('errors/404');
                }
                break;
            default:
                return $this->render('errors/404');
        }

        if ($stmt) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $hasNextPage = count($result) > $limit;

            if ($hasNextPage) {
                array_pop($result);
            }

            if (!empty($result)) {
                return $this->render('home/index', [
                    'posts' => $result,
                    'page' => $this->post->page,
                    'sort' => $sort,
                    'time_frame' => $time_frame,
                    'hasNextPage' => $hasNextPage
                ]);
            }
            echo "Chưa có bài viết nào!";
        } else {
            $this->render('errors/404');
        }
    }


    public function getPostById($postId)
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->post->id = $postId;
                $stmt = $this->post->getById();
                $post = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!empty($post)) {
                    $this->render('posts/detail', ['post' => $post]);
                } else {
                    $this->render('errors/404');
                }
                break;
            default:
                $this->render('errors/404');
                break;
        }
    }
}
