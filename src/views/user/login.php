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
    <link rel="stylesheet" href="assets/css/login.css">
    <title>Đăng nhập | iForum</title>
</head>

<body>
    <main>
        <div class="container">
            <div class="top column-8">
                <img class="icon120" src="assets/images/logo.svg" alt="Logo">
                <h2>Trở lại với iForum</h2>
            </div>
            <form class="login-origin column-8" method="POST">
                <input class="email-input" type="email" placeholder="Địa chỉ email của bạn" required>
                <input class="password-input" type="password" placeholder="Mật khẩu" required>
                <button type="submit" class="btn-submit action title-medium">Đăng nhập</button>
            </form>
            <div class="divider">
                <hr>
                <p class="title-small">Hoặc</p>
                <hr>
            </div>
            <div class="login-options row-8">
                <button class="action btn-google body-small" title="Google"><img class="icon24" src="assets/images/google.svg" alt="Google"></button>
                <button class="action btn-facebook body-small" title="Facebook"><img class="icon24" src="assets/images/facebook.svg" alt="Facebook"></button>
                <button class="action btn-github body-small" title="Github"><img class="icon24" src="assets/images/github.svg" alt="Github"></button>
            </div>
            <div class="bottom">
                <p class="body-small">Chưa có tài khoản? <a class="action title-small" href="user/create">Đăng ký ngay</a></p>
                <p class="body-small">Trước đó tôi muốn <a class="action title-small" href="/">khám phá</a></p>
            </div>
        </div>
    </main>
    <script src="assets/js/js.js"></script>
    <script src="assets/js/login.js"></script>
</body>

</html>