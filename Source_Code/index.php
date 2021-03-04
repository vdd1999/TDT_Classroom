<?php
	require_once('conn.php');
	session_start();
	if (isset($_SESSION['user'])) {
		$matk = $_SESSION['matk'];
		$hoten = $_SESSION["name"];
		$email = $_SESSION["email"];
		$quyen = $_SESSION["quyen"];
		$result = get_ds_Lop($matk);
		if ($result['code'] != 0 ) {
			$error = $result['error'];
		}
		else if ($result['code'] == 0) {
			$data = $result['lop'];
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
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<title></title>
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<!--CSS file-->
	<link rel="stylesheet" href="style.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
	<div id="modal-backdrop1" class="modal-backdrop1" onclick="w3_close();"></div>
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

	<div class="Head" id="main" >
		<div class="left col-lg-4" style="padding: 0;">
			<div id="myBtn" onclick="w3_open()"  class="list">
				<i class="fa fa-bars" aria-hidden="true"></i>
			</div>

			<div class="titleNav">
				<div style="color : blue;">T</div> <div style="color : red;">D</div> <div style="color : blue;">T</div>	<div style = "margin-left: 5px;">Classroom</div> 
			</div>
		</div>

		


		<div class="center col-lg-4">
			
		</div>

		<div class="right col-lg-4">
			<div class="iconPlus"  data-toggle="modal" aria-labelledby="exampleModalCenterTitle" data-target="#myModal2">
				<span id="iconPlus" class="iconify" data-icon="mdi:plus" data-inline="false"></span>			
			</div>
			<?php
				if ($quyen == 1) {
			?>
			<!-- The Modal create class -->
			<div class="modal" aria-labelledby="exampleModalCenterTitle" id="myModal2">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
					
						<!-- Modal Header -->
						<div class="modal-header">
							<h4 class="modal-title">Create Class</h4>
						</div>
						
						<!-- Modal body -->
						<div class="modal-body">
								<label for="" class="lable-modalAddclass">Class name</label>
								<input id="tenlop" type="text" placeholder = "Enter class name" class="modal-className ip">
								<label for="" class="lable-modalAddclass">Subjects</label>
								<input id="monhoc" type="text" placeholder = "Enter subjects" class="modal-subject ip">
								<label for="" class="lable-modalAddclass">Room</label>
								<input id="phonghoc" type="text" placeholder = "Enter room" class="modal-room ip">
								<label id="#" for="" class="lable-modalAddclass">Avatar</label>
								<div class="custom-file mb-3">
		                            <input type="file" hidden class="custom-file-input" id="anhdaidien" name="filename" multiple accept="image/*"/>
		                            <label class="show-file" id="tenfile" for="anhdaidien">Choose file</label>
	                          	</div>
						</div>
						<div id="show-error" hidden>
	                      	<div id="msg-error" class="alert alert-danger"></div>
	                     </div>
						<!-- Modal footer -->
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-create" onclick="taolop(<?=$matk ?>)">Create</button>
						</div>	
					</div>
	
				</div>
			</div>			
			<?php		
				}
				else if ($quyen == 2) {
			?>
			<!-- The Modal join class-->
			<div class="modal" aria-labelledby="exampleModalCenterTitle" id="myModal2">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
					
						<!-- Modal Header -->
						<div class="modal-header">
							<h4 class="modal-title">Course</h4>
						</div>
						
						<!-- Modal body -->
						<div class="modal-body">
							<form action="">
								<label for="" class="lable-modalAddclass">Course Code</label>
								<input id='join-class' type="text" placeholder = "Enter class name" class="modal-className ip">
							</form>
						</div>
						
						<!-- Modal footer -->
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-create" data-dismiss="modal" onclick="joinLop(<?=$matk ?>)">Join</button>
						</div>	
					</div>
	
				</div>
			</div>
			<?php		
				}
			?>
		</div>

	</div>

	<div class="content" id="main2">
		<div class="titleContent">
			<div class="toDo">
				<?php
				if ($quyen == 2) {
				?>
				<a href="todo.php?malop=<?=$malop?>"><span>To-do</span></a>	
				<?php
				}
				?>
			</div>
			<div class="calender">
				<span class="iconify" data-icon="uil:calender" data-inline="false"></span>
				<span>Calender</span>
			</div>
		</div>
		<div hidden id="msg-join-class" class="alert alert-success">
			  <p></p>
		</div>
		<div class="bodyContent">
			<div id="show-class" class="row">
				<?php
				getLop($matk);
				?>		
			</div>
		</div>
	</div>

	 <!-- jQuery library -->
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

	<!--ICONIFY-->
	<script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>

	<script src="main.js"></script>
</body>
</html>
