<?php
require_once __DIR__ . '/../general/connect.php';
include_once __DIR__ . '/../general/header.php';

$query = 'CALL getphoneinfo(?)';
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['masp']]);
$rs = $stmt->fetch();
?>



<?php include_once __DIR__ . '/../general/nav.php' ?>
<?php if(isset($_SESSION['msg'])) : ?>
<?php endif; unset($_SESSION['msg']); ?>
<h1 class="text-center py-2 border boder-2 border-primary rounded">Thông tin sản phẩm</h1>
<div class="row border rounded p-3">
    <div class="col-sm-4 text-center mt-2">
        <img class="img-fluid" src="images/<?= $rs['anh']; ?>" alt="" style="width: 300px; max-height: 300px">
        <form action="add-cart.php" method="post" class="mt-5">
            <input type="hidden" name="masp" id="masp" value="<?= $rs['masp']; ?>">
            <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
            <?php if(isset($_SESSION['user'])) : ?>
            <a href="#" class="btn btn-danger">Mua Ngay</a>
        <?php endif; ?>
        </form>
    </div>
    <div class="col-sm-8">
        <h3>Cấu hình điện thoại</h3>
        <table class="table table-striped">
            <tr>
                <td>Tên điện thoại: </td>
                <td><?=$rs['tensp']?></td>
            </tr>
            <tr>
                <td>Giá bán: </td>
                <td><?=$htmlspecialchars(number_format($rs['gia'],0,",","."));?> đ</td>
            </tr>
            <tr>
                <td>Hãng sản xuất: </td>
                <td><?=$rs['tenth']?></td>
            </tr>
            <tr>
                <td>Hệ điều hành: </td>
                <td><?=$rs['hedieuhanh']?></td>
            </tr>
            <tr>
                <td>Camera: </td>
                <td><?=$rs['camera']?></td>
            </tr>
            <tr>
                <td>Chip: </td>
                <td><?=$rs['CPU']?></td>
            </tr>
            <tr>
                <td>RAM: </td>
                <td><?=$rs['noidungRAM']?></td>
            </tr>
            <tr>
                <td>Dung lượng lưu trữ: </td>
                <td><?=$rs['noidungROM']?></td>
            </tr>
            <tr>
                <td>Pin: </td>
                <td><?=$rs['dungluongpin']?></td>
            </tr>
        </table> 
    </div>
</div>
<div class="p-3 border mt-2 mx-5">
<p class="text-center pb-1 fs-3 border-bottom">Thông số chi tiết</p>        
<table style="width: 50%;" class="table table-striped border rounded m-auto">
    <tr>
        <th colspan="2">Camera:</th>
    </tr>
    <tr>
        <td>Độ phân giải: </td>
        <td class="text-end"><?=$rs['camera']?></td>
    </tr>
    <tr>
        <th colspan="2">Hệ điều hành & CPU</th>
    </tr>
    <tr>
        <td>Hệ điều hành: </td>
        <td class="text-end"><?=$rs['hedieuhanh']?></td>
    </tr>
    <tr>
        <td>CPU: </td>
        <td class="text-end"><?=$rs['CPU']?></td>
    </tr>
    <tr>
        <th colspan="2">Bộ nhớ và lưu trữ</th>
    </tr>
    <tr>
        <td>Ram: </td>
        <td class="text-end"><?=$rs['noidungRAM']?></td>
    </tr>
    <tr>
        <td>Lưu trữ: </td>
        <td class="text-end"><?=$rs['noidungROM']?></td>
    </tr>
    <tr>
        <th colspan="2">Kết nối</th>
    </tr>
    <tr>
        <td>Cổng kết nối/sạc: </td>
        <td class="text-end"><?=$rs['congketnoi']?></td>
    </tr>
    <tr>
        <td>Jack tai nghe: </td>
        <td class="text-end"><?=$rs['jacktainghe']?></td>
    </tr>
    <tr>
        <th colspan="2">Pin & Sạc</th>
    </tr>
    <tr>
        <td>Dung lượng pin:</td>
        <td class="text-end"><?=$rs['dungluongpin']?> mAh</td>
    </tr>
    <tr>
        <td>Loại pin:</td>
        <td class="text-end"><?=$rs['loaipin']?></td>
    </tr>
    <tr>
        <th colspan="2">Thông tin khác</th>
    </tr>
    <tr>
        <td>Thiết kế:</td>
        <td class="text-end"><?=$rs['thietke']?></td>
    </tr>
    <tr>
        <td>Kích thước, khối lượng</td>
        <td class="text-end"><?=$rs['kichthuoc']?></td>
    </tr>
    <tr>
        <td>Thời điểm ra mắt: </td>
        <td class="text-end"><?=$rs['ngayramat']?></td>
    </tr>
    </table>
</div>
<?php include_once __DIR__ . '/../general/footer.php';?>