<div class="comment column-16">
    <div class="author row-8">
        <img src="assets/images/<?= $comment['avatar'] ?>" alt="Avatar" class="avatar icon40 circle-shape">
        <div class="column-zero">
            <p class="title-medium"><?= $comment['name'] ?></p>
            <p class="body-small"><?= $comment['commented'] ?></p>
        </div>
    </div>
    <p class="content"><?= $comment['content'] ?></p>
    <div class="action-list">
        <a href="/" class="action"><img class="icon24" src="assets/images/reply.svg" alt="Reply"></a>
    </div>
</div>