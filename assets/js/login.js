"use strict";


document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const txtEmail = form.querySelector('.email-input');
    const txtPassword = form.querySelector('.password-input');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const email = txtEmail.value;
        const password = txtPassword.value;

        try {
            const response = await fetch('/user/login', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    email: email,
                    password: password
                })
            });

            const result = await response.json();
            let message = null;

            if (result.status === 'success') {
                window.location.href = '/';
            } else {
                message = `<p class="message error title-small">${result.message}</p>`;
            }
            
            if (message !== null) {
                if (form.querySelector('p.message')) form.querySelector('p.message').remove();
                txtPassword.insertAdjacentHTML('afterend', message);
            }


        } catch (error) {
            console.error("Lỗi xảy ra:", error);
        }
    });
});
