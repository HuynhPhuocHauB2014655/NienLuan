<?php 

include_once __DIR__ . '/../general/header.php';
require_once __DIR__ . '/../general/connect.php';
define('TITLE', 'Xóa sản phẩm');
if(!isset($_SESSION['user']) || $_SESSION['user'] != 'admin')
{
    echo '<h3 class="text-center">Bạn không có quyền truy cập trang này</h3>
    <div class="text-center mt-3"><a class="btn btn-primary text-center" href="index.php">Trở về trang chủ</a></div>';
}
else
{
    $query1 = 'SELECT masp from dienthoai where masp=?';
    $query2 = 'DELETE from dienthoai where masp=?';
    try {
        $stmt = $pdo->prepare($query1);
        $stmt->execute([$_POST['masp']]);
        $row = $stmt->fetch();
        if(!empty($row))
        {
            $stmt = $pdo->prepare($query2);
            $stmt->execute([$_POST['masp']]);
            $_SESSION['msg'] = 'Sản phẩm đã xóa thành công!';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    } catch(PDOException $e) {
        echo "Lỗi truy vấn dữ liệu";
    }
}
include_once __DIR__ . '/../general/footer.php';