<?php
require_once __DIR__ . '/../general/connect.php';
include_once __DIR__ . '/../general/header.php';
    $sqlth = 'SELECT * from thuonghieu';
    $sqlpkgia = 'SELECT * from phankhucgia';
    $sqlram = 'SELECT * from ram';
    $sqlrom = 'SELECT * from rom';
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

    if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['math'] || $_POST['magia'] || $_POST['idRAM'] || $_POST['idROM']))
    {
        $msg = 'Kết quả lọc';
        $query = 'SELECT * FROM dienthoai where';
        if($_POST['math'])
        {
            $query = $query . ' math=' . '"' . $_POST['math'] . '"';
            if ($_POST['magia'] || $_POST['idRAM'] || $_POST['idROM'])
            {
            $query = $query . ' and';
            }
        }
        
        if($_POST['magia'])
        {
            $query = $query . ' magia=' . '"' . $_POST['magia'] . '"';
            if ($_POST['idRAM'] || $_POST['idROM'])
        {
            $query = $query . ' and';
        }
        }
        
        if($_POST['idRAM'])
        {
            $query = $query . ' maRAM=' . '"' . $_POST['idRAM'] . '"';
            if ($_POST['idROM'])
            {
            $query = $query . ' and';
            }
        }
        if($_POST['idROM'])
        {
            $query = $query . ' maROM=' . '"' . $_POST['idROM'] . '"';
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
        <div class="row mx-3">
            <form method="post" class="mb-5 col-sm">
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
                    <div class="col-sm">
                    <button type="submit" class="btn btn-primary">Lọc</button>
                    </div>
                </div>  
            </form>
            <div class="col-sm-6"></div>
        </div>
        <div>
            <?php $n = ceil(count($rs)/4); 
            $stmt = $pdo->prepare($query);
            isset($_GET['math']) ? $stmt->execute([$_GET['math']]) : $stmt->execute();
            for ($j=0;$j<$n;$j++): ?>
            <div class="row">
                <?php for ($k=0;$k<4;$k++) : ?>
                    <?php $col = $stmt->fetch(); ?>
                    <?php if($col) : ?>
                    <div class="item col-sm border m-1">
                            <input type="hidden" name="masp" value="<?= $htmlspecialchars($col["masp"]); ?>">
                            <img class="py-2 item-img img-fluid" style="max-height: 300px;" src="" alt="">
                            <p class="fs-7 item-title"><?= $htmlspecialchars($col['tensp']); ?><p>
                            <p class=""><?= $htmlspecialchars($col['tonkho']); ?> đ</p>
                            <p class="item-prices text-danger"><?= $htmlspecialchars(number_format($col['gia'],0,",",".")); ?> đ</p>
                            <?php if(isset($_SESSION['user']) && $_SESSION['user'] == "admin") : ?>
                                <div class="row mb-2">
                                    <div class="col-sm">
                                        <a href="edit.php?MaSach=<?=$col['masp'];?>" class="btn btn-primary">Sửa</a>
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