<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="http://localhost/">
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
            <div class="comment-container">
                <div class="write-comment">
                    <input type="text" name="" id="" placeholder="Binh Luan">
                    <button>Binh Luan</button>
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
</body>

</html>