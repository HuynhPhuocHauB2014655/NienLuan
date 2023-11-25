<?php
define('TITLE', 'Quản lí đơn hàng'); 
require_once __DIR__ . '/../general/connect.php';
include_once __DIR__ . '/../general/header.php';
if($_SESSION['user'] != 'admin')
{
    $_SESSION['msg'] = 'Bạn không có quyền truy cập trang này';
    header("Location: ../index.php");
    exit();
}
if($_SERVER['REQUEST_METHOD'] == 'GET')
{   
    try {
        $query_order_info = 'SELECT * from donhang d join danhsachsanpham ds on d.madh=ds.madh 
        join dienthoai dt on dt.masp=ds.masp join trangthai t on t.matt=d.trangthaidh
        where d.madh=?';
        $stmt_order_info = $pdo->prepare($query_order_info);
        $stmt_order_info->execute([$_GET['madh']]);
        $row_order_info = $stmt_order_info->fetchAll();

        $query_user = 'SELECT * from khachhang where username=?';
        $stmt_user = $pdo->prepare($query_user);
        $stmt_user->execute([$row_order_info[0]['username']]);
        $user = $stmt_user->fetch();
    } catch (PDOException $e)
    {
        echo "Lỗi truy vấn dữ liệu ";
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST')
{   
    if($_POST['trangthaidh'] == 1) {
        $tieudetb = "XÁC NHẬN ĐƠN HÀNG";
        $noidungtb =  "Đơn hàng " . $_POST['madh'] . " của bạn đã được xác nhận."; 
        $query_tb = 'insert into thongbao values (?,?,?,?,?,?)';
        $stmt_tb = $pdo->prepare($query_tb);
        $stmt_tb->execute(["", $_POST['username'], 0, 0, $tieudetb, $noidungtb]);
    }
    if($_POST['trangthaidh'] == 2) {
        $tieudetb = "ĐÃ GIAO HÀNG CHO ĐƠN VỊ VẬN CHUYỂN";
        $noidungtb =  "Đơn hàng " . $_POST['madh'] . " của bạn đã được giao cho đơn vị vận chuyển."; 
        $query_tb = 'insert into thongbao values (?,?,?,?,?,?)';
        $stmt_tb = $pdo->prepare($query_tb);
        $stmt_tb->execute(["", $_POST['username'], 0, 0, $tieudetb, $noidungtb]);
    }

    $sql_order = 'UPDATE donhang set trangthaidh=? where madh=?';
    $stmt_order = $pdo->prepare($sql_order);
    $stmt_order->execute([$_POST['trangthaidh'],$_POST['madh']]);
    $_SESSION['msg'] = 'Đơn hàng đã được cập nhật!';
    header('location: admin-order-info.php?madh=' . $_POST['madh']);
    exit();
}
?>

<div class="container">
<?php include_once __DIR__ . '/../general/nav.php' ?>
    <h2 class="text-center p-2 text-info border rounded border-primary my-3">Thông tin chi tiết đơn hàng</h2>
    <table id="order-detail" class="table table-bordered text-center">
    <thead>
        <tr>
            <th>STT</th>
            <th>Hình ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Giá bán</th>
        </tr>
    </thead>
        <tbody>
            <?php $stt=0; foreach ($row_order_info as $orders): ?>
                <tr>
                    <td><?= ++$stt ?></td>
                    <td><img src="images/<?= $orders['anh']; ?>" alt="" width="50"></td>
                    <td><?= $orders['tensp']; ?></td>
                    <td><?= number_format($orders['gia']).' đ'; ?></td>
                </tr>
            <?php endforeach; ?>
                <tr>
                    <td colspan="3"><b>Tổng cộng:</b></td>
                    <td><b><?=number_format($orders['tongtien']).' đ'; ?></b></td>
                </tr>
        </tbody>
    </table>
    <table class="table table-striped" style="width: 50%;">
        <tr>
            <td>Trạng thái đơn hàng:</td>
            <td class="text-primary"><?= $orders['tentt']; ?></td>
        </tr>
        <tr>
            <td>Hình thức thanh toán:</td>
            <td><?= $orders['hinhthuctt'] == 1 ? 'Thanh toán khi nhận hàng' : 'Thanh toán qua thẻ ngân hàng'; ?></td>
        <tr>
            <td>Người nhận : </td>
            <td><?=$user['hoten'] ?></td>
        </tr>
        <tr>
            <td>Số điện thoại : </td>
            <td><?=$user['sodienthoai'] ?></td>
        </tr>
        <tr>
            <td>Địa chỉ giao hàng : </td>
            <td><?=$user['diachi'] ?></td>
        </tr>    
    </table>
    <?php if($orders['trangthaidh'] == 0) : ?>
        <form method='post'>
            <input type="hidden" name="madh" value="<?= $orders['madh'];?>">
            <input type="hidden" name="trangthaidh" value="1">
            <input type="hidden" name="username" value="<?= $orders['username'];?>">
            <button type="button" class="mb-4 btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal-confirm" name="confirm">
                Xác nhận đơn hàng
            </button>
        </form>
        <?php elseif ($orders['trangthaidh'] == 1) : ?>
            <form method='post'>
                <input type="hidden" name="madh" value="<?= $orders['madh'];?>">
                <input type="hidden" name="trangthaidh" value="2">
                <input type="hidden" name="username" value="<?= $orders['username'];?>">
                <button type="button" class="mb-4 btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal-confirm" name="confirm">
                    Xác nhận giao hàng
                </button>
            </form>
        <?php elseif ($orders['trangthaidh'] == 2) : ?>
            <form method='post'>
                <input type="hidden" name="madh" value="<?= $orders['madh'];?>">
                <input type="hidden" name="trangthaidh" value="3">
                <button type="button" class="mb-4 btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal-confirm" name="confirm">
                    Hàng đã đến nơi
                </button>
            </form>
        <?php endif; ?>
        <div class="modal fade" id="modal-confirm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">Bạn có chắc chắn với hành động này không?</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Thoát</button>
                    <button type="button" class="btn btn-outline-danger" id="confirm">Xác nhận</button>
                </div>
                </div>
            </div>
        </div>
</div>

<?php include_once __DIR__ . '/../general/footer.php'; ?>
<script>
        $(document).ready(function(e) {
            $('button[name="confirm"]').on('click', function(e){
                e.preventDefault();
                const form = $(this).closest('form');
                $('#modal-confirm').modal({
                    backdrop: 'static', keyboard: false
                })
                $('button[id="confirm"]').on('click', function() {
                    form.trigger('submit');
                });
            });
        });
    </script>