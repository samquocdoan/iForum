"use strict";

async function asyncFetch(url, options = {}) {
    const controller = new AbortController();
    const { signal } = controller;
    const timeout = options.timeout || 10000;

    const fetchOptions = {
        method: options.method || 'GET',
        headers: {
            'Content-Type': 'application/json',
            ...options.headers
        },
        body: (options.method === 'POST' || options.method === 'PUT') ? JSON.stringify(options.body) : null,
        signal
    }

    const timeoutId = setTimeout(() => controller.abort(), timeout);

    try {
        const response = await fetch(url, fetchOptions);

        clearTimeout(timeoutId);

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const result = await response.json();
        return result;

    } catch (error) {
        if (error.name === 'AbortError') {
            throw new Error('Request timed out');
        }
        throw error;
    }
}


function showModelMenu(isShow = false, titles = [], actions = []) {
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
        a.className = 'action body-medium';
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

function showModalLoading(isShow, message = '') {
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

function showModalNotice(title, imgaeName, message, buttonTitle, action = function () { }) {
    const myModal = `<div id="modalNotice" class="modal">
        <div class="modal-content">
            <p class="title_medium">${title}</p>
            <img class="pad_ver_16 icon120" src="${BASE_URL}assets/images/${imgaeName}.svg" alt="Successfully">
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

function showModalConfirm(title, message, yes = function () { }, no = function () { }) {
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

function showEndMessage(isShow = false, title, image, container) {
    if (!isShow) {
        container.document.getElementById("endMessage").remove();
    }
    const html = `<div id="endMessage" class="end-message">
        <img class="icon120" src="${BASE_URL}assets/images/${image}.svg" alt="End post">
        <p class="title_small">${title}</p>
    </div>`;

    container.insertAdjacentHTML('beforeend', html);
}

function showNotFound(isShow = false, title, image, titleButton, action = {}) {
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


const menuBtn = document.querySelector('.btn-menu');
const accountBtn = document.querySelector('.btn-account');

menuBtn.addEventListener('click', function () {
    showModelMenu(true, ["Tạo bài viết", "Bài viết theo thẻ", "Về chúng tôi"], [{}, {}, {}]);
});

accountBtn.addEventListener('click', function() {
    showModelMenu(true, ["Tạo bài viết", "Bài viết theo thẻ", "Về chúng tôi"], [{}, {}, {}]);
});