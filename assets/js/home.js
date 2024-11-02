"use strict";

const sortStr = `<div class="time-frame row-16">
    <button class="sort action active" data-sort="week">Tuần</button>
    <button class="sort action" data-sort="month">Tháng</button>
    <button class="sort action" data-sort="year">Năm</button>
    <button class="sort action" data-sort="infinite">Tất cả</button>
</div>`;

const loader = `<div class="loader"></div>`;

let page = 0;
let isLoading = false;
let isHasMorePost = true;
const limit = 10;
let sort = 'newest';
let time_frame = 'week';

const postList = document.querySelector('.post-list');
const sortContainer = document.querySelector('.sort-container');

const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting && !isLoading && isHasMorePost) {
            isLoading = true;
            page++;
            loadPosts({ page: page, sort: sort, time_frame: time_frame });
        }
    });
}, {
    root: null,
    rootMargin: '0px',
    threshold: 1.0
});

sortContainer.querySelectorAll('.sort-origin .sort').forEach(s => {
    s.addEventListener('click', async function () {
        sortContainer.querySelectorAll('.sort-origin .sort').forEach(item => item.classList.remove('active'));

        this.classList.add('active');
        sort = this.getAttribute('data-sort');

        page = 0;
        isHasMorePost = true;

        if (sort === 'popularity') {
            if (isElementExists(sortContainer, '.time-frame')) removeElement(sortContainer, '.time-frame');

            sortContainer.insertAdjacentHTML('beforeend', sortStr);
            const timeFrame = sortContainer.querySelector('.time-frame');

            timeFrame.querySelectorAll('button.sort').forEach(time => {
                time.addEventListener('click', async function () {
                    timeFrame.querySelectorAll('button.sort').forEach(item => item.classList.remove('active'));
                    this.classList.add('active');
                    time_frame = this.getAttribute('data-sort');

                    page = 0;
                    isHasMorePost = true;

                    await loadPosts({ sort: sort, time_frame: time_frame });
                });
            });
        } else {
            removeElement(sortContainer, '.time-frame');
        }
        await loadPosts({ sort: sort });
    });
});

async function loadPosts({ sort = 'newest', page = 0, time_frame = 'week' }) {
    try {
        handleLoaderDisplay(page);

        const fetchData = new FetchData(`/${sort}/${time_frame}/${page}`);
        const result = await fetchData.get();

        if (result.status !== 'success') {
            return displayError(result.message);
        }

        processPostData(result.data, result.count);

    } catch (e) {
        isLoading = false;
        console.error('Lỗi:', e.message);
    }
}

function handleLoaderDisplay(page) {
    const loader = new Loader(postList);

    if (page === 0 && !loader.isExists()) {
        loader.display();
    } else {
        loader.insert();
    }
}

function processPostData(data, count) {
    postList.classList.remove('column-center');
    data.forEach(post => renderPost(post));

    isHasMorePost = count >= limit;
    observePostList();

    isLoading = false;
}

function observePostList() {
    const posts = document.querySelectorAll('.post');
    if (isHasMorePost && posts.length > 2) {
        const secondLastPost = posts[posts.length - 2];
        observer.observe(secondLastPost);
    }
}

function renderPost(post) {
    const avatar = post.avatar ? `assets/images/${post.avatar}` : 'assets/images/account.svg';
    const formattedDate = timeSince(post.created);

    const postStr = `<article class="post">
        <div class="post-author row-8">
            <img class="author-image icon40" src="${avatar}" alt="Author avatar">
            <div class="column-zero">
                <p class="author-name title-large">${post.name || 'Ẩn danh'}</p>
                <p class="posted-at body-extra-small">${formattedDate}</p>
            </div>
        </div>
        <a class="post-title word-action" href="/posts/${post.id}">
            <h1 class="title-extra-large">${post.title}</h1>
        </a>
        <div class="post-interacts row-16">
            <div class="row-8" title="Lượt thích">
                <img class="icon24" src="../../assets/images/thumbUp.svg" alt="Like">
                <p class="title-medium">${post.like_count}</p>
            </div>
            <div class="row-8" title="Bình luận">
                <img class="icon24" src="../../assets/images/comment.svg" alt="Comment">
                <p class="title-medium">${post.comment_count}</p>
            </div>
        </div>
    </article>`;

    removeAllElement(postList, '.loader');
    postList.insertAdjacentHTML('beforeend', postStr);
}

function displayError(message) {
    removeAllElement(postList, '.loader');
    postList.classList.add('column-center');
    const modal = new Modal();
    modal.showEndMessage(true, message, 'face_01', postList);
}


document.addEventListener('DOMContentLoaded', async function () {
    await loadPosts({ page: page, limit: limit, sort: sort, time_frame: time_frame });
});
