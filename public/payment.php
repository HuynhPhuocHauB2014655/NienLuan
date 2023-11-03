<?php
define('TITLE', 'Thanh toán'); 
require_once __DIR__ . '/../general/connect.php';
include_once __DIR__ . '/../general/header.php';
$query_user = 'SELECT * from khachhang where username=?';
$stmt_user = $pdo->prepare($query_user);
$stmt_user->execute([$_SESSION['user']]);
$user = $stmt_user->fetch();
if($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $sql = 'SELECT * from dienthoai where masp=?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['masp']]);
    $dienthoai = $stmt->fetch();
}
else{
    $sql = 'SELECT * from giohang g join dienthoai d on g.masp=d.masp where magh=?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user']]);
    $dienthoai = $stmt->fetchAll();
}

$sql_thenoidia = 'SELECT * from thenoidia where username=?';
$stmt_thenoidia = $pdo->prepare($sql_thenoidia);
$stmt_thenoidia->execute([$_SESSION['user']]);
$thenoidia = $stmt_thenoidia->fetchAll();
$sql_thequocte= 'SELECT * from thequocte where username=?';
$stmt_thequocte = $pdo->prepare($sql_thequocte);
$stmt_thequocte -> execute([$_SESSION['user']]);
$thequocte = $stmt_thequocte-> fetchAll();
$tongtien = 0;
?>
<?php include_once __DIR__ . '/../general/nav.php'; ?>

<div class="container">
    <h1 class="text-center text-info border border-2 border-info rounded py-2">Thanh Toán</h1>
    <h3>Thông tin khách hàng</h3>
    <a class="btn btn-sm btn-outline-primary my-3" href="edit-user.php">Chỉnh sửa thông tin cá nhân</a> 
    <div class="ms-2">
        <p><b>Tên khách hàng:</b> <?=$user['hoten']?></p>
        <p><b>Địa chỉ:</b> <?=$user['diachi']?></p>
        <p><b>Số điện thoại:</b> <?=$user['sodienthoai']?></p>
    </div>
    <?php if(isset($_GET['masp'])) : ?>
        <h3>Thông tin đơn hàng</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Hình ảnh</th>
                    <th scope="col">Tên SP</th>
                    <th scope="col">Giá tiền</th>
                    </tr>
            </thead>
            <tbody>
                <tr>
                    <td><img class="img-fluid" width="50px" height="auto" src="<?='images/' . $dienthoai['anh']?>" alt="">
                    <td><?=$dienthoai['tensp'] ?></td>
                    <td><?=number_format($dienthoai['gia'])?>đ</td>
                    <?php $tongtien+=$dienthoai['gia'];?>
                </tr>
                <tr>
                    <td colspan="2"><b>Tổng giá trị đơn hàng:</b></td>
                    <td><b><?=number_format($tongtien)?> đ</b></td>
                </tr>
            </tbody>
        </table>
    <?php else : ?>
        <h3>Danh Sách Các Sản Phẩm Trong Giỏ Hàng</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Hình ảnh</th>
                    <th scope="col">Tên sản phẩm</th>
                    <th scope="col">Giá tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dienthoai as $item) : ?>
                    <tr>
                        <td><img class="img-fluid" width="50px" height="auto" src="<?='images/' . $item['anh']?>" alt=""></td>
                        <td><?= $item['tensp'] ?></td>
                        <td><?= number_format($item['gia']) ?> đ</td>
                        <?php $tongtien+=$item['gia'];?>
                    </tr>
                <?php endforeach; ?>
                <tr>
                        <td colspan="2"><b>Tổng giá trị đơn hàng:</b></td>
                        <td><b><?=number_format($tongtien)?> đ</b></td>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>
    <h3>Hình thức thanh toán</h3>
    <select id="PaymentType" class="form-control mb-3">
        <option selected>Chọn hình thức thanh toán</option>
        <option value="1">Thanh toán khi nhận hàng</option>
        <option value="2">Thanh toán bằng thẻ ngân hàng</option>
    </select>
    <div id="payment_type_2">
    <select class="form-control mb-3">
    </select>
    </div>
    <form method="post">
        <button type="submit" class="btn btn-success mt-2">Xác Nhận Thanh Toán</button>
    </form>
</div>
<?php include_once __DIR__ . '/../general/footer.php' ?>
<script>
    $(document).ready(function() {
        $('#PaymentType').on('change', function() {
            var payment = this.value;
            if (payment == 2)
            {

            }
        });
        });
</script>