<?php

define('TITLE', 'Đăng xuất');
include_once __DIR__ . '/../general/header.php';

if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
    header("Location: index.php");
    exit();
}

include_once __DIR__ . '/../partials/footer.php';
