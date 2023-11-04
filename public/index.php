<?php
require_once __DIR__ . '/../general/connect.php';
include_once __DIR__ . '/../general/header.php';  
  
    $sqlth = 'SELECT * from thuonghieu';
    $sqlpkgia = 'SELECT * from phankhucgia';
    $sqlram = 'SELECT * from ram';
    $sqlrom = 'SELECT * from rom';
    $sqlnhucau = 'SELECT * from nhucau';
    $sqltinnang = 'SELECT * from tinnangdacbiet';
    $sqlth = $pdo->prepare($sqlth);
    $sqlth->execute();
    $th = $sqlth->fetchAll();
    $sqlpkgia = $pdo->prepare($sqlpkgia);
    $sqlpkgia->execute();
    $pkgia = $sqlpkgia->fetchAll();
    $sqlram = $pdo->prepare($sqlram);
    $sqlram->execute();
    $ram = $sqlram->fetchAll();
    $sqlrom = $pdo->prepare($sqlrom);
    $sqlrom->execute();
    $rom = $sqlrom->fetchAll();
    $sqlnhucau = $pdo->prepare($sqlnhucau);
    $sqlnhucau->execute();
    $nhucau = $sqlnhucau->fetchAll();
    $sqltinnang = $pdo->prepare($sqltinnang);
    $sqltinnang->execute();
    $tinnang = $sqltinnang->fetchAll();

    if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['math'] || $_POST['magia'] || $_POST['idRAM'] || $_POST['idROM'] || $_POST['manc'] || $_POST['matn']))
    {
        $msg = 'Kết quả lọc';
        $kqloc = 'Kết quả lọc cho';
        if($_POST['manc'] && $_POST['matn'])
        {
            $query = 'SELECT * from dienthoai d join locnhucau ln on d.masp=ln.masp 
            join loctinnang lt on lt.masp=d.masp join nhucau n on n.manc=ln.manc join tinnangdacbiet t on t.matn=lt.matn
             where';
        }
        elseif($_POST['manc'])
        {
            $query = 'SELECT * from dienthoai d join locnhucau ln on d.masp=ln.masp 
            join nhucau n on n.manc=ln.manc
            where';
        }
        elseif ($_POST['matn'])
        {
            $query = 'SELECT * from dienthoai d join loctinnang lt on lt.masp=d.masp join tinnangdacbiet t on t.matn=lt.matn
            where';
        }
        else{
            $query = 'SELECT * from dienthoai where';
        }
        if($_POST['math'])
        {
            $query = $query . ' math=' . '"' . $_POST['math'] . '"';
            if ($_POST['magia'] || $_POST['idRAM'] || $_POST['idROM'] || $_POST['manc'] || $_POST['matn'])
            {
                $query = $query . ' and';
            }
        }
        
        if($_POST['magia'])
        {
            $query = $query . ' magia=' . '"' . $_POST['magia'] . '"';
            if ($_POST['idRAM'] || $_POST['idROM'] || $_POST['manc'] || $_POST['matn'])
            {
                $query = $query . ' and';
            }
        }
        
        if($_POST['idRAM'])
        {
            $query = $query . ' maRAM=' . '"' . $_POST['idRAM'] . '"';
            if ($_POST['idROM'] || $_POST['manc'] || $_POST['matn'])
            {
                $query = $query . ' and';
            }
        }
        if($_POST['idROM'])
        {
            $query = $query . ' maROM=' . '"' . $_POST['idROM'] . '"';
            if($_POST['manc'] || $_POST['matn'])
            {
                $query = $query . ' and';
            }
        }
        if($_POST['manc'])
        {
            $query = $query . ' ln.manc=' . '"' . $_POST['manc'] . '"';
            if($_POST['matn'])
            {
                $query = $query . ' and';
            }
        }
        if($_POST['matn'])
        {
            $query = $query . ' lt.matn=' . '"' . $_POST['matn'] . '"';
        }
        $stmt = $pdo->query($query);
        $rs = $stmt->fetchAll();
    }
    else
    {
        $msg = 'Tất cả sản phẩm';
        $query = 'SELECT * from dienthoai';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $rs = $stmt->fetchAll();
    }
