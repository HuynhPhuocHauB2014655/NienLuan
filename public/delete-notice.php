<?php
define('TITLE', 'Thông báo');
include_once __DIR__ . '/../general/header.php';
require_once __DIR__ . '/../general/connect.php';

if (isset($_POST['delete'])) {
        
    $query = 'delete from thongbao where idthongbao=?';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_POST['delete']]);
    header('location: notice.php');
    exit();
}