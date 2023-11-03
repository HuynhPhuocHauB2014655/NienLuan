<?php
define('TITLE', 'Đơn hàng'); 
require_once __DIR__ . '/../general/connect.php';
include_once __DIR__ . '/../general/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $madh = date('dmyhms') . $_SESSION['user'];
    $sql_order = 'INSERT INTO donhang value (?,?,?,?,?,?,?)';
    $stmt_order = $pdo->prepare($sql_order);
    $stmt_order->execute([$madh,0,date('Y-m-d'),0,"","",$_SESSION['user']]);
    $list_order = 'INSERT into danhsachsanpham value (?,?)';
    $stmt_list_order = $pdo->prepare($list_order);
    if(isset($_POST['masp']))
    {
        $stmt_list_order->execute([$madh,$_POST['masp']]);
        $sql_item = 'SELECT gia from dienthoai where masp=?';
        $stmt_item = $pdo->prepare($sql_item);
        $stmt_item->execute([$_POST['masp']]);
        $item_price = $stmt_item->fetch();
        $sql = 'UPDATE donhang set tongtien=? where madh=?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$item_price['gia'],$madh]);
    }
    else
    {
        $tong = 0;
        $sql_cart = 'SELECT * from giohang where magh=?';
        $stmt_cart = $pdo->prepare($sql_cart);
        $stmt_cart->execute([$_SESSION['user']]);
        $cart = $stmt_cart->fetchAll();
        $sql_item = 'SELECT gia from dienthoai where masp=?';
        $stmt_item = $pdo->prepare($sql_item);
        foreach ($cart as $item) {
            $stmt_list_order->execute([$madh,$item['masp']]);
            $stmt_item->execute([$item['masp']]);
            $item_price = $stmt_item->fetch();
            $tong += $item_price['gia'];
        }
        $sql = 'UPDATE donhang set tongtien=? where madh=?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$tong,$madh]);
    }
}

