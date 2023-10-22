<?php
require_once __DIR__ . '/../general/connect.php';
include_once __DIR__ . '/../general/header.php';
define('TITLE', 'Thêm sản phẩm');

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $query = 'INSERT INTO dienthoai value (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_POST['masp'],$_POST['tensp'],$_POST['ngayramat'],$_POST['math'],$_POST['magia'],
    $_POST['maRAM'],$_POST['maROM'],$_POST['CPU'],$_POST['hedieuhanh'],$_POST['camera'],$_POST['gia'],$_POST['tonkho'],
    $_POST['congketnoi'],$_POST['jacktainghe'],$_POST['loaipin'],$_POST['dungluongpin'],$_POST['thietke'],$_POST['kichthuoc'],$_POST['anh']]);
    $_SESSION['msg'] = 'Thêm sản phẩm thành công!';
    header('Location: index.php');
}
?>
<?php include_once __DIR__ . '/../general/nav.php' ?>
<div class="container">
    <h3 class="text-center border border-3 border-primary py-3 m-3 rounded">Thêm sản phẩm</h3>
    <div class="d-flex justify-content-center">
        <form method="post" class="row border border-3 p-3 my-5 rounded">
            <div class="col-sm">
            <label for="masp" class="form-label">Mã điện thoại: </label><br>
            <input type="text" class="form-control" name="masp" ><br/>
            <label for="tensp" class="form-label">Tên điện thoại: </label><br>
            <input type="text" class="form-control" name="tensp" ><br/>
            <label class="form-label" for="anh">Tên Ảnh: </label><br />
            <input class="form-control" type="text" name="anh" "><br>
            <label for="ngayramat" class="form-label">Ngày ra mắt: </label><br>
            <input type="text" class="form-control" name="ngayramat"><br/>
            <label for="magia" class="form-label">Phân khúc giá:</label><br>
            <input type="text" class="form-control" name="magia"><br/>
            <label for="magth" class="form-label">Mã thương hiệu:</label><br>
            <input type="text" class="form-control" name="math"><br/>
            <label for="maRAM" class="form-label">mã RAM: </label><br>
            <input type="text" class="form-control" name="maRAM"><br/>
            <label for="maROM" class="form-label">Mã ROM: </label><br>
            <input type="text" class="form-control" name="maROM"><br/>
            <label for="CPU" class="form-label">Chíp: </label><br>
            <input type="text" class="form-control" name="CPU"><br/>
            </div>
            <div class="col-sm">
            <label for="hedieuhanh" class="form-label">Hệ điều hành: </label><br>
            <input type="text" class="form-control" name="hedieuhanh"><br/>
            <label for="camera" class="form-label">Camera: </label><br>
            <input type="text" class="form-control" name="camera"><br/>
            <label class="form-label" for="gia">Giá (VND)</label><br/>
            <input class="form-control" type="number" name="gia" min="0"/><br />
            <label for="congketnoi" class="form-label">Cổng kết nối: </label><br>
            <input type="text" class="form-control" name="congketnoi"><br/>
            <label for="jactaine" class="form-label">Jack tai nghe: </label><br>
            <input type="text" class="form-control" name="jacktainghe"><br/>
            <label for="loaipin" class="form-label">Loại pin: </label><br>
            <input type="text" class="form-control" name="loaipin"><br/>
            <label for="dungluongpin" class="form-label">Dung lượng pin: </label><br>
            <input type="text" class="form-control" name="dungluongpin"><br/>
            <label for="thietke" class="form-label">Thiết kế: </label><br>
            <input type="text" class="form-control" name="thietke"><br/>
            <label for="tonkho" class="form-label">Tồn kho: </label><br>
            <input type="text" class="form-control" name="tonkho"><br/>
            </div>
            <label for="kichthuoc" class="form-label">Kích Thước: </label><br>
            <input type="text" class="form-control" name="kichthuoc"><br/>
            <button class="btn btn-primary mt-2" type="submit">Thêm sản phẩm</button>
        </form>
    </div>
<?php include_once __DIR__ . '/../general/footer.php';