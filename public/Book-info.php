<?php
require_once __DIR__ . '/../general/connect.php';
include_once __DIR__ . '/../general/header.php';
define('TITLE', 'Chi tiết sản phẩm');
$query = 'CALL TTBook(?)';
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['MaSach']]);
$info = $stmt->fetch();
?>
<?php include_once __DIR__ . '/../general/nav.php' ?>
    <div class="row mt-5 border p-2">
        <div class="col-sm-5 text-center">
            <img class="img-fluid mb-2" style="max-height: 400px;" src="images/<?= htmlspecialchars($info['anh']); ?>" alt="">
            <form action="#" method="post">
                <button id="add-card" type="submit">Thêm vào giỏ hàng</button>
                <input style="width: 50px;" type="number" min="1" max="5" value="1">
            </form>
        </div>
        <div class="col-sm">
            <h2><?= htmlspecialchars($info['tensach']); ?></h2>
            <p>Nhà xuất bản: <b><?= htmlspecialchars($info['tennxb']); ?></b></p>
            <p>Tác giả: <b><?= htmlspecialchars($info['tacgia']); ?></b></p>
            <p>Hình thức bìa: <b><?= htmlspecialchars($info['hinhthuc']); ?></b></p>
            <h3 class="text-danger my-3">Giá: <b><?= htmlspecialchars($info['gia']); ?></b>đ</h3>
            <h4>Thông tin chi tiết</h4>
            <div class="row border pt-2">
                <div class="col-sm">
                    <p>Tên: <?= htmlspecialchars($info['tensach']); ?></p>
                    <p>Tác giả: <?= htmlspecialchars($info['tacgia']); ?></p>
                    <p>Số trang: <?= htmlspecialchars($info['sotrang']); ?></p>
                </div>
                <div class="col-sm">
                    <p>Nhà xuất bản: <?= htmlspecialchars($info['tennxb']); ?></p>
                    <p>Loại sách: <?= htmlspecialchars($info['tenloai']); ?></p>
                    <p>Hình thức bìa: <?= htmlspecialchars($info['hinhthuc']); ?></p>
                </div>
            </div>
        </div>
        
    </div>

<?php include_once __DIR__ . '/../general/footer.php';?>