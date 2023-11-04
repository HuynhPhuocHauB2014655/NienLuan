<?php
define('TITLE', 'Doanh thu'); 
require_once __DIR__ . '/../general/connect.php';
include_once __DIR__ . '/../general/header.php';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(isset($_POST['day']))
    {
        $sql = 'SELECT * from donhang where ngaylapdh=? and trangthaidh=4';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['day']]);
    }
    elseif (isset($_POST['month']))
    {
        $sql = 'SELECT * from donhang where MONTH(ngaylapdh)=? and YEAR(ngaylapdh)=? and trangthaidh=4';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['month'], $_POST['myear']]);
    }    
    elseif (isset($_POST['year'])){
        $sql = 'SELECT * from donhang where YEAR(ngaylapdh)=? and trangthaidh=4';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['year']]);
    }
    $order = $stmt->fetchAll();
}
elseif (isset($_GET['type']) && $_GET['type'] == 'all')
{
    $sql = 'SELECT * from donhang d join trangthai t on d.trangthaidh=t.matt where trangthaidh=4';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $order = $stmt->fetchAll();
}
elseif (isset($_GET['type']) && $_GET['type'] == 'phone'){
    $sql = 'SELECT d.masp,d.tensp,d.gia, count(*) as soluong from dienthoai d join danhsachsanpham ds on d.masp=ds.masp join donhang dh on dh.madh=ds.madh
    where dh.trangthaidh=4 group by masp;';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $phone = $stmt->fetchAll();
}
elseif (isset($_GET['type']) && $_GET['type'] == 'th'){
    $sql = 'SELECT th.math,th.tenth,sum(gia) as doanhthu,count(*) as soluong from dienthoai d join danhsachsanpham ds on d.masp=ds.masp join donhang dh on dh.madh=ds.madh join thuonghieu th on th.math=d.math
    where dh.trangthaidh=4
    group by th.math';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $thuonghieu = $stmt->fetchAll();
}
$tongdanhthu = 0;
?>



<h3 class="text-center text-info border border-2 border-info rounded py-2 mt-3">Thống kê doanh thu</h3>
<div class="d-flex">
        <a class="btn btn-sm btn-outline-success me-2" href="revenue.php?type=all">Tất cả</a>
        <a class="btn btn-sm btn-outline-success me-2 type" href="revenue.php?type=day">Theo ngày</a>
        <a class="btn btn-sm btn-outline-success me-2 type" href="revenue.php?type=month">Theo Tháng</a>
        <a class="btn btn-sm btn-outline-success me-2 type" href="revenue.php?type=year">Theo Năm</a>
        <a class="btn btn-sm btn-outline-success me-2 type" href="revenue.php?type=phone">Theo Sản phẩm</a>
        <a class="btn btn-sm btn-outline-success" href="revenue.php?type=th">Theo Hãng sản xuất</a>
</div>
<form method="post" class="my-3 ms-2" style="width: 20%;">
    <?php if(isset($_GET['type']) && $_GET['type'] == 'day') : ?>
        <label class="form-label" >Chọn ngày: </label>
        <input class="form-control" type="date" name="day" value="<?=date('Y-m-d');?>">
        <button type="submit" class="btn btn-sm btn-outline-primary mt-2">Xem</button>
    <?php elseif (isset($_GET['type']) &&  $_GET['type'] == 'month') : ?>
        <label class="form-label">Chọn tháng: </label>
        <select class="form-select" name="month" id="">
            <option selected disabled>Chọn tháng</option>
            <option value="01">Tháng 1</option>
            <option value="02">Tháng 2</option>
            <option value="03">Tháng 3</option>
            <option value="04">Tháng 4</option>
            <option value="05">Tháng 5</option>
            <option value="06">Tháng 6</option>
            <option value="07">Tháng 7</option>
            <option value="08">Tháng 8</option>
            <option value="09">Tháng 9</option>
            <option value="10">Tháng 10</option>
            <option value="11">Tháng 11</option>
            <option value="12">Tháng 12</option>
        </select>
        <label class="form-label mt-2">Năm: </label>
        <input class="form-control" type="number" min="1900" max="2099" name="myear" step="1" value="<?=date('Y')?>" placeholder="Ví dụ: 2023">
        <button type="submit" class="btn btn-sm btn-outline-primary mt-2">Xem</button>
    <?php elseif (isset($_GET['type']) &&  $_GET['type'] == 'year') : ?>
        <label class="form-label">Nhập năm: </label>
        <input class="form-control" type="number" min="1900" max="2099" step="1" name="year" value="<?=date('Y')?>" placeholder="Ví dụ: 2023">
        <button type="submit" class="btn btn-sm btn-outline-primary mt-2">Xem</button>
    <?php endif; ?>
</form>
<div>
<table class="table">
    <?php if(isset($order)) : ?>
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Ngày tạo</th>
                <th class="text-end">Tổng tiền</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($order as $order): ?>
            <tr>
                <td><?=$order['madh'] ?></td>
                <td><?=$order['ngaylapdh'] ?></td>
                <td class="text-end"><?=number_format($order['tongtien']) ?> đ</td>
                <?php $tongdanhthu+=$order['tongtien'] ?>
                <td><a  class="btn btn-sm btn-outline-primary" href="admin-order-info.php?madh=<?=$order['madh']?>">Xem chi tiết</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"><b>TỔNG DOANH THU: </b></td>
                    <td class="text-end"><b><?=number_format($tongdanhthu) ?> đ</b></td>
                </tr>
        </tfoot>
    <?php elseif (isset($phone)) : ?>
        <thead>
            <tr>
                <th>Mã sản phẩm</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng đã bán</th>
                <th class="text-end">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($phone as $p): ?>
                <tr>
                    <td><?=$p['masp'] ?></td>
                    <td><?=$p['tensp'] ?></td>
                    <td><?=number_format($p['gia']) ?> đ</td>
                    <td><?=$p['soluong'] ?></td>
                    <td class="text-end"><?=number_format($p['soluong']*$p['gia']) ?> đ</td>
                    <?php $tongdanhthu+= ($p['soluong']*$p['gia']); ?>   
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4"><b>TỔNG DOANH THU: </b></td>
                    <td class="text-end"><b><?=number_format($tongdanhthu) ?> đ</b></td>
                </tr>
        </tfoot>
    <?php elseif (isset($thuonghieu)) : ?>
        <thead>
            <tr>
                <th>Mã thương hiệu</th>
                <th>Tên thương hiệu</th>
                <th>Số lượng bán được</th>
                <th class="text-end">Tổng tiền</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($thuonghieu as $t): ?>
            <tr>
                <td><?=$t['math'] ?></td>
                <td><?=$t['tenth'] ?></td>
                <td><?=$t['soluong'] ?></td>
                <td class="text-end"><?=number_format($t['doanhthu'])?> đ</td>
                <?php $tongdanhthu+= ($t['doanhthu']); ?>  
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"><b>TỔNG DOANH THU: </b></td>
                    <td class="text-end"><b><?=number_format($tongdanhthu) ?> đ</b></td>
                </tr>
        </tfoot>
    <?php endif; ?>
</table>
</div>
<?php include_once __DIR__ . '/../general/footer.php' ?>
