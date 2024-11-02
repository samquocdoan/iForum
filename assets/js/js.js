"use strict";

class FetchData {
    constructor(url, options = {}) {
        this.url = url;
        this.options = options;
    }

    async get() {
        return await this.request('GET');
    }

    async post() {
        return await this.request('POST');
    }

    async delete() {
        return await this.request('DELETE');
    }

    async update() {
        return await this.request('PUT');
    }

    async request(method) {
        const controller = new AbortController();
        const { signal } = controller;
        const timeout = this.options.timeout || 15000;

        const fetchOptions = {
            method: method,
            signal,
            headers: { 'Content-Type': 'application/json', ...this.options.headers },
        };

        if (['POST', 'PUT'].includes(method) && this.options.body) {
            fetchOptions.body = JSON.stringify(this.options.body);
        }

        const timeoutID = setTimeout(() => controller.abort(), timeout);

        try {
            const response = await fetch(this.url, fetchOptions);
            clearTimeout(timeoutID);

            const result = await response.json();

            if (!response.ok) {
                return { status: result.status, message: result.message || 'Unknown Error.' };
            }

            return { status: result.status, data: result.data };

        } catch (e) {
            clearTimeout(timeoutID);
            if (e.name === 'AbortError') {
                throw new Error('Request Timed Out.')
            }
            throw new Error('Fetch Error: ', e.message);
        }
    }
}

class Modal {
    showModelMenu(isShow = false, titles = [], actions = []) {
        if (document.getElementById('modalMenu')) {
            document.getElementById('modalMenu').remove();
        }

        if (!isShow) {
            document.getElementById('modalMenu').remove();
            return;
        }

        const modalString = `<div id="modalMenu" class="modal">
            <div class="modal-content column-16"></div>
        </div>`;

        document.querySelector('body').insertAdjacentHTML('beforeend', modalString);
        const myModal = document.getElementById('modalMenu');
        const myModalContent = myModal.querySelector('.modal-content');

        titles.forEach((title, index) => {
            const a = document.createElement('a');
            a.className = 'action title-medium';
            a.textContent = title;

            if (actions[index]) {
                a.onclick = actions[index];
            }

            myModalContent.appendChild(a);
        });

        myModal.addEventListener('click', (event) => {
            if (event.target === myModal) closeMenuModal();
        });

        function closeMenuModal() {
            myModal.remove();
        }

        myModal.style.display = 'flex';
    }

    showModalLoading(isShow, message = '') {
        if (!isShow) {
            document.querySelector('#modalLoading').remove();
            document.querySelector('body').style.overflow = 'auto';
            return;
        }
        const myModal = `<div id="modalLoading" class="modal">
            <div class="modal-content">
                <div class="loader"></div>
                <p class="title">${message}</p>
            </div>
        </div>`;
        document.querySelector('body').insertAdjacentHTML('beforeend', myModal);

        const modalLoading = document.getElementById('modalLoading');
        document.querySelector('body').style.overflow = 'hidden';

        modalLoading.style.display = 'flex';
    }

    showModalNotice(title, imageName, message, buttonTitle, action = function () { }) {
        const myModal = `<div id="modalNotice" class="modal">
            <div class="modal-content">
                <p class="title_medium">${title}</p>
                <img class="pad_ver_16 icon120" src="${BASE_URL}assets/images/${imageName}.svg" alt="Successfully">
                <p class="body_small">${message}</p>
                <button class="onclick">${buttonTitle}</button>
            </div>
        </div>`;
        document.querySelector('body').insertAdjacentHTML('beforeend', myModal);

        const modalNotice = document.getElementById('modalNotice');
        const button = document.querySelector('.modal-content button');

        button.addEventListener('click', () => {
            action();
            closeModal();
        });

        function closeModal() {
            modalNotice.remove();
        }

        modalNotice.addEventListener('click', (event) => {
            if (event.target === modalNotice) {
                closeModal();
            }
        });

        modalNotice.style.display = 'flex';
    }

