<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="http://localhost/">
    <link rel="stylesheet" href="../../../assets/css/css.css">
    <title>Trang Chủ</title>
</head>

<body>
    <?php include_once __DIR__ . '/../layouts/header.php'; ?>
    <main>
        <div class="container">
            <div class="sort-container row-16">
                <a href="/" class="sort-newest title-large word-action">Mới nhất</a>
                <a href="/" class="sort-oldest body-large word-action">Cũ nhất</a>
                <a href="/" class="sort-popularity body-large word-action">Nổi bật</a>
            </div>
            <div class="post-list column-8">
                <?php if (isset($posts) && count($posts) > 0): ?>
                    <?php foreach ($posts as $postData): ?>
                        <?php include __DIR__ . '/../templates/post.php'; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <h2>Không có bài viết nào.</h2>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <?php include_once __DIR__ . '/../layouts/footer.php'; ?>
</body>

</html>