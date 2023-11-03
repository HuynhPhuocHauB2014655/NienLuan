<?php
define('TITLE', 'Thêm thẻ thanh toán');
include_once __DIR__ . '/../general/header.php';
require_once __DIR__ . '/../general/connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if ($_POST['type'] == 'thenoidia')
    {
        $query_thenoidia = 'SELECT * from thenoidia where username=?';
        $stmt_checkThenoiDia = $pdo->prepare($query_thenoidia);
        $stmt_checkThenoiDia->execute([$_SESSION['user']]);
        $thenoidia = $stmt_checkThenoiDia->fetchAll();
        $isexits_card = false;
        foreach ($thenoidia as $row)
        {
            if($_POST['sothe'] == $row['sothe'])
            {
                $isexits_card = true;
            }
        }
        if($isexits_card)
        {
            echo '<script>alert("Bạn đã có thẻ này rồi!");</script>'; 
        }
        else
        {
            $sql_thenoidia = 'SELECT * from nganhangnoidia';
            $stmt_thenoidia = $pdo->prepare($sql_thenoidia);
            $stmt_thenoidia->execute();
            $nh_thenoidia = $stmt_thenoidia->fetchAll();
            $check_card = false;
            foreach ($nh_thenoidia as $r)
            {
                if($_POST['sothe'] == $r['sothe'] && $_POST['nganhang'] == $r['nganhang'] && $_POST['tenchuthe'] == $r['tenchuthe'] && $_POST['ngayphathanh'] == $r['ngayphathanh'])
                {
                    $check_card = true;
                }
            }
            if (!$check_card){
                echo '<script>alert("Thông tin thẻ bạn nhập không trùng khớp với thông tin lưu trong ngân hàng");</script>';
            }else
            {
                $query = 'INSERT INTO thenoidia value (?,?,?,?,?)';
                $stmt = $pdo->prepare($query);
                $stmt->execute([$_POST['sothe'],$_POST['nganhang'],$_POST['tenchuthe'],$_POST['ngayphathanh'],$_SESSION['user']]);
                $_SESSION['msg'] = 'Thêm thẻ thành công!';
                header('Location:' . $_SERVER['HTTP_REFERER']);
                exit();
            }
        }
    }
    else{
        $query_thequocte = 'SELECT * from thequocte where username=?';
        $stmt_checkThequocte = $pdo->prepare($query_thequocte);
        $stmt_checkThequocte->execute([$_SESSION['user']]);
        $thequocte = $stmt_checkThequocte->fetchAll();
        $isexits_card = false;
        foreach ($thequocte as $row)
        {
            if($_POST['sothe'] == $row['sothe'])
            {
                $isexits_card = true;
            }
        }
        if($isexits_card)
        {
            echo '<script>alert("Bạn đã có thẻ này rồi!");</script>'; 
        }
        else
        {
            $sql_thequocte = 'SELECT * from nganhangquocte';
            $stmt_thequocte = $pdo->prepare($sql_thequocte);
            $stmt_thequocte->execute();
            $nh_thequocte = $stmt_thequocte->fetchAll();
            $check_card = false;
            foreach ($nh_thequocte as $r)
            {
                if($_POST['sothe'] == $r['sothe'] && $_POST['cvc_cvv'] == $r['cvc_cvv'] && $_POST['tenchuthe'] == $r['tenchuthe'] && $_POST['diachi'] == $r['diachi']&& $_POST['thanhpho'] == $r['thanhpho'])
                {
                    $check_card = true;
                }
            }
            if (!$check_card){
                echo '<script>alert("Thông tin thẻ bạn nhập không trùng khớp với thông tin lưu trong ngân hàng");</script>';
            }else{
                $query = 'INSERT INTO thequocte value (?,?,?,?,?,?)';
                $stmt = $pdo->prepare($query);
                $stmt->execute([$_POST['sothe'],$_POST['cvc_cvv'],$_POST['tenchuthe'],$_POST['diachi'],$_POST['thanhpho'],$_SESSION['user']]);
                $_SESSION['msg'] = 'Thêm thẻ thành công!';
                header('Location: user.php');
                exit();
            }
        }
    }
}

?>
<?php include_once __DIR__ . '/../general/nav.php' ?>
<div>
    <label for="">Chọn loại thẻ:</label>
    <select name="" id="cardType" class="form-control mb-3">
        <option selected>Chọn loại thẻ</option>
        <option value="thenoidia">Thẻ nội địa</option>
        <option value="thequocte">Thẻ quốc tế</option>
    </select>
</div>
<div id="form-thenoidia" style="display: none;">
    <form method="post" style="min-width: 300px;">
        <input type="hidden" name="type" value="thenoidia">
        <div class="mb-3">
            <label class="form-lable">Nhập số thẻ:</label>
            <input type="text" class="form-control" name="sothe" placeholder="Nhập số thẻ">
        </div>
        <div class="mb-3">
            <label class="form-lable" for="">Tên ngân hàng: </label>
            <input type="text" class="form-control" name="nganhang" placeholder="Tên ngân hàng">
        </div>
        <div class="mb-3">
            <label class="form-lable" for="">Tên chủ thẻ: </label>
            <input type="text" class="form-control" name="tenchuthe" placeholder="Tên chủ thẻ">
        </div>
        <div class="mb-3">
            <label class="form-lable" for="">Ngày phát hành: </label>
            <input type="text" class="form-control" name="ngayphathanh" placeholder="Ngày phát hành">
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
</div>
<div id="form-thequocte" style="display: none;">
<form method="post" style="min-width: 300px;">
        <input type="hidden" name="type" value="thequocte">
        <div class="mb-3">
            <label class="form-lable">Nhập số thẻ:</label>
            <input type="text" class="form-control" name="sothe" placeholder="Nhập số thẻ">
        </div>
        <div class="mb-3">
            <label class="form-lable" >CVC/CVV: </label>
            <input type="text" class="form-control" name="cvc_cvv" placeholder="CVC/CVV">
        </div>
        <div class="mb-3">
            <label class="form-lable">Tên chủ thẻ: </label>
            <input type="text" class="form-control" name="tenchuthe" placeholder="Tên chủ thẻ">
        </div>
        <div class="mb-3">
            <label class="form-lable">Địa chỉ: </label>
            <input type="text" class="form-control" name="diachi" placeholder="Địa chỉ">
        </div>
        <div class="mb-3">
            <label class="form-lable">Thành phố: </label>
            <input type="text" class="form-control" name="thanhpho" placeholder="Thành phố">
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
</div>        
<?php include_once __DIR__ . '/../general/footer.php'; ?>

<script>
    $(document).ready(function() {
        $('#cardType').change(function(){
            var card = $(this).val();
            if (card == "thenoidia"){
                $('#form-thenoidia').show();
                $('#form-thequocte').hide();
            }else if(card == "thequocte"){
                $('#form-thequocte').show();
                $('#form-thenoidia').hide();
            }
            else
            {
                $('#form-thenoidia').hide();
                $('#form-thequocte').hide();
            };
        });
    });
</script>