<?php 
session_start();
define('TITLE', 'Xóa sản phẩm');
include_once __DIR__ . '/../general/header.php';
require_once __DIR__ . '/../general/db_connect.php';
if(!isset($_SESSION['user']) || $_SESSION['user'] != 'admin')
{
    echo '<h3 class="text-center">Bạn không có quyền truy cập trang này</h3>
    <div class="text-center mt-3"><a class="btn btn-primary text-center" href="index.php">Trở về trang chủ</a></div>';
}
else
{
    $query1 = 'SELECT MaSach from sach where MaSach=?';
    $query2 = 'DELETE from Sach where MaSach=?';
    try {
        $stmt = $pdo->prepare($query1);
        $stmt->execute([$_POST['id']]);
        $row = $stmt->fetch();
        if(!empty($row))
        {
            $stmt = $pdo->prepare($query2);
            $stmt->execute([$_POST['id']]);
            $_SESSION['msg'] = 'Sản phẩm đã xóa thành công!';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    } catch(PDOException $e) {
        echo "Lỗi truy vấn dữ liệu";
    }
}
include_once __DIR__ . '/../general/footer.php';