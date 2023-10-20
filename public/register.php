<?php
    require_once __DIR__ . '/../general/db_connect.php';
    include_once __DIR__ . '/../general/header.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $sql = 'SELECT username from users where username =?';
        try {
            $stmt= $pdo->prepare($sql);
            $stmt->execute([$_POST['username']]);
            $row = $stmt->fetch();
        } catch (PDOException $e)
        {
            echo "Lỗi truy vấn dữ liệu";
        }
        if(empty($row))
        {
            $query = 'INSERT INTO users value (?,?,?,?,?)';
            try {
                $stmt1= $pdo->prepare($query);
                $stmt1->execute([$_POST['username'],$_POST['password'],$_POST['hoten'],$_POST['Sdt'],$_POST['DiaChi']]);
                $_SESSION['flash_message'] = '<h3 class="text-center bg-success">Bạn đã đăng ký thành công</h3>';
                header('location: login.php');
            } catch (PDOException $e)
            {
                echo "Lỗi truy vấn dữ liệu 1";
            }
        }
        else
        {
            echo '<h3 class="text-center bg-danger mt-2">Tên đăng nhập của bạn đã được sử dụng</h3>';
        }
    }
    ?>

<body>
    <div class="container d-flex justify-content-center">
        <div style="width: 500px;" class="border border-2 mt-5 py-3 px-5">
            <h2 class="text-center">Đăng kí tài khoản</h2>
            <hr>
            <form method="post" action="register.php">
                <label class="form-label mt-2">Tên đăng nhập: </label><br/>
                <input class="form-control" type="text" name="username"><br/>
                <label class="form-label">Mật khẩu: </label><br/>
                <input class="form-control" type="password" name="password"><br/>
                <label class="form-label">Họ và tên: </label><br/>
                <input class="form-control" type="text" name="hoten"><br/>
                <label class="form-label">Số điện thoại: </label><br/>
                <input class="form-control" type="text" name="Sdt"><br/>
                <label class="form-label">Địa chỉ: </label><br/>
                <input class="form-control" type="text" name="DiaChi"><br/>
                <button type="submit" class="btn btn-primary">Đăng ký</button>
            </form>
        </div>
    </div>

<?php include_once __DIR__ . '/../general/footer.php';