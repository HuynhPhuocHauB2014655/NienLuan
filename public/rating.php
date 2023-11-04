<?php
define('TITLE', 'Đơn hàng'); 
require_once __DIR__ . '/../general/connect.php';
include_once __DIR__ . '/../general/header.php';

$query = 'SELECT * from danhgia where madh=? and masp=?';
$stmt = $pdo->prepare($query);
$stmt->execute([$_POST['madh'],$_POST['masp']]);
$row = $stmt->fetch();
if(!$row)
{
    $sql = 'INSERT into danhgia value (?,?,?,?)';
    $sql_stmt = $pdo->prepare($sql);
    $sql_stmt->execute([$_POST['madh'],$_POST['masp'],$_POST['rating'],$_POST['comment']]);
    $_SESSION['msg'] = 'Đánh giá của bạn đã được lưu lại!';
    header('location:' . $_SERVER['HTTP_REFERER']);
    exit();
}
else 
{
    $sql = "UPDATE danhgia SET danhgia=?, binhluan=? WHERE madh=? AND masp=?";
    $sql_stmt = $pdo->prepare($sql);
    $sql_stmt->execute([$_POST['rating'], $_POST['comment'], $_POST['madh'],$_POST['masp']]);
    $_SESSION['msg'] = 'Đánh giá của bạn đã cập nhật thành công!';
    header('Location: '.$_SERVER['HTTP_REFERER']);
    exit();
} 

