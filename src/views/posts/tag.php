<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="http://localhost/tags">
    <link rel="stylesheet" href="assets/css/css.css">
    <title><?php echo htmlspecialchars($tagData['name']) ?></title>
</head>

<body>
    <?php require_once __DIR__ . '/../layouts/header.php'; ?>
    <main>
        <div class="container">
            <?php require_once __DIR__ . '/../layouts/TagContainer.php'; ?>
            <div class="sort-container row-space-between">
                <div class="sort-origin row-16">
                    <a href="tags/<?= $currentTag ?>/newest/1" class="sort action <?php if ($sort === 'newest'): ?> active <?php endif ?>" data-sort="newest">Mới nhất</a>
                    <a href="tags/<?= $currentTag ?>/oldest/1" class="sort action <?php if ($sort === 'oldest'): ?> active <?php endif ?>" data-sort="oldest">Cũ nhất</a>
                    <a href="tags/<?= $currentTag ?>/popularity/week/1" class="sort action <?php if ($sort === 'popularity'): ?> active <?php endif ?>" data-sort="popularity">Nổi bật</a>
                </div>
                <?php if ($sort === 'popularity'): ?>
                    <div class="time-frame row-16">
                        <a href="tags/<?= $currentTag ?>/popularity/week/1" class="sort action <?php if ($timeFrame === 'week'): ?> active <?php endif ?>" data-sort="week">Tuần</a>
                        <a href="tags/<?= $currentTag ?>/popularity/month/1" class="sort action <?php if ($timeFrame === 'month'): ?> active <?php endif ?>" data-sort="month">Tháng</a>
                        <a href="tags/<?= $currentTag ?>/popularity/year/1" class="sort action <?php if ($timeFrame === 'year'): ?> active <?php endif ?>" data-sort="year">Năm</a>
                        <a href="tags/<?= $currentTag ?>/popularity/infinite/1" class="sort action <?php if ($timeFrame === 'infinite'): ?> active <?php endif ?>" data-sort="infinite">Tất cả</a>
                    </div>
                <?php endif ?>
            </div>

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
                            <a class="icon24" href="/tags/<?= $currentTag ?>/<?= $sort ?>/<?= $timeFrame ?>/<?= $page - 1 ?>"><img src="assets/images/arrow-left.svg" alt="Previous page"></a>
                        <?php else: ?>
                            <a class="icon24" href="/tags/<?= $currentTag ?>/<?= $sort ?>/<?= $page - 1 ?>"><img src="assets/images/arrow-left.svg" alt="Previous page"></a>
                        <?php endif; ?>
                    <?php endif; ?>

                    <span><?= $page ?></span>
                    <?php if ($hasNextPage): ?>
                        <?php if ($sort === 'popularity'): ?>
                            <a class="icon24" href="/tags/<?= $currentTag ?>/<?= $sort ?>/<?= $timeFrame ?>/<?= $page + 1 ?>"><img src="assets/images/arrow-right.svg" alt="Next page"></a>
                        <?php else: ?>
                            <a class="icon24" href="/tags/<?= $currentTag ?>/<?= $sort ?>/<?= $page + 1 ?>"><img src="assets/images/arrow-right.svg" alt="Next page"></a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <?php require_once __DIR__ . '/../layouts/footer.php'; ?>

    <script src="assets/js/js.js"></script>
</body>

</html>