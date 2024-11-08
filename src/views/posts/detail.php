<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="http://localhost/">
    <?php if ($page == 1): ?>
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <?php endif ?>
    <link rel="stylesheet" href="assets/css/css.css">
    <link rel="stylesheet" href="assets/css/post_detail.css">
    <title><?php echo $postData['title'] ?> | iForum</title>
</head>

<body>
    <?php include_once __DIR__ . '/../layouts/header.php'; ?>
    <main>
        <div class="container">
            <!-- Post Detail -->
            <?php if ($page == 1): ?>
                <div class="post-detail-container">
                    <div class="row-space-between">
                        <div class="post-detail-author row-8">
                            <img class="author-image icon40 circle-shape" src="assets/images/<?= $postData['avatar'] ?>" alt="Author avatar">
                            <div class="column-zero">
                                <p class="author-name title-large"><?php echo htmlspecialchars($postData['name']); ?></p>
                                <p class="posted-at body-small"><?php echo htmlspecialchars($postData['created']); ?></p>
                            </div>
                        </div>
                        <div class="row-16">
                            <a href="/" class="btn-edit-post action icon24"><img src="assets/images/edit.svg" alt="Edit"></a>
                            <a href="/" class="btn-more action icon24"><img src="assets/images/more_vert.svg" alt="More"></a>
                        </div>
                    </div>
                    <h1 class="title title-extra-large"><?php echo $postData['title']; ?></h1>

                    <div class="content"><?php echo $postData['content']; ?></div>

                    <?php if ($postData['tags'] !== null): ?>
                        <div class="tag-container row-8">
                            <?php foreach ($postData['tags'] as $tag) {
                                require __DIR__ . '/../layouts/tag.php';
                            } ?>
                        </div>
                    <?php endif ?>
                    <div class="interacts-container row-space-between">
                        <a href="/" class="btn-like"><img class="icon24" src="assets/images/favorite.svg" alt="Like"></a>
                        <div class="row-16">
                            <div class="row-8">
                                <img class="icon24" src="assets/images/favorite.svg" alt="Like">
                                <p class="title-medium"><?= $postData['like_count'] ?></p>
                            </div>
                            <div class="row-8">
                                <img class="icon24" src="assets/images/comment.svg" alt="Comment">
                                <p class="title-medium"><?= $postData['comment_count'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <a href="/posts/<?= $_SESSION['postId'] ?>" class="return-to-post title-medium">Quay lại bài viết</a>
            <?php endif ?>
            <!-- Quill Editor -->
            <?php if ($page == 1) require_once __DIR__ . '/../layouts/editor.php' ?>

            <!-- Comment container -->
            <?php if ($totalComments <= 0): ?>
                <?php require_once __DIR__ . '/../layouts/EndMessage.php'; ?>
            <?php else: ?>
                <div class="comment-container column-16">
                    <!-- Count comment and sort -->
                    <div class="row-space-between">
                        <p class="title-large"><?= $totalComments ?> bình luận</p>
                        <div class="sort-container row-16">
                            <a href="/posts/<?= $_SESSION['postId'] ?>/newest/1" class="sort action<?php if ($sort === 'newest'): ?> active<?php endif ?>">Mới nhất</a>
                            <a href="/posts/<?= $_SESSION['postId'] ?>/oldest/1" class="sort action<?php if ($sort === 'oldest'): ?> active <?php endif ?>">Cũ nhất</a>
                        </div>
                    </div>

                    <!-- Comment list -->
                    <div class="comment-list column-16">
                        <?php foreach ($comments as $comment) {
                            require __DIR__ . '/../layouts/comment.php';
                        } ?>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a class="icon24" href="posts/<?= $_SESSION['postId'] ?>/<?= $sort ?>/<?= $page - 1 ?>"><img src="assets/images/arrow-left.svg" alt="Previous page"></a>
                        <?php endif; ?>
                        <span><?= $page ?></span>
                        <?php if ($hasNextPage): ?>
                            <a class="icon24" href="posts/<?= $_SESSION['postId'] ?>/<?= $sort ?>/<?= $page + 1 ?>"><img src="assets/images/arrow-right.svg" alt="Next page"></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </main>
    <?php include_once __DIR__ . '/../layouts/footer.php'; ?>
    <script src="assets/js/post-detail.js"></script>
    <script src="assets/js/js.js"></script>
    <?php if ($page == 1): ?>
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
        <script>
            const quill = new Quill('#editor', {
                theme: 'snow'
            });
        </script>
    <?php endif ?>
</body>

</html>