<article class="post">
    <div class="post-author row-8">
        <img class="author-image icon40" src="../../assets/images/account.svg" alt="Author avatar">
        <div class="column-zero">
            <p class="author-name title-large"><?php echo htmlspecialchars($postData['name']); ?></p>
            <p class="posted-at body-small"><?php echo htmlspecialchars($postData['created_at']); ?></p>
        </div>
    </div>

    <a class="post-title word-action" href="/post/<?php echo $postData['id']; ?>">
        <h1 class="title-extra-large"><?php echo htmlspecialchars($postData['title']); ?></h1>
    </a>

    <div class="post-interacts row-16">
        <div class="row-8" title="Lượt thích">
            <img class="icon24" src="../../assets/images/thumbUp.svg" alt="Like">
            <p class="title-medium"><?php echo htmlspecialchars($postData['like_count']) ?></p>
        </div>
        <div class="row-8" title="Bình luận">
            <img class="icon24" src="../../assets/images/comment.svg" alt="Comment">
            <p class="title-medium"><?php echo htmlspecialchars($postData['comment_count']) ?></p>
        </div>
        <div class="row-8" title="Lượt xem">
            <img class="icon24" src="../../assets/images/eye.svg" alt="View">
            <p class="title-medium"><?php echo htmlspecialchars($postData['view_count']) ?></p>
        </div>
    </div>
</article>