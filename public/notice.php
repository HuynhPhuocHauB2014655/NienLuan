<?php
define('TITLE', 'Thông báo');
include_once __DIR__ . '/../general/header.php';
require_once __DIR__ . '/../general/connect.php';

if(isset($_SESSION['user'])) {

    $user = $_SESSION['user'];
    if(isset($_GET['idthongbao']) ) {
       
            $query = 'select * from thongbao where idthongbao=?';
            $stmt = $pdo->prepare($query);
            $stmt->execute([$_GET['idthongbao']]);
            $result = $stmt->fetch();

            if(!$result['trangthaitb']) { #neu result = 0 thi chua xem = 1 thi da xem
                $query1 = 'update thongbao set trangthaitb=? where idthongbao=?';
                $stmt1 = $pdo->prepare($query1);
                $stmt1->execute([1, $_GET['idthongbao']]);
            } 
           
            if ($result['ttxem']) {
                $query1 = 'update thongbao set ttxem=? where idthongbao=?';
                $stmt1 = $pdo->prepare($query1);
                $stmt1->execute([0, $_GET['idthongbao']]);
            } else {
                $query1 = 'update thongbao set ttxem=? where idthongbao=?';
                $stmt1 = $pdo->prepare($query1);
                $stmt1->execute([1, $_GET['idthongbao']]);
            }


         
    } else if (isset($_POST['delete'])) {
        
            $query = 'delete from thongbao where idthongbao=?';
            $stmt = $pdo->prepare($query);
            $stmt->execute([$_POST['delete']]);

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
    <div class="d-flex my-2">
        <a class="btn btn-sm btn-outline-danger me-2" href="notice.php?tbchuaxem=1">Thông báo chưa xem</a>
        <a class="btn btn-sm btn-outline-success me-2" href="notice.php?tbdaxem=1">Thông báo đã xem</a>
    </div>

    <?php if($n == 0): ?>
        <h1 class="text-center my-5">Bạn không có thông báo nào chưa xem!</h1>
    <?php elseif($n > 0) : ?>    
        <div class="border p-3" >
            <?php  foreach ($result as $rs) : ?>
                
                    <div class="row">
                        
                        <div class="col-sm border py-1">
                            <a class="text-decoration-none text-secondary" href="notice.php?idthongbao=<?= $rs['idthongbao'] ?>">
                            <h3><?= $rs['tieudetb']; ?></h3>
                            <div class="<?= $rs['ttxem'] == 0 ?  'd-none' : 'd-block';?>">
                                <hr>
                                <?= $rs['noidung']; ?>
                            </div>
                            </a>
                        </div>
                        
                        <?php if($_SESSION['user'] == 'admin'): ?>
                            <!-- <div class="col-sm-2 border" >
                                <h4><?= $rs['username'] ?> </h4>
                            </div> -->
                            <form action="add-notice.php" method="post" class="col-sm-1 mt-3">
                                <div class="col-sm">
                                    <button type="submit" class="btn btn-success">Thêm</button>
                                </div>
                            </form>
                        <?php endif; ?>
                        <form method="post" class="col-sm-1 mt-3">
                            <div class="col-sm">
                                <input type="hidden" name="delete" value="<?= $rs['idthongbao'] ?>">
                                <button type="submit" class="btn btn-danger">Xóa</button>
                            </div>
                        </form>
                    </div>
                
            <?php endforeach; ?>
        </div>
        
    <?php  endif; ?>

</div>

<?php include_once __DIR__ . '/../general/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

