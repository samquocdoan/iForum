<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="http://localhost/">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/css.css">
    <link rel="stylesheet" href="assets/css/post_detail.css">
    <title><?php echo $postData['title'] ?> | iForum</title>
</head>

<body>
    <?php include_once __DIR__ . '/../layouts/header.php'; ?>
    <main>
        <div class="container">
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
            <p class="title-large">Bình luận</p>
            <div class="comment-container column-16">
                <form class="write-comment">
                    <div id="editor"></div>
                    <div class="row-8">
                        <button class="btn-cancel title-small action" disabled>Hủy</button>
                        <button class="btn-comment title-small action" disabled>Xuất bản</button>
                    </div>
                </form>

                <p class="title-medium">Danh sách bình luận [69]</p>
                <div class="sort-container row-space-between">
                    <div class="sort-origin row-16">
                        <a href="tags/<?= $currentTagData['name'] ?>/newest/1" class="sort action<?php if ($sort === 'newest'): ?> active<?php endif ?>">Mới nhất</a>
                        <a href="tags/<?= $currentTagData['name'] ?>/oldest/1" class="sort action<?php if ($sort === 'oldest'): ?> active<?php endif ?>">Cũ nhất</a>
                        <a href="tags/<?= $currentTagData['name'] ?>/popularity/week/1" class="sort action<?php if ($sort === 'popularity'): ?> active<?php endif ?>">Nổi bật</a>
                    </div>
                    <?php if ($sort === 'popularity'): ?>
                        <div class="time-frame row-16">
                            <a href="tags/<?= $currentTagData['name'] ?>/popularity/week/1" class="sort action<?php if ($timeFrame === 'week'): ?> active<?php endif ?>">Tuần</a>
                            <a href="tags/<?= $currentTagData['name'] ?>/popularity/month/1" class="sort action<?php if ($timeFrame === 'month'): ?> active<?php endif ?>">Tháng</a>
                            <a href="tags/<?= $currentTagData['name'] ?>/popularity/year/1" class="sort action<?php if ($timeFrame === 'year'): ?> active<?php endif ?>">Năm</a>
                            <a href="tags/<?= $currentTagData['name'] ?>/popularity/infinite/1" class="sort action<?php if ($timeFrame === 'infinite'): ?> active<?php endif ?>">Tất cả</a>
                        </div>
                    <?php endif ?>
                </div>
                <div class="comment-list">
                    <?php foreach ($comments as $comment) {
                        require __DIR__ . '/../layouts/comment.php';
                    } ?>
                </div>
            </div>
        </div>
    </main>
    <?php include_once __DIR__ . '/../layouts/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow'
        });
    </script>
</body>

</html>