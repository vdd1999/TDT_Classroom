<?php
require_once('conn.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
      integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
      crossorigin="anonymous"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </head>
  <body id="main" onload="countdown()">
    <?php
    $error = "";
    $msg ="";
      if (isset($_GET['email']) && isset($_GET['malop']) && isset($_GET['matk'])) {
        $email = $_GET['email'];
        $malop =$_GET['malop'];
        $matk = $_GET['matk'];
        if (filter_var($email,FILTER_VALIDATE_EMAIL) == false){
          $error = "Invalid email address";
        }
        else if (strlen($malop) != 6){
          $error = "Invalid mã lớp format";
        }
        else {
          $result = activeClass($malop,$matk);
          if ($result['code'] == '0') {
            $msg = "Chúc mừng đã tham gia lớp thành công";
          }
          else {
            $error = $result['error'];
          }
        }
      }
      else {
        $error = "Invalid url";
      }
    ?>
    <div class="container">
    <?php

    if(!empty($error)){
      ?>
      <div class="row">
          <div class="col-md-6 mt-5 mx-auto p-3 border rounded">
              <h4>Tham gia lớp thất bại</h4>
              <p class="text-danger"><?=$error ?></p>
          </div>
      </div>
      <?php
}
else {
  ?>
      <div class="row">
        <div class="col-md-6 mt-5 mx-auto p-3 border rounded">
            <h4>Tham gia lớp học</h4>
            <p class="text-success">Chúc mừng bạn tham gia lớp thành công</p>
            <p>Nhấn <a href="class.php?malop=<?=$malop ?>.php">vào đây</a> để trở về lớp của mình, hoặc trang web sẽ tự động chuyển hướng sau <span id="counter" class="text-danger">5</span> giây nữa.</p>
            <a class="btn btn-success px-5" href="class.php?malop=<?=$malop ?>.php">Về lớp</a>
        </div>
      </div>
  <?php

}
    ?>

    </div>
  </body>
    <script src="main.js"></script>
</html>
