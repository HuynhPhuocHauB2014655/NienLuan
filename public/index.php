<?php
require_once __DIR__ . '/../general/db_connect.php';
include_once __DIR__ . '/../general/header.php';
if(isset($_GET['TT']))
{
    $msg = 'Các sách tiểu thuyết';
    $query = 'SELECT MaSach,TenSach,Anh,Gia from Sach s join LoaiSach l on l.MaLoai=s.Maloai where s.MaLoai="TT"';
}
elseif (isset($_GET['MG']))
{
    $msg = 'Các sách Manga';
    $query = 'SELECT MaSach,TenSach,Anh,Gia from Sach s join LoaiSach l on l.MaLoai=s.Maloai where s.MaLoai="MG"';
}
elseif (isset($_GET['KT']))
{
    $msg = 'Các sách kinh tế';
    $query = 'SELECT MaSach,TenSach,Anh,Gia from Sach s join LoaiSach l on l.MaLoai=s.Maloai where s.MaLoai="KT"';
}
elseif (isset($_GET['NN']))
{
    $msg = 'Các sách dạy ngoại ngữ';
    $query = 'SELECT MaSach,TenSach,Anh,Gia from Sach s join LoaiSach l on l.MaLoai=s.Maloai where s.MaLoai="NN"';
}
else
{
    $msg = 'Các sản phẩm nổi bậc';
    $query = 'SELECT MaSach,TenSach,Anh,Gia from Sach order by rand() LIMIT 8';
}
try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $rs = $stmt->fetchAll();
} catch (PDOException $e){
    echo '<h4 class="text-center">Lỗi truy vấn dữ liệu</h4>';
}
?>
<body>
<?php include_once __DIR__ . '/../general/nav.php' ?>
        <h3 class="text-center py-3 border text-info"><?= $msg ?></h3>   
        <div class="">
            <?php $n = ceil(count($rs)/4); 
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            for ($j=0;$j<$n;$j++): ?>
            <div class="row">
                <?php for ($k=0;$k<4;$k++) : ?>
                    <?php $col = $stmt->fetch(); ?>
                    <div class="col-sm border m-1">
                    <?php if($col) : ?>
                            <input type="hidden" name="MaSach" value="<?= $htmlspecialchars($col["MaSach"]); ?>">
                            <img class="py-2 item-img img-fluid" style="max-height: 300px;" src="./images/<?= $htmlspecialchars($col["Anh"]); ?>" alt="">
                            <p class="fs-7 item-title"><?= $htmlspecialchars($col['TenSach']); ?><p>
                            <p class="item-prices text-danger"><?= $htmlspecialchars(number_format($col['Gia'],0,",",".")); ?> đ</p>
                            <?php if(isset($_SESSION['user']) && $_SESSION['user'] == "admin") : ?>
                                <div class="row mb-2">
                                    <div class="col-sm">
                                        <a href="edit.php?MaSach=<?=$col['MaSach'];?>" class="btn btn-primary">Sửa</a>
                                    </div>
                                    <form class="form-inline col-sm" action="delete.php" method="POST">
                                            <input type="hidden" name="id" value="<?= $col['MaSach'] ?>">
                                            <button type="submit" class="btn btn-xs btn-danger" name="delete">
                                            Xóa
                                            </button>
                                    </form>
                                </div>   
                            <?php endif; ?>
                        
                    <?php endif; ?>
                    </div>
                <?php endfor; ?>   
            </div>
            <?php endfor; ?>
        </div>
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