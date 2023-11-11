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
    $sql_danhgia = 'SELECT * from danhgia where masp=?';
    $stmt_danhgia = $pdo->prepare($sql_danhgia);
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
                            <?php
                                $trungbinh=0;
                                $stmt_danhgia->execute([$col["masp"]]);
                                $danhgia=$stmt_danhgia->fetchAll();
                                if($danhgia) {
                                    foreach ($danhgia as $s) {
                                        $trungbinh+=$s["danhgia"];
                                    }
                                    $trungbinh = $trungbinh / count($danhgia);
                                }
                                else 
                                {
                                    $trungbinh = 5;
                                }
                            ?>
                            <div class="d-flex justify-content-center">
                            <input type="hidden" name="masp" value="<?= $htmlspecialchars($col["masp"]); ?>">
                            <img class="py-2 item-img img-fluid text-center" style="max-height: 300px;" src="images/<?=$col['anh']?>" alt="">
                            </div>
                            <p class="fs-5 item-title"><?= $htmlspecialchars($col['tensp']); ?><p>
                            <p class="item-prices text-danger fs-4"><?= $htmlspecialchars(number_format($col['gia'],0,",",".")); ?> đ</p>
                            <p>Đánh giá: <?=$trungbinh?>/5</p>
                            <?php if(isset($_SESSION['user']) && $_SESSION['user'] == "admin") : ?>
                                <div class="row mb-2">
                                    <div class="col-sm">
                                        <a href="edit.php?masp=<?=$col['masp'];?>" class="btn btn-primary">Sửa</a>
                                    </div>
                                    <form class="form-inline col-sm" action="delete.php" method="POST">
                                            <input type="hidden" name="masp" value="<?= $col['masp'] ?>">
                                            <button type="button" class="btn btn-xs btn-danger" data-bs-toggle="modal" data-bs-target="#delete-confirm" name="delete">
                                                Xóa
                                            </button>
                                    </form>
                                </div>   
                            <?php endif; ?>
                            <?php if($col['tonkho'] == 0 ) : ?>
                                <p>Đã hết hàng</p>
                            <?php else : ?>
                                <p>Còn lại: <?=$col['tonkho']; ?></p>
                            <?php endif; ?>
                            <p class="fst-italic">Bấm vào hình để xem chi tiết</p>
                        </div>
                    <?php else : ?>
                        <div class="item-empty col-sm m-1"></div>
                    <?php endif; ?>
                <?php endfor; ?>   
            </div>
            <?php endfor; ?>
        </div>
            <?php else:  ?>
                <h5 class="text-center p-5">Không có kết quả nào phù hợp</h5>
            <?php endif; ?>
        <div class="modal fade" id="delete-confirm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">Bạn có muốn xóa sản phẩm này không?</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                    <button type="button" class="btn btn-primary" id="delete">Xóa</button>
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
                console.log($(this));
                const form = $(this).closest('form');
                const name = $(this).closest('.grid-item').find('p:first');
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