<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="http://localhost/">
    <link rel="stylesheet" href="assets/css/css.css">
    <link rel="stylesheet" href="assets/css/post_detail.css">
    <title><?php echo $post['title'] ?> | iForum</title>
</head>

<body>
    <?php include_once __DIR__ . '/../layouts/header.php'; ?>
    <main>
        <div class="container">
            <div class="post-detail-container">
                <div class="row-space-between">
                    <div class="post-detail-author row-8">
                        <img class="author-image icon40" src="assets/images/account.svg" alt="Author avatar">
                        <div class="column-zero">
                            <p class="author-name title-large"><?php echo htmlspecialchars($post['name']); ?></p>
                            <p class="posted-at body-small"><?php echo htmlspecialchars($post['created_at']); ?></p>
                        </div>
                    </div>
                    <div class="row-16">
                        <a href="/" class="btn-edit-post action icon24"><img src="assets/images/edit.svg" alt="Edit"></a>
                        <a href="/" class="btn-more action icon24"><img src="assets/images/more_vert.svg" alt="More"></a>
                    </div>
                </div>

                <h1 class="title"><?php echo $post['title']; ?></h1>
                <div class="content"><?php echo $post['content']; ?></div>
                <div class="interacts row-16">
                    <div class="row-8">
                        <img class="icon24" src="assets/images/thumbUp.svg" alt="Like">
                        <p class="title-medium"><?php echo htmlspecialchars($post['like_count']) ?></p>
                    </div>
                    <div class="row-8">
                        <img class="icon24" src="assets/images/comment.svg" alt="Comment">
                        <p class="title-medium"><?php echo htmlspecialchars($post['comment_count']) ?></p>
                    </div>
                    <div class="row-8">
                        <img class="icon24" src="assets/images/eye.svg" alt="View">
                        <p class="title-medium"><?php echo htmlspecialchars($post['view_count']) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include_once __DIR__ . '/../layouts/footer.php'; ?>
</body>

</html>