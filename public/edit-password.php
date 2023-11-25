<?php
define('TITLE', 'Đổi mật khẩu'); 
require_once __DIR__ . '/../general/connect.php';
include_once __DIR__ . '/../general/header.php';

if(isset($_SESSION['user']) && ($_SERVER['REQUEST_METHOD'] == 'POST')){
    try {
        $query = 'select password from khachhang where username=?';
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_SESSION['user']]);
        $rs = $stmt->fetch();
        if($rs['password'] == $_POST['password']){

            $query = 'update khachhang set password=? where username=?';
            $stmt = $pdo->prepare($query);
            $stmt->execute([$_POST['newpassword'], $_SESSION['user']]);

            $_SESSION['msg'] = 'Đổi mật khẩu thành công';
            header('Location: user.php');
            exit();
        }
    } catch (PDOException $e)
    {
        echo "Lỗi truy vấn dữ liệu ";
    }
}


?>
<?php include_once __DIR__ . '/../general/nav.php' ?>
<div>
    <h1 class="text-center">ĐỔI MẬT KHẨU</h1>
    <hr>
    <div class="d-flex justify-content-center" >
    <form method="post" style="width: 50%" id="change-password-form">
        
            <div class="form-group row my-2">
                <label class="col-sm fs-5" >Nhập mật khẩu cũ: </label>
                <div class="col-sm-7 ">
                    <input class="form-control" type="password" name="password" id="password">
                </div>
            </div>
            <div class="form-group row my-2">
                <label class="col-sm fs-5" >Nhâp mật khẩu mới:</label>
                <div class="col-sm-7">
                    <input class="form-control" type="password" name="newpassword" id="newpassword">
                </div>
            </div>
            <div class="form-group row my-2">
                <label class="col-sm fs-5" >Nhập lại mật khẩu mới:</label>
                <div class="col-sm-7">
                    <input class="form-control" type="password" name="confirm_password" id="confirm_password">
                </div>
            </div>
            <div class="d-flex justify-content-start">
                <button class="btn btn-primary fs-5" type="submit" id="submit">
                    Xác nhận
                </button>
            </div>
            
    </form>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function (){
    $('#change-password-form').validate({
        rules: {

            password: { 
                required: true, 
                minlength: 5
            },
            newpassword:{
                required: true, 
                minlength: 5
            },
            confirm_password: { 
                required: true,
                equalTo: '#newpassword'
            }
        },
        messages: {
        
            password: { 
                required: 'Bạn chưa nhập mật khẩu', 
                minlength: 'Mật khẩu phải có ít nhất 5 ký tự'
            },
            newpassword: { 
                required: 'Bạn chưa nhập mật khẩu', 
                minlength: 'Mật khẩu phải có ít nhất 5 ký tự'
            },
            confirm_password: { 
                required: 'Bạn phải xác nhận lại mật khẩu',
                equalTo: 'Mật khẩu không trùng khớp với mật khẩu đã nhập'
            }

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