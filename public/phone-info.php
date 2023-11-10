<?php
define('TITLE', 'Thông tin sản phẩm'); 
require_once __DIR__ . '/../general/connect.php';
include_once __DIR__ . '/../general/header.php';

$query = 'CALL getphoneinfo(?)';
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['masp']]);
$rs = $stmt->fetch();
$stmt=null;
$query = 'SELECT * from danhgia where masp=? order by danhgia desc';
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['masp']]);
$danhgia = $stmt->fetchAll();
?>



<?php include_once __DIR__ . '/../general/nav.php' ?>
<h1 class="text-center py-2 border boder-2 border-primary rounded">Thông tin sản phẩm</h1>
<div class="row border rounded p-3">
    <div class="col-sm-4 text-center mt-2">
        <img class="img-fluid" src="images/<?= $rs['anh']; ?>" alt="" style="width: 300px; max-height: 300px">
        <form action="add-cart.php" method="post" class="mt-5">
            <input type="hidden" name="masp" id="masp" value="<?= $rs['masp']; ?>">
            <?php if ($rs['tonkho'] == 0) : ?>
                <p class="text-danger">Sản phẩm đã hết hàng</p>
            <?php else : ?>
            <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
            <?php if(isset($_SESSION['user'])) : ?>
                <a href="payment.php?masp=<?= $rs['masp']; ?>" class="btn btn-danger">Mua Ngay</a>
            <?php endif; ?>
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
                <td><?=$rs['cpu']?></td>
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
<p class="text-center pb-1 fs-3 border-bottom">Thông số chi tiết</p>   
<table style="width:70%;" class="table border rounded mx-auto">
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
        <td class="text-end"><?=$rs['cpu']?></td>
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
<div class="my-2">
    <span class="fs-3 me-2"><b>Đánh giá</b></span><span id="avg"></span>
    <div class="d-flex mt-2">
        <button class="btn btn-sm btn-outline-primary me-2" id="all">Tất cả</button>
        <?php for($i=1;$i<=5;$i++): ?>
            <div class="me-2">
                <input type="hidden" name="star" value="<?=$i?>">
                <button class="btn btn-sm btn-outline-primary filter-form"><?=$i .'<i class="fa-solid fa-star"></i>'?></button>
            </div>
        <?php endfor; ?>
    </div>
</div>
<div class="my-2">
    <?php if($danhgia) : ?>
        <?php foreach($danhgia as $d) : ?>
            <div class="danhgia border px-2 mt-2">
                <input type="hidden" name="rating" value="<?= $d['danhgia'] ?>">
                <div class="star-wrapper my-3">
                </div>
                <p><?=$d['binhluan']?></p>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Chưa có đánh giá</p>
    <?php endif; ?>
</div>
<?php include_once __DIR__ . '/../general/footer.php';?>
<script>
    $(document).ready(function(){
        danhgia = $('.danhgia');
        $('#all').click(function(){
            danhgia.show();
        });
        $('.filter-form').click(function(){
            var star = $(this).siblings().val();
            danhgia.each(function (){
                if($(this).children('[name="rating"]').val() == star){
                    $(this).show();
                   }
                   else
                   {
                    $(this).hide();
                   }
            })
        })
        let trungbinh=0.0;
        avg=$('#avg');
        danhgia.each(function(){
            let rating = $(this).find('input').val();
            trungbinh+=Number(rating);
            star = $(this).find('.star-wrapper')
            for(i=0;i<rating;i++){
                star.append('<span class="fa-star fa-solid text-primary"></span>');
            }
        })
        trungbinh /= <?=count($danhgia)?>;
        avg.append("(" + <?=count($danhgia)?> + " đánh giá. "+ trungbinh.toFixed(1) + " sao)");
    });
</script>