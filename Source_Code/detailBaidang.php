<?php
	require_once('conn.php');
	session_start();
	if (isset($_SESSION['user'])) {
		$matk = $_SESSION['matk'];
		$hoten = $_SESSION["name"];
		$email = $_SESSION["email"];
		$quyen = $_SESSION["quyen"];
		$mabd = $_GET['mabd'];
		$malop = $_GET['malop'];
		$result_baidang = get_detail_baidang($mabd);
		$result = get_ds_lop($matk);
		$data = $result['lop'];
		$baidang = $result_baidang['baidang'];
		if (isset($_POST['btn_nopbai'])) {
			if ($_FILES['filename_nopbai']['size'] != 0) {
				$bainop = $_FILES['filename_nopbai']['name'];				
			}
			$malop = $_GET['malop'];
			$matk = $_SESSION['matk'];
			$file = $_FILES["filename_nopbai"]["tmp_name"];
			$destination = 'uploads/'.$bainop;
			move_uploaded_file($file, $destination);
			nopbai($mabd,$matk,$malop,$bainop);
        }
	}
	else {
		header('Location:login.php');
		exit();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title></title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="./style.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

	<!--ICONIFY-->
	<script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<div id="modal-backdrop1" class="modal-backdrop1" onclick="w3_closePost();"></div>
	<div class="w3-sidebar w3-bar-block w3-card w3-animate-left hover1" style="display:none" id="mySidebar">
		<div class="logout">
			<p class="nameAcc"><?= $hoten ?></p>
			<p class="text-truncate emailAcc"><?= $email ?></p>
			<a href="logout.php">
				<button class="signout">Sign out</button>
			</a>
		</div>
		<a href="index.php">
			<div class="classes">
				<i class="fa fa-home icon" aria-hidden="true"></i>
				<div class="text">Classes</div>
			</div>
		</a>

		<div class="classes">
			<i class="fa fa-calendar-o icon" aria-hidden="true"></i>
			<div class="text">Calendar</div>
		</div>

		<hr>

		<div>
			<div class="classes">
				<i class="fa fa-list-alt icon" aria-hidden="true"></i>
				<div class="text">To-do</div>
			</div>

			<?php
				foreach ($data as $dt) {
			?>
			<a href="class.php?malop=<?=$dt['malop']?>">
				<div class="classes">
					<div class="avatar">
						<div class="ava-img"><?= substr($dt['tenlop'],0,1) ?></div>
					</div>

					<div class="infoClass">
						<div class="Subjects">
							<span class="name_class"><?= $dt['tenlop'] ?></span>
						</div>

						<div class="teacherName">
							<span id=""><?=get_name_GV($dt['malop']);?></span>
						</div>
					</div>
				</div>
			</a>
			<?php 
				}
			?>
		</div>

		

		
	</div>
<div class="Head" id="main">
	<div class="left col-lg-6" style="padding: 0;">
		<div id="myBtn" onclick="w3_open()"  class="list" data-toggle="modal" data-target="#myModal">
			<i class="fa fa-bars" aria-hidden="true"></i>
		</div>
		
		<a href="class.php?malop=<?= $malop ?>">
			<div class="infoClass">
				<div class="Subjects">
					<span id="subjectsName"><?=get_name_class($malop) ?></span>
				</div>

				<div class="teacherName">
					<span id="teacherName"><?=get_name_GV($malop) ?></span>
				</div>
			</div>
		</a>
	</div>


	<div class="right col-lg-6">
		<!-- <div class="abc">
			<img src="https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/s40-c-fbw=1/photo.jpg" alt="">
		</div> -->
	</div>

</div>

<div class="container container-post" id="main2">
	<div class="row">
		<!-- <div class="col-1">
			<div class="icon">
				<span class="iconify" data-icon="fa-solid:clipboard-list" data-inline="true" style="color: black;margin-left: 0.7rem;margin-top: 0.45rem;"></span>
			</div>
		</div> -->
		<!-- Nội dung bài tập -->
		<div class="col-lg-7 col-md-12 col-12">
			<div class="post-title">
				<div class="icon">
					<span class="iconify" data-icon="fa-solid:clipboard-list" data-inline="true" style="color: black;margin-left: 0.7rem;margin-top: 0.45rem;"></span>
				</div>
				<div class="ml-3">
					<div class="post-name">
						<h2><?=$baidang['tieude'] ?></h2>
					</div>
					<div class="created">
						<div class="userCreate"><?=get_name_GV($malop); ?></div>
						<div class="dot ml-1 mr-1" aria-hidden="true">•</div>
						<div class="createdDate"><?=$baidang['ngaytao'] ?></div>
					</div>
				</div>
			</div>
			<div class="post-body">
				<p class="dfd">
					<?=$baidang['noidung'] ?>
				</p>
			</div>

			<hr>

			<div class="post-footer">
				<div id="show-cmt">
					<?=getComment($mabd,$matk) ?>
				</div>
				<div class="class-cmt">
					<div class="title-cmt">
						<p>Class comment</p>
					</div>
					<div class="text-cmt">
						<img class="user-cmt" aria-hidden="true" src="https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/s40-c-fbw=1/photo.jpg">
						<div class="input-cmt">
							<textarea id="cmt-assign" data-matk="<?=$matk ?>" data-mabd="<?=$mabd ?>" type="text" placeholder="Add class Comment"></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--Phần nộp bài-->		
		<div class="col-lg-5 col-md-12 col-12 submit">
			<?php
			if ($quyen ==2){
			?>
			<div class="submit-file" id="show-file-submit">
				<?=submitFile($mabd,$matk) ?>
			</div>			
			<?php
			}
			else if ($quyen != 2) {
			?>

				<div class="col-12 mb-4">
					<?=get_all_file_nop($mabd)?>
                </div>
            <?php
			}
			?>

		</div>
	</div>
</div>
</body>
<script src="main.js"></script>

</html>