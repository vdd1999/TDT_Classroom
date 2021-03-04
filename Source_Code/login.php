<?php
    session_start();
    if (isset($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }
    require_once('conn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<?php

    $error = '';
    $user = '';
    $pass = '';

    if (isset($_POST['user']) && isset($_POST['pass'])) {
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        if (empty($user)) {
            $error = 'Please enter your username';
        }
        else if (empty($pass)) {
            $error = 'Please enter your password';
        }
        else if (strlen($pass) < 6) {
            $error = 'Password must have at least 6 characters';
        }
        else {
            $result = login($user,$pass);
            if ($result['code'] == 0) {
                $data = $result['data'];
                $_SESSION['user'] = $user;
                $_SESSION['matk'] = $data['matk'];
                $_SESSION['name'] = $data['hoten'];
                $_SESSION['email'] = $data['email'];
                $_SESSION['quyen'] = $data['maquyen'];
                header('Location:index.php');
                exit();
            } else {
                $error = $result['error'];
            }
        } 
    }
?>

<div class="container">
    <div class="col-md-8 col-lg-12">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5" style="background-image: url('images/logo-login.png');background-repeat: no-repeat;background-position: left;background-size: 420px 380px;}">
                
            </div>
         <div class="col-md-6 col-lg-7">
            <h3 class="text-center text-secondary mt-5 mb-3">Đăng nhập</h3>
            <form style="background-color: rgba(218, 106, 221, 0.37)!important;" method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                <div class="form-group">
                    <label for="username">Tài khoản</label>
                    <input value="<?= $user ?>" name="user" id="user" type="text" class="form-control" placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input name="pass" value="<?= $pass ?>" id="password" type="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group custom-control custom-checkbox">
                    <input <?= isset($_POST['remember']) ? 'checked' : '' ?> name="remember" type="checkbox" class="custom-control-input" id="remember">
                    <label class="custom-control-label" for="remember">Ghi nhớ đăng nhập</label>
                </div>
                <div class="form-group">
                    <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    ?>
                    <button class="btn btn-success px-5">ĐĂNG NHẬP</button>
                </div>
                <div class="form-group ">
                    <p>Bạn chưa có tài khoản? <a href="register.php">Đăng kí ngay</a>.</p>
                    <p>Quên mật khẩu ư? <a href="forgot.php">Lấy lại mật khẩu ngay</a>.</p>
                </div>
            </form>
        </div>           
        </div>
    </div>
</div>

</body>
</html>
