<?php
define('TITLE', 'Thêm sản phẩm');
require_once __DIR__ . '/../general/connect.php';
include_once __DIR__ . '/../general/header.php';
require_once __DIR__ . '/../general/helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['masp'])) {
        header('Location: index.php');
        exit();
    }
    $select = 'SELECT * FROM dienthoai WHERE masp = ?';
    $stmt = $pdo->prepare($select);
    $stmt->execute([$_GET['masp']]);
    $rs = $stmt->fetch();

    if (!$rs) {
        header('Location:' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    try {
        $upload_img= handle_phone_img_upload();
        $old_img = $_POST['old-img'];
        $query = 'UPDATE dienthoai SET tensp=?,ngayramat=?,math=?,magia=?,maRAM=?,maROM=?,cpu=?,hedieuhanh=?,camera=?,gia=?,tonkho=?,
                                    congketnoi=?,jacktainghe=?,loaipin=?,dungluongpin=?,thietke=?,kichthuoc=?,anh=? 
                                where masp=?';
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_POST['tensp'],$_POST['ngayramat'],$_POST['math'],$_POST['magia'],
        $_POST['maRAM'],$_POST['maROM'],$_POST['cpu'],$_POST['hedieuhanh'],$_POST['camera'],$_POST['gia'],$_POST['tonkho'],
        $_POST['congketnoi'],$_POST['jacktainghe'],$_POST['loaipin'],$_POST['dungluongpin'],$_POST['thietke'],$_POST['kichthuoc'],$upload_img ? $upload_img : $old_img,$_POST['masp']]);
        $_SESSION['msg'] = 'Cập nhật thông tin sản phẩm thành công!';
        if ($upload_img && $old_img) {
            remove_avater_file($old_img);
        }
        header('Location: index.php');
        exit();
    } catch (PDOException $e)
    {
        echo "Lỗi truy vấn dữ liệu ";
    }
}

?>
<?php include_once __DIR__ . '/../general/nav.php' ?>
<div class="container">
    <h3 class="text-center border border-3 border-primary py-3 m-3 rounded">Cập nhật thông tin sản phẩm</h3>
    <div class="d-flex justify-content-center">
        <form method="post" enctype="multipart/form-data" class="border border-3 p-3 my-5 rounded">
            <div style="width: 49%;" class="col-12">
                <label class="form-label" for="phone_img">Ảnh điện thoại: </label><br>
                <img class="" height="200px" src="<?= 'images/' . $rs['anh']; ?>" alt="phone_img"><br>
                <input type="file" class="form-control mt-2" name="phone_img" id="phone_img">
                <input type="hidden" name="old-img" value="<?= $rs['anh']; ?>">
            </div>
            <div class="row">
            <div class="col-sm">
            <input type="hidden" name="masp" value="<?= $htmlspecialchars($rs['masp']); ?>">
            <label for="tensp" class="form-label">Tên điện thoại: </label><br>
            <input type="text" class="form-control" name="tensp" value="<?= $htmlspecialchars($rs['tensp']); ?>" ><br/>
            <label for="ngayramat" class="form-label">Ngày ra mắt: </label><br>
            <input type="text" class="form-control" name="ngayramat" value="<?= $htmlspecialchars($rs['ngayramat']); ?>" ><br/>
            <label for="magia" class="form-label">Phân khúc giá:</label><br>
            <input type="text" class="form-control" name="magia" value="<?= $htmlspecialchars($rs['magia']); ?>" ><br/>
            <label for="magth" class="form-label">Mã thương hiệu:</label><br>
            <input type="text" class="form-control" name="math" value="<?= $htmlspecialchars($rs['math']); ?>" ><br/>
            <label for="maRAM" class="form-label">mã RAM: </label><br>
            <input type="text" class="form-control" name="maRAM" value="<?= $htmlspecialchars($rs['maRAM']); ?>" ><br/>
            <label for="maROM" class="form-label">Mã ROM: </label><br>
            <input type="text" class="form-control" name="maROM" value="<?= $htmlspecialchars($rs['maROM']); ?>" ><br/>
            <label for="CPU" class="form-label">Chip: </label><br>
            <input type="text" class="form-control" name="cpu" value="<?= $htmlspecialchars($rs['cpu']); ?>" ><br/>
            <label for="hedieuhanh" class="form-label">Hệ điều hành: </label><br>
            <input type="text" class="form-control" name="hedieuhanh" value="<?= $htmlspecialchars($rs['hedieuhanh']); ?>" ><br/>
            </div>
            <div class="col-sm">
            <label for="camera" class="form-label">Camera: </label><br>
            <input type="text" class="form-control" name="camera" value="<?= $htmlspecialchars($rs['camera']); ?>" ><br/>
            <label class="form-label" for="gia">Giá (VND)</label><br/>
            <input class="form-control" type="number" name="gia" min="0" value="<?=$htmlspecialchars($rs['gia']); ?>"/><br />
            <label for="congketnoi" class="form-label">Cổng kết nối: </label><br>
            <input type="text" class="form-control" name="congketnoi" value="<?= $htmlspecialchars($rs['congketnoi']); ?>" ><br/>
            <label for="jactaine" class="form-label">Jack tai nghe: </label><br>
            <input type="text" class="form-control" name="jacktainghe" value="<?= $htmlspecialchars($rs['jacktainghe']); ?>" ><br/>
            <label for="loaipin" class="form-label">Loại pin: </label><br>
            <input type="text" class="form-control" name="loaipin" value="<?= $htmlspecialchars($rs['loaipin']); ?>" ><br/>
            <label for="dungluongpin" class="form-label">Dung lượng pin: </label><br>
            <input type="text" class="form-control" name="dungluongpin" value="<?= $htmlspecialchars($rs['dungluongpin']); ?>" ><br/>
            <label for="thietke" class="form-label">Thiết kế: </label><br>
            <input type="text" class="form-control" name="thietke" value="<?= $htmlspecialchars($rs['thietke']); ?>" ><br/>
            <label for="tonkho" class="form-label">Tồn kho: </label><br>
            <input type="text" class="form-control" name="tonkho" value="<?= $htmlspecialchars($rs['tonkho']); ?>" ><br/>
            </div>
            <label for="kichthuoc" class="form-label">Kích Thước: </label><br>
            <input type="text" class="form-control" name="kichthuoc" value="<?= $htmlspecialchars($rs['kichthuoc']); ?>" ><br/>
            <button class="btn btn-primary mt-2" type="submit">Cập nhật thông tin</button>
            </div>
        </form>
    </div>
<?php include_once __DIR__ . '/../general/footer.php';