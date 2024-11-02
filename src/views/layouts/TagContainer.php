<div class="tag-container column-8">
    <?php if ($selected): ?>
        <div class="main-tag">
            <div class="row-space-between">
                <h1><?php echo $tagData['name'] ?></h1>
                <h3><?php echo $tagData['post_count'] ?> bài viết</h3>
            </div>
            <h5>Bài viết đầu tiên vào <?php echo $tagData['created'] ?></h5>
        </div>
    <?php endif ?>
    <div class="column-8 pad-top-24">
        <p class="title-medium">Có thể sẽ hữu ích với bạn</p>
        <div class="tag-item row-16">
            <?php foreach ($allTag as $tag): ?>
                <a href="/tags/<?php echo $tag['name'] ?>" class="tag body-medium">#<?php echo $tag['name'] ?></a>
            <?php endforeach ?>
        </div>
    </div>
</div>