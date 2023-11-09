<?php
define('TITLE', 'Thông báo');
include_once __DIR__ . '/../general/header.php';
require_once __DIR__ . '/../general/connect.php';

if(isset($_SESSION['user'])) {

    $user = $_SESSION['user'];
    if(isset($_POST['idthongbao']) ) {
       
            $query = 'select * from thongbao where idthongbao=? order by trangthaitb';
            $stmt = $pdo->prepare($query);
            $stmt->execute([$_POST['idthongbao']]);
            $result = $stmt->fetch();

            if(!$result['trangthaitb'] && $user != 'admin') { #neu result = 0 thi chua xem = 1 thi da xem
                $query1 = 'update thongbao set trangthaitb=? where idthongbao=?';
                $stmt1 = $pdo->prepare($query1);
                $stmt1->execute([1, $_POST['idthongbao']]);
            } 
    } 
    if ($_SESSION['user'] == 'admin'){
        $query = 'select * from thongbao ';
        $stmt = $pdo->prepare($query);
        $stmt->execute();    
    }
    else if (isset($_GET['tbdaxem'])) {
        $query = 'select * from thongbao where username=? and trangthaitb=?';
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_SESSION['user'], 1]);
    } else if (isset($_GET['tbchuaxem'])) {
        $query = 'select * from thongbao where username=? and trangthaitb=?';
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_SESSION['user'], 0]);
    }  else{
        $query = 'select * from thongbao where username=?';
        $stmt = $pdo->prepare($query);
        $stmt->execute([$user]);  
    }
        $result = $stmt->fetchAll();
        $n = count($result);
}
include_once __DIR__ . '/../general/nav.php';
?>

<div class="container">
    <h3 class="text-center h2">Thông báo</h3>
    <hr>
    <div class="d-flex my-2 justify-content-between">
        <div>
            <a class="btn btn-sm btn-outline-danger me-2" href="notice.php?tbchuaxem=1">Thông báo chưa xem</a>
            <a class="btn btn-sm btn-outline-success me-2" href="notice.php?tbdaxem=1">Thông báo đã xem</a>
        </div>
        <?php if($_SESSION['user'] == 'admin'): ?>
            <form action="add-notice.php" method="post" class="me-1">
                <button type="submit" class="btn btn-sm btn-outline-success">Thêm thông báo</button>
            </form>
        <?php endif; ?>
    </div>

    <?php if($n == 0): ?>
        <h3 class="text-center my-5">Bạn không có thông báo nào chưa xem!</h3>
    <?php elseif($n > 0) : ?>    
        <div class="px-3 mt-3" >
            <?php  foreach ($result as $rs) : ?>
                <?php if($rs['trangthaitb'] == 0 && $_SESSION['user'] != 'admin') : ?>
                    <div class="border-bottom notice px-2 py-1 my-2 chuaxem">
                <?php else : ?>
                    <div class="border-bottom notice px-2 py-1 my-2">
                <?php endif; ?>
                    <div class="d-flex justify-content-between">
                        <div class="text-decoration-none text-black">                         
                            <h5><?= $rs['tieudetb']; ?></h5>
                        </div>
                        <form method="post" class="seen">
                            <input type="hidden" name="trangthaitb" value="<?=$rs['trangthaitb'];?>">
                            <input type="hidden" name="idthongbao" value="<?=$rs['idthongbao']?>">
                        </form>
                        <form method="post" action="delete-notice.php">
                            <input type="hidden" name="delete" value="<?= $rs['idthongbao'] ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                        </form>
                    </div>
                    <p class="noidung" style="display:none;">
                        <br><?= $rs['noidung']; ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
        
    <?php  endif; ?>

</div>

<?php include_once __DIR__ . '/../general/footer.php'; ?>
<script>
    $(document).ready(function(){
    $('.notice').click(function() {
        $(this).removeClass('chuaxem');
        var content = $(this).find('.noidung');
        if (content.css('display') === 'block'){
            content.hide();
            <?php if($_SESSION['user'] != 'admin') : ?>
                var seen = $(this).find('.seen');
                var trangthai = seen.find('input[name="trangthaitb"]').val();
                if(trangthai == 0)
                {
                    seen.trigger('submit');
                }
            <?php endif; ?>
        }else{
            content.show();
        }
    });
});

</script>