    showModalConfirm(title, message, yes = function () { }, no = function () { }) {
        const myModal = `<div id="modalConfirm" class="modal">
            <div class="modal-content">
                <p class="title_medium">${title}</p>
                <p class="body_small">${message}</p>
                <hr>
                <div class="row_24">
                    <button class="no onclick">Thôi!</button>
                    <button class="yes onclick">Đồng ý</button>
                </div>
            </div>
        </div>`;
        document.querySelector('body').insertAdjacentHTML('beforeend', myModal);

        const modalConfirm = document.getElementById('modalConfirm');
        const btnNo = modalConfirm.querySelector('.modal-content button.no');
        const btnYes = modalConfirm.querySelector('.modal-content button.yes');

        btnYes.addEventListener('click', () => {
            yes();
            closeModal();
        });
        btnNo.addEventListener('click', () => {
            no();
            closeModal();
        });

        function closeModal() {
            modalConfirm.remove();
        }

        modalConfirm.style.display = 'flex';
    }

    showEndMessage(isShow = false, title, image, container) {
        if (!isShow) {
            container.document.getElementById("endMessage").remove();
        }
        const html = `<div id="endMessage" class="end-message">
            <img class="icon120" src="assets/images/${image}.svg" alt="End post">
            <p class="title_small">${title}</p>
        </div>`;

        container.insertAdjacentHTML('beforeend', html);
    }

    showNotFound(isShow = false, title, image, titleButton, action = {}) {
        if (!isShow) {
            document.querySelector('main .container .not-found').remove();
        }
        const container = document.querySelector('main .container');
        const html = `<div class="not-found">
            <img class="icon120" src="${BASE_URL}assets/images/${image}.svg" alt="Not Found">
            <p class="title_small">${title}</p>
            <button class="action">${titleButton}</button>
        </div>`;
        container.innerHTML = html;
        const myButton = container.querySelector('.not-found .action');

        myButton.addEventListener('click', () => {
            action();
        });
    }
}

class Loader {

    constructor(container) {
        this.container = container;
    }

    loader() {
        return `<div class="loader"></div>`;
    }

    display() {
        this.container.classList.add('column-center');
        this.container.innerHTML = this.loader();
    }

    insert() {
        this.container.classList.add('column-center');
        this.container.insertAdjacentHTML('beforeend', this.loader());
    }

    remove() {
        this.container.classList.remove('column-center');
        removeElement(this.container, '.loader');
    }

    isExists() {
        if (isElementExists(this.container, '.loader')) return true;
        return false;
    }
}

function isElementExists(container, target) {
    const targetElement = container.querySelector(target);
    if (!targetElement) return false;
    return true;
}

function removeElement(container, target) {
    const targetElement = container.querySelector(target);
    if (!targetElement) return;
    targetElement.remove();
}

function removeAllElement(container, target) {
    const targetElement = container.querySelectorAll(target);
    if (!targetElement) return;
    targetElement.forEach(element => {
        element.remove();
    });
}

function timeSince(postedDate) {
    const now = new Date();
    const secondsPast = Math.floor((now - new Date(postedDate)) / 1000);

    if (secondsPast < 60) {
        return `${secondsPast} giây trước`;
    } else if (secondsPast < 3600) {
        const minutes = Math.floor(secondsPast / 60);
        return `${minutes} phút trước`;
    } else if (secondsPast < 86400) {
        const hours = Math.floor(secondsPast / 3600);
        return `${hours} giờ trước`;
    } else if (secondsPast < 604800) {
        const days = Math.floor(secondsPast / 86400);
        return `${days} ngày trước`;
    } else if (secondsPast < 2592000) {
        const weeks = Math.floor(secondsPast / 604800);
        return `${weeks} tuần trước`;
    } else if (secondsPast < 31104000) {
        const months = Math.floor(secondsPast / 2592000);
        return `${months} tháng trước`;
    } else {
        const years = Math.floor(secondsPast / 31104000);
        return `${years} năm trước`;
    }
}


const menuBtn = document.querySelector('.btn-menu');
const accountBtn = document.querySelector('.btn-account');
const modal = new Modal();
menuBtn?.addEventListener('click', function () {
    modal.showModelMenu(true, ["Tạo bài viết", "Bài viết theo thẻ", "Về chúng tôi"],
        [
            () => {

            },

            function () {
                window.location.href = '/tags';
            },

            () => {

            }
        ]
    );
});

accountBtn?.addEventListener('click', function () {
    modal.showModelMenu(true, ["Tạo bài viết", "Bài viết theo thẻ", "Về chúng tôi"], [{}, {}, {}]);
});


const body = document.querySelector('body');

document.querySelectorAll('.sort.action').forEach(link => {
    link.addEventListener('click', function (event) {
        if (this.classList.contains('disabled')) {
            event.preventDefault();
            return;
        }

        body.classList.add('disabled');
    });
});
