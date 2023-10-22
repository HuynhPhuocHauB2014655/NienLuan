<?php
require_once __DIR__ . '/../general/connect.php';
include_once __DIR__ . '/../general/header.php';
$query = 'SELECT * from dienthoai where tensp like "%"?"%"';
$msg = 'Kết quả tìm kiếm';
try {
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_POST['search']]);
    $rs = $stmt->fetchAll();
} catch (PDOException $e){
    echo '<h4 class="text-center">Lỗi truy vấn dữ liệu</h4>';
}
?>

<?php include_once __DIR__ . '/../general/nav.php' ?>
        <h3 class="text-center py-3 border text-info"><?= $msg ?></h3>
        <?php if (!empty($rs)) : ?>
        <?php $n = ceil(count($rs)/4); 
            $stmt = $pdo->prepare($query);
            $stmt->execute([$_POST['search']]);
            for ($j=0;$j<$n;$j++): ?>
            <div class="row">
                <?php for ($k=0;$k<4;$k++) : ?>
                    <?php $col = $stmt->fetch(); ?>
                    <?php if($col) : ?>
                    <div class="item col-sm border m-1">
                            <input type="hidden" name="MaSach" value="<?= $htmlspecialchars($col["masp"]); ?>">
                            <img class="py-2 item-img img-fluid" style="max-height: 300px;" src="images/<?=$htmlspecialchars($col["anh"]);?>" alt="">
                            <p class="fs-7 item-title"><?= $htmlspecialchars($col['tensp']); ?><p>
                            <p class=""><?= $htmlspecialchars($col['tonkho']); ?> đ</p>
                            <p class="item-prices text-danger"><?= $htmlspecialchars(number_format($col['gia'],0,",",".")); ?> đ</p>
                            <?php if(isset($_SESSION['user']) && $_SESSION['user'] == "admin") : ?>
                                <div class="row mb-2">
                                    <div class="col-sm">
                                        <a href="edit.php?masp=<?=$col['masp'];?>" class="btn btn-primary">Sửa</a>
                                    </div>
                                    <form class="form-inline col-sm" action="delete.php" method="POST">
                                            <input type="hidden" name="id" value="<?= $col['masp'] ?>">
                                            <button type="submit" class="btn btn-xs btn-danger" name="delete">
                                            Xóa
                                            </button>
                                    </form>
                                </div>   
                            <?php endif; ?>
                    </div>
                <?php else : ?>
                    <div class="item-empty col-sm m-1"></div>
                <?php endif; ?>
                <?php endfor; ?>   
            </div>
            <?php endfor; ?>
            <?php else:  ?>
                <h5 class="text-center p-5">Không có kết quả nào phù hợp</h5>
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
                window.location.href = `phone-info.php?masp=${id}`;
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