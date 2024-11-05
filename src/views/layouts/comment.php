<div class="comment column-16">
    <div class="top row-16">
        <img src="assets/images/<?= $comment['avatar'] ?>" alt="Avatar" class="avatar icon40 circle-shape">
        <div class="column-4">
            <div class="row-8">
                <p class="title-medium"><?= $comment['name'] ?></p>
                <p class="body-small"><?= $comment['commented'] ?></p>
            </div>
            <p class="content"><?= $comment['content'] ?></p>
            <div class="action-list">
                <button class="btn-reply action">Phản hồi</button>
            </div>
        </div>
    </div>
</div>