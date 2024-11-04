<article class="post">
    <div class="post-author row-8">
        <img loading="lazy" class="author-image icon40" src="assets/images/<?php echo htmlspecialchars($post['avatar']) ?>" alt="Author avatar">
        <div class="column-zero">
            <p class="author-name title-large"><?php echo htmlspecialchars($post['name']); ?></p>
            <p class="posted-at body-small"><?php echo htmlspecialchars($post['created']); ?></p>
        </div>
    </div>

    <a class="post-title word-action" href="/posts/<?php echo intval($post['id']); ?>">
        <h1 class="title-extra-large"><?php echo htmlspecialchars($post['title']); ?></h1>
    </a>
    <?php if ($post['tags'] !== null): ?>
        <div class="tag-container row-8">
            <?php foreach ($post['tags'] as $tag) {
                require __DIR__ . '/../layouts/tag.php';
            } ?>
        </div>
    <?php endif ?>
    <div class="post-interacts row-16">
        <div class="row-8" title="Lượt thích">
            <img class="icon24" src="../../assets/images/favorite.svg" alt="Favorite">
            <p class="title-medium"><?php echo htmlspecialchars($post['like_count']) ?></p>
        </div>
        <div class="row-8" title="Bình luận">
            <img class="icon24" src="../../assets/images/comment.svg" alt="Comment">
            <p class="title-medium"><?php echo htmlspecialchars($post['comment_count']) ?></p>
        </div>
    </div>
</article>