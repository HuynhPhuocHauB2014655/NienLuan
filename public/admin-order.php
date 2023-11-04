<?php
define('TITLE', 'Quản lí đơn hàng'); 
require_once __DIR__ . '/../general/connect.php';
include_once __DIR__ . '/../general/header.php';
if($_SESSION['user'] != 'admin')
{
    $_SESSION['msg'] = 'Bạn không có quyền truy cập trang này';
    header("Location: index.php");
    exit();
}
if(isset($_GET['choxacnhan']))
{
    $sql = 'SELECT * from donhang d join trangthai t on d.trangthaidh=t.matt where trangthaidh=0';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $orders = $stmt->fetchAll();
}
elseif (isset($_GET['daxacnhan']))
{
    $sql = 'SELECT * from donhang d join trangthai t on d.trangthaidh=t.matt where trangthaidh=1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $orders = $stmt->fetchAll();
}
elseif (isset($_GET['danggiao']))
{
    $sql = 'SELECT * from donhang d join trangthai t on d.trangthaidh=t.matt where trangthaidh=2';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $orders = $stmt->fetchAll();
}
elseif (isset($_GET['dagiao']))
{
    $sql = 'SELECT * from donhang d join trangthai t on d.trangthaidh=t.matt where trangthaidh=4';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $orders = $stmt->fetchAll();
}
else
{
    $sql = 'SELECT * from donhang d join trangthai t on d.trangthaidh=t.matt';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $orders = $stmt->fetchAll();
}
?>
<?php include_once __DIR__ . '/../general/nav.php'; ?>
<div class="container">
    <h3 class="text-center p-2 text-info border rounded border-primary my-3">Tất cả đơn hàng</h3>
    <div class="d-flex">
        <a class="btn btn-sm btn-outline-dark me-2" href="admin-order.php">Tất cả</a>
        <a class="btn btn-sm btn-outline-dark me-2" href="admin-order.php?choxacnhan=true">Chờ xác nhận</a>
        <a class="btn btn-sm btn-outline-dark me-2" href="admin-order.php?daxacnhan=true">Đã xác nhận</a>
        <a class="btn btn-sm btn-outline-dark me-2" href="admin-order.php?danggiao=true">Đang giao</a>
        <a class="btn btn-sm btn-outline-dark" href="admin-order.php?dagiao=true">Đã giao</a>
    </div>
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
                <td><a  class="btn btn-sm btn-outline-primary" href="admin-order-info.php?madh=<?=$order['madh']?>">Xem chi tiết</a></td>
            </tr>
        </tbody>
        <?php endforeach; ?>
    </table>
</div>
<?php include_once __DIR__ . '/../general/footer.php';