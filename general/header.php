<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if(isset($_SESSION['msg']))
    {
        echo '<h5 class="text-center bg-success">' . $_SESSION['msg'] . '</h5>';
        unset($_SESSION['msg']);
    }
    $htmlspecialchars = 'htmlspecialchars';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/css.css">
    <link rel="shortcut icon" type="image/jpg" href="">
    <title><?php
            if (defined('TITLE')) {
                echo TITLE;
            } else {
                echo 'H & N';
            }
            ?></title>
</head>
<body>
<div class="container"> 
    <nav class="header-container row">
        <div class="logo col-sm-1">
            <a href="index.php">LOGO</a>
        </div>
        <div class="col-sm"></div>
        <div class="col-sm-3">
        <?php 
            if(isset($_SESSION['user'])) 
            {
                if($_SESSION['user'] == "admin")
                {
                    echo '<ul class="header-menu">
                    <li class="nav-item"><a href="add.php">Thêm sách</a></li>
                    <li class="nav-item"><a href="logout.php">Đăng xuất</a></li>';
                }
                else{
                    echo '<ul class=" header-menu">
                <li class="nav-item"><a href="#">Tài khoản</a></li>
                <li class="nav-item"><a href="logout.php">Đăng xuất</a></li>';
                }
                echo '</ul>';
            }
            else
            {
                echo '<ul class="header-menu">
                <li class="nav-item"><a href="login.php">Đăng Nhập</a></li>
                <li class="nav-item"><a href="register.php">Đăng ký</a></li>
                </ul>';
            } 
    ?>
    </div>
</nav>