<?php
define('TITLE', 'Đơn hàng'); 
require_once __DIR__ . '/../general/connect.php';
include_once __DIR__ . '/../general/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $madh = date('dmyhms') . $_SESSION['user'];
    $sql_order = 'INSERT INTO donhang value (?,?,?,?,?,?,?,?)';
    $stmt_order = $pdo->prepare($sql_order);
    $stmt_order->execute([$madh,0,date('Y-m-d'),0,"","",$_POST['paymentType'],$_SESSION['user']]);
    $list_order = 'INSERT into danhsachsanpham value (?,?)';
    $stmt_list_order = $pdo->prepare($list_order);
    if(isset($_POST['masp']))
    {
        $stmt_list_order->execute([$madh,$_POST['masp']]);
        $sql_item = 'SELECT * from dienthoai where masp=?';
        $stmt_item = $pdo->prepare($sql_item);
        $stmt_item->execute([$_POST['masp']]);
        $item = $stmt_item->fetch();
        $sql_tongtien = 'UPDATE donhang set tongtien=? where madh=?';
        $stmt_tongtien = $pdo->prepare($sql_tongtien);
        $stmt_tongtien->execute([$item['gia'],$madh]);
        $sql = 'UPDATE dienthoai set tonkho=tonkho-1 where masp=?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['masp']]);
    }
    else
    {
        $tong = 0;
        $sql = 'UPDATE dienthoai set tonkho=tonkho-1 where masp=?';
        $stmt = $pdo->prepare($sql);
        $sql_cart = 'SELECT * from giohang where magh=?';
        $stmt_cart = $pdo->prepare($sql_cart);
        $stmt_cart->execute([$_SESSION['user']]);
        $cart = $stmt_cart->fetchAll();
        $sql_item = 'SELECT * from dienthoai where masp=?';
        $stmt_item = $pdo->prepare($sql_item);
        foreach ($cart as $item) {
            $stmt_list_order->execute([$madh,$item['masp']]);
            $stmt_item->execute([$item['masp']]);
            $item_price = $stmt_item->fetch();
            $tong += $item_price['gia'];
            $stmt->execute([$item['masp']]);
        }
        $sql = 'UPDATE donhang set tongtien=? where madh=?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$tong,$madh]);
        $query_cart = 'DELETE from giohang where magh=?';
        $stmt_delete = $pdo->prepare($query_cart);
        $stmt_delete->execute([$_SESSION['user']]);
    }
    header('location: index.php');
    exit();
}
$sql = 'SELECT * from donhang d join trangthai t on d.trangthaidh=t.matt where username=?';
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user']]);
$orders = $stmt->fetchAll();
?>
<?php include_once __DIR__ . '/../general/nav.php'; ?>
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Ngày tạo</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th></th>
            </tr>
        </thead>
        <?php foreach ($orders as $order): ?>
        <tbody>
            <tr>
                <td><?=$order['madh'] ?></td>
                <td><?=$order['ngaylapdh'] ?></td>
                <td><?=number_format($order['tongtien']) ?> đ</td>
                <td><?=$order['tentt']?></td>
                <td><a  class="btn btn-sm btn-outline-primary" href="order-info.php?madh=<?=$order['madh']?>">Xem chi tiết</a></td>
            </tr>
        </tbody>
        <?php endforeach; ?>
    </table>
</div>
<?php include_once __DIR__ . '/../general/footer.php';