<?php
  require_once('../conn.php');
  if (isset($_GET['malop'])){
    $malop=$_GET['malop'];    
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>QL lớp</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Material Kit CSS -->
  <!-- BOOTSRAP 4-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- link css script -->
  <link rel="stylesheet" href="../style.css">
  <script src="../main.js"></script>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  
</head>

<body style="background-color: #1a2035;">
  <div class="wrapper ">
    <div class="sidebar w3-sidebar w3-bar-block w3-card w3-animate-left" id="mySidebar" >
      <div class="logo">
          <a href="index.html" class="logo-text">TDTU Classroom</a>
          <button id="myBtnClose" >
              <i class="fa fa-bars" aria-hidden="true"></i>
          </button>
      </div>

      <div class="sidebar-wrapper">
          <ul class="nav">
              <li class="nav-item">
                <a class="nav-link" href="indexAdmin.php">
                  <i class="fa fa-windows" aria-hidden="true"></i>
                  <p>Trang chủ</p>
                </a>
              </li>
    
              <li class="nav-item active" onclick="showManage()">
                <a class="nav-link" href="DSLop.php">
                  <i class="fa fa-user-circle" aria-hidden="true"></i>
                  <p>QL Lớp</p>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="taikhoan.php">
                  <i class="fa fa-bars" aria-hidden="true"></i>
                  <p>Tài khoản</p>
                </a>
              </li>
              <!-- your sidebar here -->
            </ul>
      </div>
    </div>

    <div class="main-panel main" id="main">
      <div id="list" style="width: 5%;" onmouseover="w3_open_Admin()">
        <button id="myBtnOpen">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </button>
        <i class="fa fa-windows" aria-hidden="true"></i>
        <i class="fa fa-user-circle" aria-hidden="true"></i>
      </div>


      <div class="content" style="width: 100%;" onclick="w3_close_Admin()">
        <div class="navbar">
          <h2>Quản lý lớp</h2>
        </div>

        <div class="container">
          <!-- your content here -->
          <div class="row">
             <!-- Quản lí tài khoản -->
            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="header">
                  <h4>Danh sách thành viên</h4>
                </div>
                <div class="card-body">
                  <div class="table">
                    <table id="show-ds-tv" class="table">
                    <?=getSV_GV($malop); ?> 
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="header">
                  <h4>Danh sách bài đăng</h4>
                </div>
                <div class="card-body">
                  <div class="table">
                    <table id="show-ds-bd" class="table">
                      <thead>
                        <tr>
                          <th>STT</th>
                          <th>Tiêu đề</th>
                          <th>Loại bài đăng</th>
                          <th>Ngày đăng</th>
                          <th>Người đăng</th>
                          <th>Xóa</th>
                        </tr>
                      </thead>
                      <tbody id="show-post-admin">
                        <?=getBaidang_admin($malop) ?>                      
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<footer class="footer">
  <div class="container-fluid">
    <nav class="float-left">
      <ul>
        <li>
        </li>
      </ul>
    </nav>
    <div class="copyright float-right">
      &copy;
      <script>
        document.write(new Date().getFullYear())
      </script>, made with <i class="material-icons">favorite</i> by
      <a href="https://www.creative-tim.com" target="_blank">TDTU</a> Classroom.
    </div>
    <!-- your footer here -->
  </div>
</footer>
</body>

</html>