"use strict";


document.addEventListener('DOMContentLoaded', async function () {
    const loginForm = document.querySelector('.login-origin');
    const txtEmail = loginForm.querySelector('.email-input');
    const txtPassword = loginForm.querySelector('.password-input');
    const btnSubmit = loginForm.querySelector('.btn-submit');

    loginForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const email = txtEmail.value.trim();
        const password = txtPassword.value.trim();

        if (email === '' || password === '') {
            return;
        }

        const result = await asyncFetch('user/login', {
            method: 'POST',
            body: { email: email, password: password }
        });
    });
});