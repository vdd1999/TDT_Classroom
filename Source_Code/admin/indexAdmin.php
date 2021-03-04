<?php
    session_start();
    require_once('../conn.php');
    if (isset($_SESSION['userAdmin'])) {
        $matk = $_SESSION['matk'];
        $hoten = $_SESSION['name'];
        $email = $_SESSION['email'];
    }
    else {
        header('Location:loginAdmin.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Admin</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
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
    <div class="wrapper">
        <div class="sidebar w3-sidebar w3-bar-block w3-card w3-animate-left" id="mySidebar" >
            <div class="logo">
                <a href="indexAdmin.php" class="logo-text">TDTU Classroom</a>
                <button id="myBtnClose">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </button>
            </div>

            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="nav-item active">
                      <a class="nav-link" href="indexAdmin.php">
                        <i class="fa fa-windows" aria-hidden="true"></i>
                        <p>Trang chủ</p>
                      </a>
                    </li>
          
                    <li class="nav-item" onclick="showManage()">
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

            <div class="logoutAdmin">
                <p class="nameAcc"><?= $hoten ?></p>
                <p class="emailAcc"><?= $email ?></p>
                <a href="logoutAdmin.php">
                    <button class="signout">Sign out</button>
                </a>
            </div>
        </div>

        <div class="main" id="main">
            <div id="list" style="width: 5%;" onmouseover="w3_open_Admin()">
                <button id="myBtnOpen" >
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </button>
                <i class="fa fa-windows" aria-hidden="true"></i>
                <i class="fa fa-user-circle" aria-hidden="true"></i>
            </div>

            <div class="main-content" style="width: 100%;" onclick="w3_close_Admin()">
                <div class="navbar">
                    <h2>Trang Chủ</h2>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="card one">
                                <div class="card-tittle money">Số lớp</div>
                                <div class="chart">
                                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                    <div class="num"><?=getamountClass(); ?></div>
                                 </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="card two">
                                <div class="card-tittle book">Số tài khoản</div>
                                <div class="chart">
                                    <i class="fa fa-area-chart" aria-hidden="true"></i>
                                    <div class="num"><?=getamountTk(); ?></div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>