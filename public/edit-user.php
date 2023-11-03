<?php
define('TITLE', 'Cập nhật thông tin khách hàng'); 
require_once __DIR__ . '/../general/connect.php';
include_once __DIR__ . '/../general/header.php';


if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $query = 'update khachhang
              set hoten=?, ngaysinh=?, sodienthoai=?, diachi=?
              where username=?';
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_POST['hoten'], $_POST['ngaysinh'], $_POST['sodienthoai'], $_POST['diachi'], $_POST['user']]);

    $_SESSION['msg'] = 'Đã cập nhật thông tin khách hàng thành công';
    header('Location: user.php');

}







if(isset($_SESSION['user'])){

    $query = 'select * from khachhang where username=?';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['user']]);
    $row = $stmt->fetch();

}



?>
<?php include_once __DIR__ . '/../general/nav.php' ?>
<div>
    <h1 class="text-center">THÔNG TIN KHÁCH HÀNG</h1>
    <hr/>
    <form method="POST">
        <input type="hidden" name="user" value="<?=$row['username']?>">
        <label class="form-label " for="hoten">Họ và tên: </label>
        <input class="form-control m-2"  type="text" name="hoten" id="hoten" value="<?= $row['hoten'];?>" >
        <label class="form-label" for="ngaysinh">Ngày sinh:</label>
        <input class="form-control m-2" type="date" name="ngaysinh" id="ngaysinh" value="<?= $row['ngaysinh'];?>">
        <label class="form-label" for="ngaysinh">Số điện thoại:</label>
        <input class="form-control m-2" type="text" name="sodienthoai" id="sodienthoai" value="<?= $row['sodienthoai'];?>">
        <label class="form-label" for="ngaysinh">Địa chỉ:</label>
        <input class="form-control m-2" type="text" name="diachi" id="diachi" value="<?= $row['diachi'];?>">
        <button class="btn btn-primary mt-3" type="submit">
            Cập nhật thông tin
        </button>
    </form>
</div>