<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Tag;

use PDO;

class TagController extends Controller
{

    private $db;
    private $tag;

    public function __construct($db)
    {
        $this->db = $db;
        $this->tag = new Tag($db);
    }

    public function index($tagName = null, $sort = 'newest', $timeFrame = null, $page = 1)
    {
        $allTag = $this->getAllTag();
        $tagData = $this->getTagInfo($tagName);
        $postData = $this->getPostByTagName(tagName: $tagName, sort: $sort, timeFrame: $timeFrame, page: $page);

        $data = [
            'currentTag' => $tagName,
            'selected' => $tagName ? true : false,
            'allTag' => $allTag,
            'tagData' => $tagData,
            'posts' => $postData['posts'] ?? [],
            'isShowPagination' => $postData['isShowPagination'] ?? false,
            'hasNextPage' => $postData['hasNextPage'],
            'message' => $postData['message'] ?? '',
            'page' => $postData['page'] ?? 1,
            'sort' => $postData['sort'] ?? 'newest',
            'timeFrame' => $postData['timeFrame'] ?? null,
        ];

        $this->render(view: 'posts/tag', data: $data);
    }

    public function getAllTag()
    {
        $stmt = $this->tag->getTagPopularity();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTagInfo($tagName = null)
    {
        $this->tag->tagName = $tagName;
        $stmt = $this->tag->getTagInfoByTagName();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $result['created'] = $this->timeAgo($result['created']);
            return $result;
        }
    }

    public function getPostByTagName($tagName = null, $sort = 'newest', $timeFrame = null, $page = 1)
    {

        $limit = 12;
        $this->tag->setPagination(page: $page, limit: $limit);

        if ($tagName) {
            $this->tag->tagName = $tagName;
        }

        $stmt = null;
        $popularityMethods = [
            'week' => 'sortWeek',
            'month' => 'sortMonth',
            'year' => 'sortYear',
            'infinite' => 'sortPopularity'
        ];

        switch ($sort) {
            case "newest":
                $stmt = $this->tag->sortNewest();
                break;
            case "oldest":
                $stmt = $this->tag->sortOldest();
                break;
            case "popularity":
                if (isset($popularityMethods[$timeFrame])) {
                    $stmt = $this->tag->{$popularityMethods[$timeFrame]}();
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
            'page' => $this->tag->page,
            'sort' => $sort,
            'timeFrame' => $timeFrame,
            'hasNextPage' => $hasNextPage,
        ];

        if ($hasPost) {
            $params['posts'] = $result;

            foreach ($params['posts'] as &$post) {
                if (isset($post['tags'])) {
                    $post['tags'] = explode(',', $post['tags']);
                } else {
                    $post['tags'] = [];
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

        return $params;
    }
}
