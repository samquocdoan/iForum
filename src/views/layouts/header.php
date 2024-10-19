<?php
$isLoggedIn = false;

if (isset($_SESSION['uid'])) {
    $uid = intval($_SESSION['uid']);
    $isLoggedIn = true;
}

?>

<header>
    <div class="container">
        <a href="/"><img class="logo action icon40" src="../../assets/images/logo.svg" alt="Logo"></a>
        <div class="header-action row-8">
            <a href="/posts" class="btn-menu action"><img src="../../assets/images/menu.svg" alt="Menu"></a>
            <a href="/" class="btn-search action"><img src="../../assets/images/search.svg" alt="Search"></a>
            <a href="/" class="btn-notification action"><img src="../../assets/images/bell.svg" alt="Notification"></a>
            <a href="/user/create" class="btn-account action"><img src="../../assets/images/account.svg" alt="account"></a>
        </div>
    </div>
</header>