document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const txtName = form.querySelector('.name-input');
    const txtEmail = form.querySelector('.email-input');
    const txtPassword = form.querySelector('.password-input');
    const txtPasswordConfirm = form.querySelector('.password-confirm-input');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const name = txtName.value;
        const email = txtEmail.value;
        const password = txtPassword.value;
        const passwordConfirm = txtPasswordConfirm.value;

        try {
            const response = await fetch('/user/create', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    password: password,
                    passwordConfirm: passwordConfirm
                })
            });

            const result = await response.json();
            let message = null;

            if (result.status === 'success') {
                message = `<p class="message success title-small">${result.message}</p>`;
                form.reset();
            } else {
                message = `<p class="message error title-small">${result.message}</p>`;
            }

            if (form.querySelector('p.message')) form.querySelector('p.message').remove();
            txtPasswordConfirm.insertAdjacentHTML('afterend', message);

        } catch (error) {
            console.error("Lỗi xảy ra:", error);
        }
    });
});
