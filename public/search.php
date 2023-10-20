<?php
require_once __DIR__ . '/../general/db_connect.php';
include_once __DIR__ . '/../general/header.php';
$query = 'SELECT MaSach,TenSach,Anh,Gia from Sach where TenSach like "%"?"%"';
$msg = 'Kết quả tìm kiếm';
try {
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_POST['search']]);
    $row = $stmt->fetchAll();
} catch (PDOException $e){
    echo '<h4 class="text-center">Lỗi truy vấn dữ liệu</h4>';
}
?>
<body>
<?php include_once __DIR__ . '/../general/nav.php' ?>
        <h3 class="text-center py-3 border text-info"><?= $msg ?></h3>
        <?php if(!empty($row)) : ?>   
        <div class="grid-conteiner">
            <?php foreach ($row as $row) : ?>
                <div class="grid-item border m-1 rounded">
                    <input type="hidden" name="MaSach" value="<?= $htmlspecialchars($row["MaSach"]); ?>">
                    <img class="py-2 item-img" src="./images/<?= $htmlspecialchars($row["Anh"]); ?>" alt="">
                    <p class="fs-7 item-title"><?= $htmlspecialchars($row['TenSach']); ?><p>
                    <p class="item-prices text-danger"><?= $htmlspecialchars($row['Gia']); ?> đ</p>
                    <?php if(isset($_SESSION['user']) && $_SESSION['user'] == "admin") : ?>
                        <div class="row mb-2">
                            <div class="col-sm">
                                <a href="edit.php?MaSach=<?=$row['MaSach'];?>" class="btn btn-primary">Sửa</a>
                            </div>
                            <form class="form-inline col-sm" action="delete.php" method="POST">
                                <input type="hidden" name="id" value="<?= $row['MaSach'] ?>">
                                <button type="submit" class="btn btn-xs btn-danger" name="delete">
                                    Xóa
                                </button>
                            </form>
                        </div>  
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php else : ?>
            <h4 class="text-center py-3">Không tìm thấy sách!</h4>
        <?php endif; ?>
        <div id="delete-confirm" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">Bạn có muốn xóa sản phẩm này không?</div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-danger" id="delete">Xóa</button>
                        <button type="button" data-dismiss="modal" class="btn btn-default">Trở về</button>
                    </div>
                </div>
            </div>
        </div>
<?php include_once __DIR__ . '/../general/footer.php';?>
<script>
        $(document).ready(function(e) {
            $(".item-img").on('click', function (e) {
                e.preventDefault()
                const book = $(this);
                const id = book.parent().children()[0].value;
                window.location.href = `book-info.php?MaSach=${id}`;
            });
            $('button[name="delete"]').on('click', function(e){
                e.preventDefault();
                const form = $(this).closest('form');
                const name = $(this).closest('.grid-item').find('p:first');
                console.log(name);
                console.log(form);
                if (name.length > 0) {
                    $('.modal-body').html(`Bạn có chắc muốn xóa "${name.text()}"?`);
                }
                $('#delete-confirm').modal({
                    backdrop: 'static', keyboard: false
                })
                $('button[id="delete"]').on('click', function() {
                    form.trigger('submit');
                });
            });
        });
    </script>