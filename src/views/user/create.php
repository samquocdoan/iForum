<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="iForum là một diễn đàn trực tuyến nơi mọi người có thể thảo luận, chia sẻ và học hỏi từ nhau về nhiều chủ đề khác nhau.">
    <meta name="keywords" content="diễn đàn, thảo luận, chia sẻ, học hỏi, iForum">
    <meta name="author" content="DoanSam">
    <meta name="robots" content="index, follow">
    <base href="http://localhost/">
    <link rel="stylesheet" href="assets/css/css.css">
    <link rel="stylesheet" href="assets/css/register.css">
    <title>Đăng ký | iForum</title>
</head>

<body>
    <main>
        <div class="container">
            <div class="top column-8">
                <img class="icon120" src="assets/images/logo.svg" alt="Logo">
                <h2>Tham gia vào iForum</h2>
            </div>
            <form class="register-origin column-8" method="POST">
                <input class="name-input" type="text" placeholder="Tên của bạn" required>
                <input class="email-input" type="email" placeholder="Địa chỉ email của bạn" required>
                <input class="password-input" type="password" placeholder="Mật khẩu" required>
                <input class="password-confirm-input" type="password" placeholder="Nhập lại mật khẩu" required>
                <button type="submit" class="action title-medium">Đăng ký</button>
            </form>
            <div class="divider">
                <hr>
                <p class="title-small">Hoặc</p>
                <hr>
            </div>
            <div class="register-options row-8">
                <button class="action btn-google body-small" title="Google"><img class="icon24" src="assets/images/google.svg" alt="Google"></button>
                <button class="action btn-facebook body-small" title="Facebook"><img class="icon24" src="assets/images/facebook.svg" alt="Facebook"></button>
                <button class="action btn-github body-small" title="Github"><img class="icon24" src="assets/images/github.svg" alt="Github"></button>
            </div>
            <div class="bottom">
                <p class="body-small">Đã có tài khoản? <a class="action title-small" href="user/login">Tới đăng nhập</a></p>
                <p class="body-small">Trước đó tôi muốn <a class="action title-small" href="/">khám phá</a></p>
            </div>
        </div>
    </main>
    <script src="assets/js/js.js"></script>
    <script src="assets/js/create-account.js"></script>

</body>

</html>