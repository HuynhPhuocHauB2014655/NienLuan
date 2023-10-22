<?php
define('TITLE', 'Đăng Nhập');
include_once __DIR__ . '/../general/header.php';
require_once __DIR__ . '/../general/connect.php';

$loggedin = false;
$error_message = false;
$query = 'SELECT username,password from khachhang where username=? and password=?';

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
            if(isset($_SESSION['guest']) && !($_SESSION['user'] == 'admin'))
            {
                $query = 'SELECT * from giohang where magh=?';
                $query1 = 'SELECT * from giohang where magh=?';
                $stmt = $pdo->prepare($query);
                $stmt->execute([$_SESSION['guest']]);
                $stmt1 = $pdo->prepare($query1);
                $stmt1->execute([$_SESSION['user']]);
                $ghguest = $stmt->fetchAll();
                $ghuser = $stmt1->fetchAll();
                if(!empty($ghguest))
                {
                  $sql = 'INSERT into giohang set';
                  $isexit = 0;
                  foreach ($ghguest as $ghguest)
                  {
                    foreach ($ghuser as $ghuser)
                    {
                      if($ghguest['masp'] == $ghuser['masp'])
                      {
                        $isexit = 1;
                      }
                    }
                    if(!$isexit)
                    {
                      $query2 = 'INSERT into giohang value (?,?)';
                      $query3 = 'DELETE from giohang where magh=?';
                      $stmt2 = $pdo->prepare($query2);
                      $stmt2->execute([$_SESSION['user'],$ghguest['masp']]);
                      $stmt3 = $pdo->prepare($query3);
                      $stmt3->execute([$_SESSION['guest']]);
                    }
                  }
                }
              $sql = 'DELETE from khachhang where username=?';
              $stmt4 = $pdo->prepare($sql);
              $stmt4->execute([$_SESSION['guest']]);
              unset($_SESSION['guest']); 
            }
        else{
            echo '<h3 class="text-center bg-danger">Tên đăng nhập hoặc mật khẩu không khớp!</h3>';
        }
    } else {
        echo '<p class="text-center bg-danger">Hãy đảm bảo rằng bạn cung cấp đầy đủ địa chỉ tên đăng nhập và mật khẩu!</p>';
    }
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
  }
  
?>
<?php include_once __DIR__ . '/../general/nav.php' ?>
    <div style="margin: 100px auto; width: 500px;" class="rounded border p-5 bg-light bg-gradient">
      <p class="p-2 border-bottom border-3">Đăng nhập</p>
      <div class="px-4">
        <form action="login.php" method="post" class="form-horizontal" id="signupForm">
          <div class="mb-3">
            <label class="form-label">Tên đăng nhập:</label>
            <input type="text" id="username" class="form-control" placeholder="Nhập vào Tên đăng nhập" name="username" >
          </div>
          <div class="mb-3">
            <label class="form-label">Mật Khẩu:</label>
            <input type="password" id="password" class="form-control" placeholder="Nhập vào mật khẩu" name="password">
          </div>
          <button type="submit" class="btn btn-primary mb-2">Đăng nhập</button>
          <span>Chưa có tài khoản? </span><a href="register.php" class="link-secondary">Đăng ký </a>
        </form>
      </div>
    </div>
<?php include_once __DIR__ . '/../general/footer.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script type="text/javascript">
			$(document).ready(function (){
				$('#signupForm').validate({
					rules: {
						username: { 
							required: true,
							minlength: 2
						},
						password: { 
							required: true, 
							minlength: 5
						},
					},
					messages: {
						username: { 
							required: 'Bạn chưa nhập vào tên đăng nhập',
							minlength: 'Tên đăng nhập phải có ít nhất 2 ký tự'
						},
						password: { 
							required: 'Bạn chưa nhập mật khẩu', 
							minlength: 'Mật khẩu phải có ít nhất 5 ký tự'
						},
					},
					errorElement: 'div',
					errorPlacement: function (error, element){
						error.addClass('invalid-feedback');
						if (element.prop('type') === 'checkbox') {
							error.insertAfter(element.siblings('label'));
						} else {
							error.insertAfter(element);
						}
					},
					highlight: function (element, errorClass, validClass) {
						$(element)
						.addClass('is-invalid')
						.removeClass('is-valid');
					},
					unhighlight: function (element, errorClass, validClass) {
						$(element)
						.addClass('is-valid')
						.removeClass('is-invalid');
					},
				});
			});
	</script>