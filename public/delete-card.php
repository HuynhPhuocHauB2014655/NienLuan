<?php
require_once __DIR__ . '/../general/connect.php';
include_once __DIR__ . '/../general/header.php';

$query = 'SELECT * from giohang where magh=? and masp=?';
$stmt = $pdo->prepare($query);
if(isset($_SESSION['user'])) {
    $stmt->execute([$_SESSION['user'], $_GET['masp']]);
}
else{
    $stmt->execute([$_SESSION['guest'], $_GET['masp']]);
}
$rs = $stmt->fetch();
if($rs)
{
    $query = 'DELETE from giohang where magh=? and masp=?';
    $stmt = $pdo->prepare($query);
    if(isset($_SESSION['user'])) {
        $stmt->execute([$_SESSION['user'], $_GET['masp']]);
    }
    else{
        $stmt->execute([$_SESSION['guest'], $_GET['masp']]);
    }
    $_SESSION['msg'] = "Xóa sản phẩm thành công!";
    header('Location:' . $_SERVER['HTTP_REFERER']);
    exit();
}