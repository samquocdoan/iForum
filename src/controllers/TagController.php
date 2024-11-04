<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Tag;
use App\Models\Post;
use PDO;

class TagController
{
    use Controller;

    private $db;
    private $tag;
    private $post;

    public function __construct($db)
    {
        $this->db = $db;
        $this->tag = new Tag($db);
        $this->post = new Post($db);
    }

    public function index($tagName = null, $sort = 'newest', $timeFrame = null, $page = 1)
    {
        $this->tag->setPagination(page: $page, limit: POST_LIMIT);
        $this->tag->sort = $sort;
        $this->tag->timeFrame = $timeFrame;

        $popularityTag = $this->getPopularityTag();
        $data = [
            'popularityTag' => $popularityTag,
            'isShowPagination' => false,
        ];

        if ($tagName) {
            $currentTagData = $this->getTagInfo($tagName);
            $postData = $this->getPostByTagName($sort, $timeFrame);

            $data['currentTagData'] = $currentTagData ?? [];
            $data['posts'] = $postData['posts'] ?? [];
            $data['sort'] = $postData['sort'] ?? $sort;
            $data['timeFrame'] = $postData['timeFrame'] ?? $timeFrame;
            $data['page'] = $postData['page'] ?? 1;
            $data['hasNextPage'] = $postData['hasNextPage'] ?? false;
            $data['isShowPagination'] = $postData['isShowPagination'] ?? false;
        } else {
            $postWithTag = $this->getPostWithTag();
            $data['posts'] = $postWithTag;
        }

        $this->render(view: 'posts/tag', data: $data);
    }


    private function getPopularityTag()
    {
        $stmt = $this->tag->getTagPopularity();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result) return $result;
    }

    private function getTagInfo($tagName = null)
    {
        $this->tag->tagName = $tagName;
        $stmt = $this->tag->getTagInfoByTagName();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $result['created'] = $this->timeAgo($result['created']);
            return $result;
        }
    }

    private function getPostByTagName($sort, $timeFrame)
    {
        $stmt = $this->sortPost($sort, $timeFrame);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $params = $this->prepareData($result);

        return $params;
    }

    private function getPostWithTag()
    {
        $stmt = $this->tag->postWithTag();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $posts = $this->preparePost($result);
        return $posts;
    }

    public function getAllPost()
    {
        $stmt = $this->post->sortNewest();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result) return $result;
        return null;
    }

    private function preparePost($posts)
    {
        foreach ($posts as &$post) {
            if (isset($post['tags'])) $post['tags'] = explode(',', $post['tags']);
            if (isset($post['created'])) $post['created'] = $this->timeAgo($post['created']);
        }
        return $posts;
    }

    private function convertMethod()
    {
        $popularityMethods = [
            'week' => 'sortWeek',
            'month' => 'sortMonth',
            'year' => 'sortYear',
            'infinite' => 'sortPopularity'
        ];
        return $popularityMethods;
    }

    private function sortPost($sort, $timeFrame)
    {
        switch ($sort) {
            case "newest":
                $stmt = $this->tag->sortNewest();
                break;
            case "oldest":
                $stmt = $this->tag->sortOldest();
                break;
            case "popularity":
                if (isset($this->convertMethod()[$timeFrame])) {
                    $stmt = $this->tag->{$this->convertMethod()[$timeFrame]}();
                } else {
                    return $this->render('errors/404');
                }
                break;
            default:
                return $this->render('errors/404');
        }
        return $stmt;
    }

    private function prepareData($result)
    {
        $hasPost = count($result);
        $hasNextPage = $hasPost > POST_LIMIT;

        if ($hasNextPage) array_pop($result);

        $params = [
            'page' => $this->tag->page,
            'sort' => $this->tag->sort,
            'timeFrame' => $this->tag->timeFrame,
            'hasNextPage' => $hasNextPage,
        ];

        if (!empty($result)) {
            $params['posts'] = $result;
            $params['posts'] = $this->preparePost($params['posts']);
            $params['isShowPagination'] = true;
        } else {
            $params['isShowPagination'] = false;
            $params['message'] = 'Chưa có bài viết nào.';
        }
        return $params;
    }
}
