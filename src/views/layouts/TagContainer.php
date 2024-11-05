<div class="tag-container column-16">
    <?php if (isset($currentTagData) || !empty($currentTagData)): ?>
        <div class="main-tag">
            <div class="column-zero">
                <h1><?= ($currentTagData['name']) ?></h1>
                <h3><?= $currentTagData['post_count'] ?> bài viết</h3>
            </div>
            <h5>Xuất hiện từ <?= $currentTagData['created'] ?></h5>
        </div>
    <?php else: ?>
        <div class="column-8">
            <p class="title-medium">Có thể sẽ hữu ích với bạn</p>
            <div class="tag-item row-16">
                <?php foreach ($popularityTag as $tag): ?>
                    <a href="/tags/<?= $tag['name'] ?>" class="loading tag body-medium">#<?= $tag['name'] ?></a>
                <?php endforeach ?>
                <a href="/all-tags" class="loading tag body-medium">Xem tất cả</a>
            </div>
        </div>
    <?php endif ?>
</div>