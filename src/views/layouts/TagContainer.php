<div class="tag-container column-16">
    <?php if (isset($currentTagData) || !empty($currentTagData)): ?>
        <div class="main-tag row-8">
            <img class="icon120" src="assets/images/tag.svg" alt="Tag">
            <div class="column-8">
                <h1><?= ($currentTagData['name']) ?></h1>
                <h3><?= $currentTagData['post_count'] ?> bài viết</h3>
                <h5>Xuất hiện từ <?= $currentTagData['created'] ?></h5>
            </div>
        </div>
    <?php endif ?>
    <div class="column-8">
        <div class="row-space-between">
            <p class="title-medium">Có thể sẽ hữu ích với bạn</p>
            <a href="/tags/all" class="body-small">Xem tất cả</a>
        </div>
        <div class="tag-item row-16">
            <?php foreach ($popularityTag as $tag): ?>
                <a href="/tags/<?= $tag['name'] ?>" class="tag body-medium">#<?= $tag['name'] ?></a>
            <?php endforeach ?>
        </div>
    </div>
</div>