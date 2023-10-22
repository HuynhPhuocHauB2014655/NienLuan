<?php
    define('TITLE', 'Đăng Ký');
    require_once __DIR__ . '/../general/connect.php';
    include_once __DIR__ . '/../general/header.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $sql = 'SELECT username from khachhang where username =?';
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
            $query = 'INSERT INTO khachhang value (?,?,?,?,?,?,?,?)';
            try {
                $stmt1= $pdo->prepare($query);
                $stmt1->execute([$_POST['username'],$_POST['password'],$_POST['hoten'],$_POST['ngaysinh'],$_POST['sdt'],$_POST['diachi'],"",$_POST['username']]);
                $_SESSION['flash_message'] = '<h3 class="text-center bg-success mt-2 py-1">Bạn đã đăng ký thành công</h3>';
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
<?php include_once __DIR__ . '/../general/nav.php' ?>
        <div style="margin: 100px auto; width: 900px;" class="rounded border p-5 bg-light bg-gradient">
            <h2 class="text-center">Đăng kí tài khoản</h2>
            <hr>
            <form method="post" id="regiser-form">
                <div class="row">
                    <div class="col-sm">
                        <label class="form-label">Tên đăng nhập: </label><br/>
                        <input class="form-control" type="text" id="username" name="username"><br/>
                        <label class="form-label">Mật khẩu: </label><br/>
                        <input class="form-control" type="password" id="password" name="password"><br/>
                        <label class="form-label">Nhập lại mật khẩu: </label><br/>
                        <input class="form-control" type="password" id="confirm_password" name="confirm_password"><br/>
                        <label class="form-label">Ngày sinh: </label><br/>
                        <input class="form-control" type="date" id="ngaysinh" name="ngaysinh"><br/>
                        <input class="form-check-input" type="checkbox" id="agree" name="agree" value="agree"/>
				        <label class="form-check-label" for="agree">Đồng ý các quy định của chúng tôi</label><br>
                    </div>
                    <div class="col-sm">
                        <label class="form-label">Họ và tên: </label><br/>
                        <input class="form-control" type="text" id="hoten" name="hoten"><br/>
                        <label class="form-label">Số điện thoại: </label><br/>
                        <input class="form-control" type="text" id="sdt" name="sdt"><br/>
                        <label class="form-label">Địa chỉ: </label><br/>
                        <input class="form-control" id="DiaChia" type="text" name="diachi"><br/>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Đăng ký</button>
                    <span>Bạn đã có tài khoản? </span><a href="login.php" class="link-secondary">Đăng Nhập</a></div>
                </div>
            </form>
        </div>
<?php include_once __DIR__ . '/../general/footer.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function (){
    $('#regiser-form').validate({
        rules: {
            username: { 
                required: true,
                minlength: 2
            },
            password: { 
                required: true, 
                minlength: 5
            },
            confirm_password: { 
                required: true,
                equalTo: '#password'
            },
            agree: 'required',
            hoten: 'required',
            ngaysinh: 'required',
            sdt: 'required',
            diachi: 'required'
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
            confirm_password: { 
                required: 'Bạn phải xác nhận lại mật khẩu',
                equalTo: 'Mật khẩu không trùng khớp với mật khẩu đã nhập'
            },
            agree: 'Bạn phải đồng ý với điều khoản của chúng tôi',
            hoten: 'Bạn phải nhập họ và tên',
            ngaysinh: 'Bạn phải nhập ngày sinh',
            sdt: 'Bạn phải nhập số điện thoại',
            diachi: 'Bạn phải nhập địa chỉ'
        },
        errorElement: 'div',
        errorPlacement: function (error, element){
            error.addClass('invalid-feedback');
            if (element.prop('type') === 'checkbox') {
                error.insertAfter(element.siblings('label[for="agree"]'));
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