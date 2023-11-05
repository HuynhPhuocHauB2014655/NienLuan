<?php
define('TITLE', 'Thêm thông báo');
include_once __DIR__ . '/../general/header.php';
require_once __DIR__ . '/../general/connect.php';

$query = 'select username from khachhang where username<>?';
$stmt = $pdo->prepare($query);
$stmt->execute(['admin']);
$result = $stmt->fetchAll();



if (isset($_POST['title']) && isset($_POST['content'])){
    if(isset($_POST['alluser'])) {
        $query1 = 'insert into thongbao values (?,?,?,?,?,?)';
        $stmt1 = $pdo->prepare($query1);
        
        foreach($result as $rs  ) {
            $stmt1->execute(['',$rs['username'], 0, 0, $_POST['title'], $_POST['content']]);
        }
        
    }else {
        $query1 = 'insert into thongbao values (?,?,?,?,?,?)';
        $stmt1 = $pdo->prepare($query1);
        $stmt1->execute(['',$_POST['username'], 0, 0, $_POST['title'], $_POST['content']]);
    }

}


include_once __DIR__ . '/../general/nav.php';
?>
<h2 class="text-center">THÊM THÔNG BÁO</h2>
<hr>
<div>
    <form method="post">
        <div class="form-group">
            <label class="form-label" for="title">Tiêu đề: </label><br />
            <input class="form-control" type="text" name="title" id="title"><br />
        </div>
        <div class="form-group">
            <label class="form-label" for="content">Nội dung: </label><br />
            <textarea class="form-control" rows="10" cols="50" name="content"></textarea><br />
        </div>

        <label class="form-label">Người nhận: </label>
            <select class="form-control" name="username" aria-label="Default select example">
                <option selected>Chọn người nhận...</option>
                <?php foreach($result as $rs):  ?>
                    <option class="form-control">
                        <?= $rs['username'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <div class="form-group my-1">
            <label class="form-check-label" for="alluser">Chọn tất cả:</label>
            <input class="form-check-input mt-1" type="checkbox" value="alluser" name="alluser" id="alluser">
        </div>
        <button type="submit" class="btn btn-primary" name="addNoticeBtn">Thêm thông báo</button>
    </form>
</div>

