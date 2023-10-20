<nav class="navbar navbar-expand-lg bg-body-tertiary row text-center">
        <div class="col-sm-1 mx-3">
            <a class="navbar-brand border rounded border-2 border-info p-2" href="index.php">Book Land</a>
        </div>
        <form class="d-flex col-sm-9 justify-content-center" action="search.php" method="post">
            <input class="form-control me-2" type="text" placeholder="Tìm kiếm sách bạn muốn...." name="search">
            <button class="btn border border-2" type="submit">Tìm</button>
        </form>
        <div class="col-sm-2">
        <?php 
            if(isset($_SESSION['user'])) 
            {
                if($_SESSION['user'] == "admin")
                {
                    echo '<ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="add.php">Thêm sách</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Đăng xuất</a></li>';
                }
                else{
                    echo '<ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="#">Tài khoản</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Đăng xuất</a></li>';
                }
                echo '</ul>';
            }
            else
            {
                echo '<ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="login.php">Đăng Nhập</a></li>
                <li class="nav-item"><a class="nav-link" href="register.php">Đăng ký</a></li>
                </ul>';
            } 
    ?>
    </div>
    
</nav>
<div class="container"> 
        <hr>
            <div>
                <ul class="nav row bg-info mb-3">
                    <a class="nav-link px-5 text-black col-sm text-center hlink" href="index.php">Trang Chủ</a>              
                    <a class="nav-link px-5 text-black col-sm text-center hlink" href="index.php?TT=true">Tiểu Thuyết</a>
                    <a class="nav-link px-5 text-black col-sm text-center hlink" href="index.php?MG=true">Manga</a>
                    <a class="nav-link px-5 text-black col-sm text-center hlink" href="index.php?KT=true">Kinh Tế</a>
                    <a class="nav-link px-5 text-black col-sm text-center hlink" href="index.php?NN=true">Học Ngoại Ngữ</a>                    
                </ul>
            </div>