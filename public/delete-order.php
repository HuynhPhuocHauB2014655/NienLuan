<?php
require_once __DIR__ . '/../general/connect.php';
include_once __DIR__ . '/../general/header.php';
$sql = 'SELECT masp from danhsachsanpham where madh=?';
$sql_stmt = $pdo->prepare($sql);
$sql_stmt->execute([$_POST['madh']]);
$item = $sql_stmt->fetchAll();
foreach ($item as $i) {
    $sql_item = 'UPDATE dienthoai set tonkho=tonkho+1 where masp=?';
    $sql_stmt_item = $pdo->prepare($sql_item);
    $sql_stmt_item->execute([$i['masp']]);
}
$query = 'DELETE from danhsachsanpham where madh=?';
$query1 = 'DELETE from donhang where madh=?';
$stmt = $pdo->prepare($query);
$stmt->execute([$_POST['madh']]);
$stmt1 = $pdo->prepare($query1);
$stmt1->execute([$_POST['madh']]);
$_SESSION['msg'] = 'Đã hủy đơn hàng';
header('location: order.php');
exit();