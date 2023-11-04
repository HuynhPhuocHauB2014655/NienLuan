<?php
define('TITLE', 'Giỏ hàng'); 
require_once __DIR__ . '/../general/connect.php';
include_once __DIR__ . '/../general/header.php';
$tong = 0;
$query = 'SELECT * from giohang g join dienthoai d on g.masp=d.masp where magh=?';
$stmt=$pdo->prepare($query);
$stmt->execute([$_GET['username']]);
$rs = $stmt->fetchAll();
$sold_out = false;
?>

<?php include_once __DIR__ . '/../general/nav.php' ?>
<?php if(!empty($rs)) :?>
    <table style="min-width: 700px;" class="mx-auto">
    <tr><th colspan="4" class="text-center py-3 fs-2">Giỏ hàng của bạn</th></tr>
<?php foreach ($rs as $rs) : ?>
    
    <tr class="border">
        <td scope="row" class="px-5 py-5"><img src="images/<?=$rs['anh']?>" alt="" width="100" height="100"></td>
        <td scope="row" class="px-5 py-5"><?=$rs['tensp']?>
            <?php if($rs['tonkho'] == 0) : ?> <?=$sold_out=true?><br> <span class="fst-italic text-danger">Sản phẩm này đã hết hàng</span></td>
            <?php endif; ?>
        <td scope="row" class="px-5 py-5"><?=$htmlspecialchars(number_format($rs['gia'],0,",","."));?>đ</td>
        <td class="px-5 py-5"><a class="btn btn-danger" href="delete-cart.php?masp=<?=$rs['masp']?>">Xóa</a></td>
        <?php $tong+=$rs['gia']; ?>
    </tr>
<?php endforeach; ?>
    <tr class="border">
        <td class="px-5 py-5">Tổng tiền:</td>
        <td class="px-5 py-5">
            <?=$htmlspecialchars(number_format($tong,0,",","."));?> đ
        </td>
        <?php if($sold_out) : ?>
            <td colspan="2" class="px-5 py-5 text-center">Xóa sản phẩm đã hết hàng trước khi thực hiện thanh toán</td>
        <?php else : ?>
            <td colspan="2" class="px-5 py-5 text-center">
                <?php if (!isset($_SESSION['user'])) : ?>
                    <a class="btn btn-sm btn-outline-primary" href="login.php">Đăng nhập để thực hiện thanh toán</a>
                <?php else : ?>
                    <form action="payment.php" method="post">
                        <button class="btn btn-outline-primary" type="submit">Thanh toán</button>
                    </form>
                <?php endif; ?>
            </td>
        <?php endif; ?>
    </tr>
</table>
<?php else : ?>
    <h1 class="text-center my-5">Không có sản phẩm nào trong giỏ hàng!</h1>
    <p class="text-center"><a href="index.php" class="border mt-5 p-3">Đến mua hàng</a></p>
<?php endif; ?>