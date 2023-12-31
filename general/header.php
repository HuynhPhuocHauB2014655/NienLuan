<?php
require_once __DIR__ . '/../general/connect.php';
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if(isset($_SESSION['msg']))
    {
        echo '<div class="alert alert-primary alert-dismissible fade show" role="alert" tabindex="-1">
        ' . $_SESSION['msg'] . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        unset($_SESSION['msg']);
    }
    $htmlspecialchars = 'htmlspecialchars';
    if(!isset($_SESSION['user']) && !isset($_SESSION['guest']))
    {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
            $ip = $_SERVER['HTTP_CLIENT_IP'];  
        }  
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
        }  
        else{  
            $ip = $_SERVER['REMOTE_ADDR'];  
        }
        $_SESSION['guest'] = $ip;
    }
    if(isset($_SESSION['user']) || isset($_SESSION['guest']))
    {
        $sql_header= 'SELECT count(*) as sogh from giohang where magh=?';
        $sql_header_stmt = $pdo->prepare($sql_header);
        if(isset($_SESSION['user']))
        {
            $sql_header_stmt ->execute([$_SESSION["user"]]);
        }
        else
        {
            $sql_header_stmt ->execute([$_SESSION["guest"]]);
        }
        $header_rs = $sql_header_stmt->fetch();
        if(isset($_SESSION['user'])){

            $sql_header= 'SELECT count(*) as sotb from thongbao where username=? and trangthaitb=?';
            $sql_header_stmt = $pdo->prepare($sql_header);
            $sql_header_stmt ->execute([$_SESSION['user'], 0]);
            $header_rs_notice = $sql_header_stmt->fetch();

        }   

    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style copy.css">
    <link rel="shortcut icon" type="image/jpg" href="images/LOGO-2.png">
    <title><?php
            if (defined('TITLE')) {
                echo TITLE;
            } else {
                echo 'H&N';
            }
            ?></title>
</head>
<body>
<div class="container"> 
    <nav class="header-container row">
        <div class="logo col-sm-1 fs-6">
            <a class="nav-link" href="index.php"><img class="img-fluid" src="/images/LOGO-1.png" width="150"></a>
        </div>
        <div class="col-sm"></div>
        <div class="col-sm-6">
        <?php 
            if(isset($_SESSION['user'])): ?>
                <?php if($_SESSION['user'] == "admin"): ?>
                    <ul class="header-menu">
                        <li class="nav-item p"><a href="revenue.php">Doanh thu</a></li>
                        <li class="nav-item p"><a href="admin-order.php">Đơn hàng</a></li>
                        <li class="nav-item"><a href="notice.php">Thông báo</a></li>
                        <li class="nav-item"><a href="add.php">Thêm sản phẩm</a></li>
                        <li class="nav-item"><a href="logout.php">Đăng xuất</a></li>
                    </ul>
                <?php else : ?>
                <ul class=" header-menu"> 
                    <li class="nav-item"><a href="order.php">Đơn hàng</a></li>
                    <li class="nav-item position-relative"><a href="notice.php?username=<?=$_SESSION['user']; ?>"><i class="fa-solid fa-envelope"></i></i></a>
                    <?php if($header_rs_notice['sotb'] > 0):
                        echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">' . $header_rs_notice['sotb'] . '</span></li>';
                    endif; ?>
                    <li class="nav-item position-relative"><a href="cart.php?username=<?=$_SESSION['user']; ?>"><i class="fa-solid fa-cart-shopping"></i></a>
                    <?php if($header_rs['sogh'] > 0):
                        echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">' . $header_rs['sogh'] . '</span></li>';
                    endif; ?>  
                    <li class="nav-item"><a href="user.php">Tài khoản</a></li>
                    <li class="nav-item"><a href="logout.php">Đăng xuất</a></li>
                </ul>
                <?php endif; ?>
            <?php else : ?>
                <ul class="header-menu">
                    <li class="nav-item position-relative"><a href="cart.php?username=<?=$_SESSION['guest']; ?>"><i class="fa-solid fa-cart-shopping"></i></a>
                    <?php if($header_rs['sogh'] > 0):
                        echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">' . $header_rs['sogh'] . '</span></li>';
                    endif; ?>
                    <li class="nav-item"><a href="login.php">Đăng Nhập</a></li>
                    <li class="nav-item"><a href="register.php">Đăng ký</a></li>
                </ul>
            <?php endif; ?>
    </div>
</nav>