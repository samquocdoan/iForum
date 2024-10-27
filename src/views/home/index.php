<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="iForum là một diễn đàn trực tuyến nơi mọi người có thể thảo luận, chia sẻ và học hỏi từ nhau về nhiều chủ đề khác nhau.">
    <meta name="keywords" content="diễn đàn, thảo luận, chia sẻ, học hỏi, iForum">
    <meta name="author" content="DoanSam">
    <meta name="robots" content="index, follow">
    <base href="http://localhost/">
    <link rel="stylesheet" href="assets/css/css.css">
    <title>Trang Chủ</title>
</head>

<body>
    <?php include_once __DIR__ . '/../layouts/header.php'; ?>
    <main>
        <div class="container">
            <div class="sort-container row-space-between">
                <div class="sort-origin row-16">
                    <a href="/newest/1" class="sort action <?php if ($sort === 'newest'): ?> active <?php endif ?>" data-sort="newest">Mới nhất</a>
                    <a href="/oldest/1" class="sort action <?php if ($sort === 'oldest'): ?> active <?php endif ?>" data-sort="oldest">Cũ nhất</a>
                    <a href="/popularity/week/1" class="sort action <?php if ($sort === 'popularity'): ?> active <?php endif ?>" data-sort="popularity">Nổi bật</a>
                </div>
                <?php if ($sort === 'popularity') {
                    require __DIR__ . '/../layouts/time_frame.php';
                }
                ?>
            </div>
            <div class="post-list column-8">
                <?php foreach ($posts as $post) {
                    require __DIR__ . '/../layouts/post.php';
                } ?>
            </div>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <?php if ($sort === 'popularity'): ?>
                        <a class="icon24" href="/<?= $sort ?>/<?= $time_frame ?>/<?= $page - 1 ?>"><img src="assets/images/arrow-left.svg" alt="Previous page"></a>
                    <?php else: ?>
                        <a class="icon24" href="/<?= $sort ?>/<?= $page - 1 ?>"><img src="assets/images/arrow-left.svg" alt="Previous page"></a>
                    <?php endif; ?>
                <?php endif; ?>

                <span><?= $page ?></span>
                <?php if ($hasNextPage): ?>
                    <?php if ($sort === 'popularity'): ?>
                        <a class="icon24" href="/<?= $sort ?>/<?= $time_frame ?>/<?= $page + 1 ?>"><img src="assets/images/arrow-right.svg" alt="Next page"></a>
                    <?php else: ?>
                        <a class="icon24" href="/<?= $sort ?>/<?= $page + 1 ?>"><img src="assets/images/arrow-right.svg" alt="Next page"></a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <?php include_once __DIR__ . '/../layouts/footer.php'; ?>
    <script src="assets/js/js.js"></script>
</body>

</html>