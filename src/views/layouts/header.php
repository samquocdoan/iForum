<?php
session_start();

$isLoggedIn = false;

if (isset($_SESSION['uid'])) {
    $uid = intval($_SESSION['uid']);
    $isLoggedIn = true;
}

?>

<header>
    <div class="container">
        <a href="/" title="iForum"><img class="logo action icon40" src="../../assets/images/logo.svg" alt="Logo"></a>
        <nav class="header-action row-8">
            <button class="btn-menu action" title="Menu"><img src="../../assets/images/menu.svg" alt="Menu"></button>
            <a href="/" class="btn-search action" title="Tìm kiếm"><img src="../../assets/images/search.svg" alt="Search"></a>
            <a href="/" class="btn-notification action" title="Thông báo"><img src="../../assets/images/bell.svg" alt="Notification"></a>
            <button class="btn-account action" title="Tài khoản"><img src="../../assets/images/account.svg" alt="account"></button>
        </nav>
    </div>
</header>