?>
<body>
<?php include_once __DIR__ . '/../general/nav.php' ?>
        <h3 class="text-center py-3 border text-info"><?= $msg ?></h3>
        <div class="mx-3">
            <form method="post" class="mb-3">
                <div class="row">
                    <select class="col-sm form-select" name="math" id="math">
                        <option value="" selected>Hãng</option>
                        <?php foreach ($th as $th): ?>
                            <option value="<?=$th['math']?>"><?=$th['tenth']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select class="col-sm form-select" name="magia" id="magia">
                        <option value="" selected>Giá</option>
                        <?php foreach ($pkgia as $pkgia): ?>
                            <option value="<?=$pkgia['magia']?>"><?=$pkgia['noidung']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select class="col-sm form-select" name="idRAM" id="idRAM">
                        <option value="" selected>RAM</option>
                        <?php foreach ($ram as $ram): ?>
                            <option value="<?=$ram['idRAM']?>"><?=$ram['noidungRAM']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select class="col-sm form-select" name="idROM" id="idROM">
                        <option value="" selected>ROM</option>
                        <?php foreach ($rom as $rom): ?>
                            <option value="<?=$rom['idROM']?>"><?=$rom['noidungROM']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select class="col-sm form-select" name="manc" id="manc">
                        <option value="" selected>Nhu cầu</option>
                        <?php foreach ($nhucau as $nhucau): ?>
                            <option value="<?=$nhucau['manc']?>"><?=$nhucau['noidungnc']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select class="col-sm form-control form-select" name="matn" id="matn">
                        <option value="" selected>Tính năng đặc biệt</option>
                        <?php foreach ($tinnang as $tinnang): ?>
                            <option value="<?=$tinnang['matn']?>"><?=$tinnang['noidungtn']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="col-sm">
                    <button type="submit" class="btn btn-primary">Lọc</button>
                    </div>
                </div>  
            </form>
        </div>
        <div>
            <?php $n = ceil(count($rs)/4); 
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $stmt = $pdo->query($query);
            }
            else
            {
                $stmt = $pdo->prepare($query);
                $stmt->execute();
            }
            ?>
            <?php for ($j=0;$j<$n;$j++): ?>
            <div class="row">
                <?php for ($k=0;$k<4;$k++) : ?>
                    <?php $col = $stmt->fetch(); ?>
                    <?php if($col) : ?>
                    <div class="item col-sm border m-1">
                            <input type="hidden" name="masp" value="<?= $htmlspecialchars($col["masp"]); ?>">
                            <img class="py-2 item-img img-fluid" style="max-height: 300px;" src="images/<?=$col['anh']?>" alt="">
                            <p class="fs-7 item-title"><?= $htmlspecialchars($col['tensp']); ?><p>
                            <p class="item-prices text-danger fs-4"><?= $htmlspecialchars(number_format($col['gia'],0,",",".")); ?> đ</p>
                            <?php if(isset($_SESSION['user']) && $_SESSION['user'] == "admin") : ?>
                                <div class="row mb-2">
                                    <div class="col-sm">
                                        <a href="edit.php?masp=<?=$col['masp'];?>" class="btn btn-primary">Sửa</a>
                                    </div>
                                    <form class="form-inline col-sm" action="delete.php" method="POST">
                                            <input type="hidden" name="masp" value="<?= $col['masp'] ?>">
                                            <button type="submit" class="btn btn-xs btn-danger" name="delete">
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
        <div id="delete-confirm" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Xác nhận xóa sản phẩm</h4>
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
<!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
</script> -->
    <script>
        $(document).ready(function(e) {
            $(".item-img").on('click', function (e) {
                e.preventDefault()
                const phone = $(this);
                const id = phone.parent().children()[0].value;
                window.location.href = `phone-info.php?masp=${id}`;
            });
            $('button[name="delete"]').on('click', function(e){
                e.preventDefault();
                const form = $(this).closest('form');
                const name = $(this).closest('.item').find('p:first');
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