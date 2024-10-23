<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="http://localhost/">
    <link rel="stylesheet" href="assets/css/css.css">
    <title>Trang Chủ</title>
</head>

<body>
    <?php include_once __DIR__ . '/../layouts/header.php'; ?>
    <main>
        <div class="container">
            <div class="sort-container row-16">
                <a class="sort action active" data-sort="newest">Mới nhất</a>
                <a class="sort action" data-sort="oldest">Cũ nhất</a>
                <a class="sort action" data-sort="popularity">Nổi bật</a>
            </div>
            <div class="post-list column-8">
                <div class="loader"></div>
            </div>
        </div>
    </main>
    <?php include_once __DIR__ . '/../layouts/footer.php'; ?>

    <script src="assets/js/js.js"></script>
    <script src="assets/js/home.js"></script>
</body>

</html>