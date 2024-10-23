"use trict";

document.addEventListener('DOMContentLoaded', async function () {
    const menuBtn = document.querySelector('.btn-menu');
    const sortContainer = document.querySelector('.sort-container');

    menuBtn.addEventListener('click', function () {
        showModelMenu(true, ["Tạo bài viết", "Bài viết theo thẻ", "Về chúng tôi"], [{}, {}, {}]);
    });

    sortContainer.querySelectorAll('a.sort').forEach(sort => {
        sort.addEventListener('click', function () {
            sortContainer.querySelectorAll('a.sort').forEach(item => item.classList.remove('active'));
            this.classList.add('active');
            sort = this.getAttribute('data-sort')
            console.log("Sort: ", sort);
        });
    });
});


async function loadPosts(sort, page) {
    
}