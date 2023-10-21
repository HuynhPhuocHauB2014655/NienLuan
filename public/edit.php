<?php
require_once __DIR__ . '/../general/db_connect.php';
include_once __DIR__ . '/../general/header.php';
define('TITLE', 'Xóa sản phẩm');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['MaSach'])) {
        header('Location: index.php');
    }
    $select = 'SELECT * FROM Sach WHERE MaSach = ?';
    $stmt = $pdo->prepare($select);
    $stmt->execute([$_GET['MaSach']]);
    $book = $stmt->fetch();

    if (!$book) {
        header('Location: index.php');
    }
}
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $query = 'UPDATE Sach SET TenSach=?,Anh=?,SoTrang=?,Gia=?,TacGia=?,HinhThuc=?,MaNXB=?,MaLoai=? where MaSach=?';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_POST['TenSach'],$_POST['Anh'],$_POST['SoTrang'],$_POST['Gia'],$_POST['TacGia'],$_POST['HinhThuc'],$_POST['MaNXB'],$_POST['MaLoai'],$_POST['MaSach']]);
    $_SESSION['msg'] = 'Cập nhật thông tin sản phẩm thành công!';
    header('Location: index.php');
}

?>
<?php include_once __DIR__ . '/../general/nav.php' ?>
<div class="container">
    <h3 class="text-center border border-3 border-primary py-3 m-3">Cập nhật thông tin sản phẩm</h3>
    <div class="d-flex justify-content-center">
        <form method="post" class="row border border-3 p-3 my-5">
            <div class="col-sm">
            <input type="hidden" name="MaSach" value="<?= $htmlspecialchars($book['MaSach']); ?>">
            <label for="tenSach" class="form-label">Tên Sách</label><br>
            <input type="text" class="form-control" name="TenSach" value="<?= $htmlspecialchars($book['TenSach']); ?>" ><br/>
            <label class="form-label" for="anh">Tên Ảnh</label><br />
            <input class="form-control" type="text" name="Anh" value="<?= $htmlspecialchars($book['Anh']); ?> "><br>
            <label class="form-label" for="soTrang">Số Trang</label><br/>
            <input class="form-control" type="number" name="SoTrang" min="1" value="<?=$htmlspecialchars($book['SoTrang']); ?>"/><br />
            <label class="form-label" for="gia">Giá (VND)</label><br/>
            <input class="form-control" type="number" name="Gia" min="0" value="<?=$htmlspecialchars($book['Gia']); ?>"/><br />
            </div>
            <div class="col-sm">
            <label class="form-label" for="tacGia">Tác Giả</label><br />
            <input class="form-control" type="text" name="TacGia" value="<?=$htmlspecialchars($book['TacGia']); ?>"/><br />
            <label class="form-label" for="HinhThuc">Hình Thức</label><br />
            <select class="form-select" name="HinhThuc">
                <option value="Bìa mềm">Bìa mềm</option>
                <option value="Bìa cứng">Bìa cứng</option>
                <option value="Bộ hộp">Bộ hộp</option>
            </select><br />
            <label class="form-label" for="MaNXB"">Mã Nhà Xuất Bản</label><br />
            <input class="form-control" type="text" name="MaNXB" value="<?=$htmlspecialchars($book['MaNXB']); ?>"/><br />
            <label class="form-label" for="MaLoai">Mã Loại Sách</label><br />
            <input class="form-control" type="text" name="MaLoai" value="<?=$htmlspecialchars($book['MaLoai']); ?>"/><br />
            </div>
            <button class="btn btn-primary" type="submit">Thêm sản phẩm</button>
        </form>
    </div>
<?php include_once __DIR__ . '/../general/footer.php';