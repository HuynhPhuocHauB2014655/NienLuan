<?php 
include_once __DIR__ . '/../general/header.php';
require_once __DIR__ . '/../general/connect.php';
$sql = 'SELECT * from giohang where magh=? and masp=?';
$stmt = $pdo->prepare($sql);
if(isset($_SESSION['user'])) {
    $stmt->execute([$_SESSION['user'], $_POST['masp']]);
}
else{
    $stmt->execute([$_SESSION['guest'], $_POST['masp']]);
}
$rs = $stmt->fetch();
if($rs)
{
    $_SESSION['msg'] = 'Sản phẩm bạn vừa thêm đã tồn tại trong giỏ hàng!';
    header('Location:' . $_SERVER['HTTP_REFERER']);
}
$query = 'INSERT INTO giohang values (?,?)';
$stmt = $pdo->prepare($query);
    if(isset($_SESSION['user'])) {
    $stmt->execute([$_SESSION['user'], $_POST['masp']]);
}
else{
    $stmt->execute([$_SESSION['guest'], $_POST['masp']]);
}
$_SESSION['msg'] = 'Sản phẩm đã thêm vào giỏ hàng thành công!';
header('Location:' . $_SERVER['HTTP_REFERER']);
exit();