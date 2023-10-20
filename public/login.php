<?php

define('TITLE', 'Đăng Nhập');
include_once __DIR__ . '/../general/header.php';
require_once __DIR__ . '/../general/db_connect.php';
$loggedin = false;
$error_message = false;
$query = 'SELECT username,password from users where username=? and password=?';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute([$_POST['username'],$_POST['password']]);
            $row = $stmt->fetch();
        } catch (PDOException $e) {
            echo "Lỗi truy vấn dữ liệu";
        }
        if(!empty($row))
        {
            $_SESSION['user'] = $_POST['username'];
            $loggedin = true;
        }
        else{
            echo '<h3 class="text-center bg-danger">Tên đăng nhập hoặc mật khẩu không khớp!</h3>';
        }
    } else {
        echo '<p class="text-center bg-danger">Hãy đảm bảo rằng bạn cung cấp đầy đủ địa chỉ email và mật khẩu!</p>';
    }
}

if ($loggedin) {
    header("Location: index.php");
    exit();
} else {
    if(isset($_SESSION['flash_message']))
    {
      echo $_SESSION['flash_message'];
      unset($_SESSION['flash_message']);
    }
    echo '<div style="width: 500px;" class="mx-auto mt-3 border border-2">
    <p class="p-2 border-bottom border-2">Đăng nhập</p>
    <div class="px-4">
      <form action="login.php" method="post">
        <div class="mb-3">
          <label class="form-label">Tên đăng nhập:</label>
          <input type="text" class="form-control" placeholder="Nhập vào Tên đăng nhập" name="username" >
        </div>
        <div class="mb-3">
          <label class="form-label">Mật Khẩu:</label>
          <input type="password" class="form-control" placeholder="Nhập vào mật khẩu" name="password">
        </div>
        <button type="submit" class="btn btn-primary mb-2">Đăng nhập</button>
      </form>
    </div>
  </div>';
}

include_once __DIR__ . '/../general/footer.php';