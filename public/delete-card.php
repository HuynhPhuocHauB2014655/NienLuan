<?php
define('TITLE', 'Xóa thẻ thanh toán');
include_once __DIR__ . '/../general/header.php';
require_once __DIR__ . '/../general/connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if($_POST['type'] == 'thenoidia')
    {
        $sql = 'DELETE from thenoidia where sothe=? and username=?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['sothe'], $_SESSION['user']]);
    }
    else{
        $sql = 'DELETE from thequocte where sothe=? and username=?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['sothe'], $_SESSION['user']]);
    }
    $_SESSION['msg'] = 'Xoá thẻ thành công!';
    header('location: user.php');
    exit();
}