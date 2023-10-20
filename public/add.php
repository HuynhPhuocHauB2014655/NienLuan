<?php
require_once __DIR__ . '/../general/db_connect.php';
include_once __DIR__ . '/../general/header.php';
define('TITLE', 'Thêm sản phẩm');

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $query = 'INSERT INTO Sach value (?,?,?,?,?,?,?,?,?)';
    $stmt = $pdo->prepare($query);
    $stmt->execute(["",$_POST['TenSach'],$_POST['Anh'],$_POST['SoTrang'],$_POST['Gia'],$_POST['TacGia'],$_POST['HinhThuc'],$_POST['MaNXB'],$_POST['MaLoai']]);
    $_SESSION['msg'] = 'Thêm sản phẩm thành công!';
    header('Location: index.php');
}
?>
<?php include_once __DIR__ . '/../general/nav.php' ?>
<body class="container">
    <h3 class="text-center border border-3 border-primary py-3 m-3">Cập nhật thông tin sản phẩm</h3>
    <div class="d-flex justify-content-center">
        <form method="post" class="row border border-3 p-3 my-5">
            <div class="col-sm">
            <label for="tenSach" class="form-label">Tên Sách</label><br>
            <input type="text" class="form-control" name="TenSach"><br/>
            <label class="form-label" for="anh">Tên Ảnh</label><br />
            <input class="form-control" type="text" name="Anh"><br>
            <label class="form-label" for="soTrang">Số Trang</label><br/>
            <input class="form-control" type="number" name="SoTrang" min="1"/><br />
            <label class="form-label" for="gia">Giá (VND)</label><br/>
            <input class="form-control" type="number" name="Gia" min="0"/><br />
            </div>
            <div class="col-sm">
            <label class="form-label" for="tacGia">Tác Giả</label><br />
            <input class="form-control" type="text" name="TacGia"/><br />
            <label class="form-label" for="HinhThuc">Hình Thức</label><br />
            <select class="form-select" name="HinhThuc">
                <option value="Bìa mềm">Bìa mềm</option>
                <option value="Bìa cứng">Bìa cứng</option>
                <option value="Bộ hộp">Bộ hộp</option>
            </select><br />
            <label class="form-label" for="MaNXB"">Mã Nhà Xuất Bản</label><br />
            <input class="form-control" type="text" name="MaNXB"/><br />
            <label class="form-label" for="MaLoai">Mã Loại Sách</label><br />
            <input class="form-control" type="text" name="MaLoai"/><br />
            </div>
            <button class="btn btn-primary" type="submit">Thêm sản phẩm</button>
        </form>
    </div>
</body>
<?php include_once __DIR__ . '/../general/footer.php';