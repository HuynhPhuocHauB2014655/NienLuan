<?php
define('TITLE', 'Thông tin khách hàng');
include_once __DIR__ . '/../general/header.php';
require_once __DIR__ . '/../general/connect.php';

$sql = 'SELECT * from khachhang where username=?';
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user']]);
$user = $stmt->fetch();

$query_thenoidia = 'SELECT * from thenoidia where username=?';
$query_thequocte = 'SELECT * from thequocte where username=?';
$stmt_thenoidia = $pdo->prepare($query_thenoidia);
$stmt_thequocte = $pdo->prepare($query_thequocte);
$stmt_thenoidia->execute([$_SESSION['user']]);
$stmt_thequocte->execute([$_SESSION['user']]);

?>

<?php include_once __DIR__ . '/../general/nav.php' ?>

<div>
    <h1 class="text-center">THÔNG TIN KHÁCH HÀNG</h1>
    <hr/>
    <div class="text-end d-flex justify-content-end mb-2">
        <a class="btn btn-sm btn-outline-primary float-right me-2" href="#">Chỉnh sửa thông tin cá nhân</a> 
        <a class="btn btn-sm btn-outline-primary float-right" href="#">Đổi mật khẩu</a></div>
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th scope="col" colspan="2"><b><u>Thông tin cá nhân</u></b></th>
            </tr>
        </thead>
         <tbody>
            <tr>
                <td>Tên đăng nhập: </td>
                <td><?= $user['username']; ?></td>
            </tr>
            <tr>
                <td>Họ và tên:</td>
                <td><?= $user['hoten']; ?></td>
            </tr>
            <tr>
                <td>Ngày sinh:</td>
                <td><?= date("d/m/Y", strtotime($user['ngaysinh'])) ?></td>
            </tr>
            <tr>
                <td>Số điện thoại:</td>
                <td><?= $user['sodienthoai']; ?></td>
            </tr>
            <tr>
                <td>Địa chỉ:</td>
                <td><?= $user['diachi']; ?></td>
            </tr>
        </tbody>             
    </table>
    <h3>Thông tin thẻ ngân hàng</h3><a class="btn btn-info my-2" href="add-card.php">Thêm thẻ thanh toán</a>
    <h5>Thẻ nội địa: </h5>
    <?php $thenoidia = $stmt_thenoidia->fetchAll(); ?>
    <?php if (empty($thenoidia)): ?>
        <p>Chưa có thông tin.</p>
        <?php else : ?>
            <?php foreach ($thenoidia as $t) :?>
            <div style="width:300px;" class="border pt-3 px-3 mb-2">
                <p>Tên chủ thẻ: <?= $t['tenchuthe']; ?></p>
                <p>Số thẻ: **** **** **** <?= substr($t['sothe'], -4); ?></p>
                <form method="post" action="delete-card.php" class="mb-2">
                    <input type="hidden" name="sothe" value="<?=$t['sothe'];?>"/>
                    <input type="hidden" name="type" value="thenoidia">
                    <button type="submit" class="btn btn-sm btn-outline-secondary float-right">Xóa thẻ</button>
                </form>
            </div>
            <?php endforeach; ?>
    <?php endif; ?>   
    <h5>Thẻ quốc tế: </h5>
    <?php $thequocte = $stmt_thequocte->fetchAll(); ?>
    <?php if (empty($thequocte)) : ?>
        <p>Chưa có thông tin.</p>
        <?php else : ?>
            <?php foreach ($thequocte as $tq) :?>
            <div style="width:300px;" class="border pt-3 px-3 mb-2">
                <p>Tên chủ thẻ: <?= $tq['tenchuthe']; ?></p>
                <p>Số thẻ: **** **** **** <?= substr($tq['sothe'], -4); ?></p>
                <form method="post" action="delete-card.php" class="mb-2">
                    <input type="hidden" name="sothe" value="<?=$tq['sothe'];?>"/>
                    <input type="hidden" name="type" value="thequocte">
                    <button type="submit" class="btn btn-sm btn-outline-secondary float-right">Xóa thẻ</button>
                </form>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>       
</div>
<?php include_once __DIR__ . '/../general/footer.php'; ?>