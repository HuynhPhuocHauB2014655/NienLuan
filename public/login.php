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