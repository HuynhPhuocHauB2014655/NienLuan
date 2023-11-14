<?php

define('TITLE', 'Hỗ trợ');
include_once __DIR__ . '/../general/header.php';
require_once __DIR__ . '/../general/connect.php';



if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!isset($_SESSION['user']))
    {
        $_SESSION['msg'] = 'Bạn cần phải đăng nhập để có thể gửi ý kiến đến chúng tôi.';
        header("Location: login.php");
        
        exit();
    }

    $query = 'insert into binhluan values (?,?,?)';

    $stmt = $pdo->prepare($query);
    $stmt->execute(['', $_SESSION['user'], $_POST['comment']]);

    $_SESSION['msg'] = 'Chúng tôi đã ghi nhận ý kiên của bạn.';
    header('Location: support.php');
}

include_once __DIR__ . '/../general/nav.php';

?>
<h1 class="text-center">HỖ TRỢ KHÁCH HÀNG</h1>
<hr>

<div class="accordion" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
        1. Tôi có thể trả tiền thông qua PayPal?
      </button>
    </h2>
    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <strong>Xin lỗi nhưng chúng tôi không nhận thanh toán qua PayPal.</strong>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
        2. Tôi có thể hủy bỏ đặt hàng?
      </button>
    </h2>
    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <strong>Bạn có thể hủy bỏ đơn hàng nếu đơn hàng đó chưa được xác nhận.</strong> 
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
        3. Chính sách hoàn tiền như thế nào?  
      </button>
    </h2>
    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <strong>Bạn có thể nhận được tiền hoàn trả 100% bất kể khi nào và vì bất kỳ lý do gì.</strong>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
        4. Làm thế nào để tôi có thể nhận được hóa đơn?
      </button>
    </h2>
    <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <strong>Bạn có thể nhận được hóa đơn thông qua email hoặc thông báo từ chúng tôi.</strong>
      </div>
    </div>
  </div>
</div>
<form method="POST">
        
    <div class="form-group my-2">
        <label for="comment">Câu hỏi khác:</label>
        <textarea class="form-control" placeholder="Hãy viết nội dung bạn cần hỏi ở đây." name="comment" id="comment" style="height: 100px"></textarea>
    </div>
    <button type="submit" class="btn btn-primary mt-2">
        Gửi
    </button>
</form>
<?php include_once __DIR__ . '/../general/footer.php'; ?>