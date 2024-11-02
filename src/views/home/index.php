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
            <?php require_once __DIR__ . '/../layouts/SortContainer.php'; ?>
            <div class="post-list column-8">
                <?php if (empty($posts)) {
                    require __DIR__ . '/../layouts/EndMessage.php';
                } else {
                    foreach ($posts as $post) {
                        require __DIR__ . '/../layouts/post.php';
                    }
                } ?>
            </div>
            <?php if ($isShowPagination): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <?php if ($sort === 'popularity'): ?>
                            <a class="icon24" href="/<?= $sort ?>/<?= $timeFrame ?>/<?= $page - 1 ?>"><img src="assets/images/arrow-left.svg" alt="Previous page"></a>
                        <?php else: ?>
                            <a class="icon24" href="/<?= $sort ?>/<?= $page - 1 ?>"><img src="assets/images/arrow-left.svg" alt="Previous page"></a>
                        <?php endif; ?>
                    <?php endif; ?>

                    <span><?= $page ?></span>
                    <?php if ($hasNextPage): ?>
                        <?php if ($sort === 'popularity'): ?>
                            <a class="icon24" href="/<?= $sort ?>/<?= $timeFrame ?>/<?= $page + 1 ?>"><img src="assets/images/arrow-right.svg" alt="Next page"></a>
                        <?php else: ?>
                            <a class="icon24" href="/<?= $sort ?>/<?= $page + 1 ?>"><img src="assets/images/arrow-right.svg" alt="Next page"></a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <?php include_once __DIR__ . '/../layouts/footer.php'; ?>
    <script src="assets/js/js.js"></script>
</body>

</html>