<?php
    require_once('conn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bootstrap 4</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <style>
        .bg {
            background: #eceb7b;
        }
    </style>
</head>
<body>
<?php
    $error = '';
    $hoten = '';
    $sdt = '';
    $ngaysinh ='';
    $email = '';
    $user = '';
    $pass = '';
    $pass_confirm = '';

    if (isset($_POST['hoten']) && isset($_POST['sdt']) && isset($_POST['email'])&& isset($_POST['ngaysinh'])
    && isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['pass-confirm']))
    {
        $hoten = $_POST['hoten'];
        $sdt = $_POST['sdt'];
        $ngaysinh = $_POST['ngaysinh'];
        $email = $_POST['email'];
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $pass_confirm = $_POST['pass-confirm'];
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $activated = 1;
        if (empty($hoten)) {
            $error = 'Please enter your first name';
        }
        else if (empty($sdt)) {
            $error = 'Please enter your phonenumber';
        }
        else if(empty($ngaysinh)) {
            $error = 'Vui lòng nhập ngày sinh';
        }
        else if (empty($email)) {
            $error = 'Please enter your email';
        }
        else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $error = 'This is not a valid email address';
        }
        else if (empty($user)) {
            $error = 'Please enter your username';
        }
        else if (empty($pass)) {
            $error = 'Please enter your password';
        }
        else if (strlen($pass) < 6) {
            $error = 'Password must have at least 6 characters';
        }
        else if ($pass != $pass_confirm) {
            $error = 'Password does not match';
        }
        else {
            // register a new account
            $result = register($user, $pass, $hoten,$ngaysinh,$email,$sdt);
            if ($result['code'] == 0) {
                $error = "Tài khoản đã được tạo, vui lòng kiểm tra email để kích hoạt tài khoản";
                header('Location: Success.php');
            }
            else if($result['code'] == 1) {
                $error = 'Email exist';
            }
            else {
                $error = 'Sever cannot create account';
            }

        }
    }
?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 border my-5 p-4 rounded mx-3">
                <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Create a new account</h3>
                <form method="post" action="register.php" novalidate="">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="firstname">Họ và Tên</label>
                            <input value="<?= $hoten?>" name="hoten" required class="form-control" type="text" placeholder="Nhập họ tên" id="hoten">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Số điện thoại</label>
                            <input value="<?= $sdt?>" name="sdt" required class="form-control" type="text" placeholder="Nhập số điện thoại" id="sdt">
                            <div class="invalid-tooltip">Số điện thoại là bắt buộc</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input value="<?= $email?>" name="email" required class="form-control" type="email" placeholder="Email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="ngaysinh">Ngày sinh</label>
                        <input value="<?= $ngaysinh?>" name="ngaysinh" required class="form-control" type="date" placeholder="Ngày sinh" id="ngaysinh">
                    </div>
                    <div class="form-group">
                        <label for="user">Tài khoản</label>
                        <input value="<?= $user?>" name="user" required class="form-control" type="text" placeholder="Username" id="user">
                        <div class="invalid-feedback">Please enter your username</div>
                    </div>
                    <div class="form-group">
                        <label for="pass">Mật khẩu</label>
                        <input  value="<?= $pass?>" name="pass" required class="form-control" type="password" placeholder="Password" id="pass">
                        <div class="invalid-feedback">Password is not valid.</div>
                    </div>
                    <div class="form-group">
                        <label for="pass2">Confirm Password</label>
                        <input value="<?= $pass_confirm?>" name="pass-confirm" required class="form-control" type="password" placeholder="Confirm Password" id="pass2">
                        <div class="invalid-feedback">Password is not valid.</div>
                    </div>
                    <div class="form-group">
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        ?>
                        <button type="submit" class="btn btn-success px-5 mt-3 mr-2">Register</button>
                        <button type="reset" class="btn btn-outline-success px-5 mt-3">Reset</button>
                    </div>
                    <div class="form-group">
                        <p>Already have an account? <a href="login.php">Login</a> now.</p>
                    </div>
                </form>

            </div>
        </div>

    </div>
</body>
</html>

