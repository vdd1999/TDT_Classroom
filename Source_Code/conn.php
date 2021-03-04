<?php
	define('servername','localhost');
	define('username','root');
	define('password','root');
	define('db','classroom');
	// Import PHPMailer classes into the global namespace
	// These must be at the top of your script, not inside a function
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	// Load Composer's autoloader
	require 'vendor/autoload.php';
	function open_db() {
		$conn = new mysqli(servername, username, password, db);
		
		if ($conn->connect_error) {
			die($conn->connect_error);
		}
		return $conn;
	}

	//ĐĂNG NHẬP
	function login ($user, $pass) {
		$sql = "select * from taikhoan where taikhoan = ?";
		$conn = open_db();
		$stm =$conn->prepare($sql);
		$stm->bind_param('s', $user);
		if (!$stm -> execute()) {
			return array('code' => 1,'error'=>'Cannot execute command');
		}

		$result = $stm->get_result();

		if ($result->num_rows == 0) {
			return array('code' => 1,'error'=>'Account does not exist');
		}
		$data = $result->fetch_assoc();
		$hash_pass = $data['matkhau'];
		if (!password_verify($pass, $hash_pass)) {
			return array('code' => 2,'error'=>'Sai mật khẩu');
		}
		else if ($data['is_activated'] == 0){
			return array('code' => 3,'error'=>'Tài khoản chưa được kích hoạt','data'=>$data);
		}
		else return array('code' => 0,'data'=>$data);


	}

	//KIỂM TRA TÀI KHOẢN
	function isExist_taikhoan($user) {
		$sql = 'SELECT * from taikhoan where taikhoan = ?';
		$conn = open_db();
		$stm =$conn->prepare($sql);
		$stm->bind_param('s',$user);
		if (!$stm -> execute()) {
			die('Querry error: '.$stm->error);
		}
		$result = $stm->get_result();
		if ($result->num_rows > 0) {
			return true; //có tài khoản tồn tại
		}else {
			return false;
		}
	}

	//KIỂM TRA EMAIL	
	function isExist_email($email) {
		$sql = 'SELECT taikhoan from taikhoan where email = ?';
		$conn = open_db();
		$stm =$conn->prepare($sql);
		$stm->bind_param('s',$email);
		if (!$stm -> execute()) {
			die('Querry error: '.$stm->error);
		}
		$result = $stm->get_result();
		if ($result->num_rows > 0) {
			return true; //có email
		}else {
			return false;
		}
	}

	//KIỂM TRA TÀI KHOẢN ĐỂ THÊM TV   = MAIL
	function isExist_tk_class($matk,$malop) {
		$sql = 'SELECT * from thanhvien where matk = ? and malop = ?';
		$conn = open_db();
		$stm =$conn->prepare($sql);
		$stm->bind_param('is',$matk,$malop);
		if (!$stm -> execute()) {
			die('Querry error: '.$stm->error);
		}
		$result = $stm->get_result();
		if ($result->num_rows > 0) {
			return true; //có tài khoản tồn tại
		}else {
			return false;
		}
	}
	//isExist_tk_class(23,'n5BaLS');
	//ĐĂNG KÍ
	function register ($user, $pass, $hoten,$ngaysinh,$email,$sdt) {
		if (isExist_email($email)) {
			return array('code' => 1,'error'=>'Email đã tồn tại');
		}
		if (isExist_taikhoan($user)) {
			return array('code' => 1,'error'=>'Tài khoản đã tồn tai');
		}
		$rand = random_int(0,1000);
		$hash = password_hash($pass, PASSWORD_DEFAULT);
		$token = md5($user.'+'.$rand);
		$sql = "insert into taikhoan(taikhoan, matkhau, hoten, ngaysinh, email,sdt,token) values(?,?,?,?,?,?,?)";
		$conn = open_db();
		$stm =$conn->prepare($sql);
		$stm->bind_param('sssssss',$user, $hash, $hoten,$ngaysinh,$email,$sdt,$token);
		if (!$stm->execute()) {
			return array('code' => 2,'error' => 'Cannot execute command');
		}
		sendActivateEmail($email,$token);
		return array('code' => 0);
	}

	//KÍCH HOẠT TÀI KHOẢN
	function activeAccount($email,$token) {
		$sql = "SELECT taikhoan From taikhoan where email =? and token = ? and is_activated = 0";
		$conn = open_db();
		$stm = $conn->prepare($sql);
		$stm->bind_param('ss',$email,$token);

		if (!$stm->execute()){
			return array('code'=>1,'error'=>'Lỗi truy vấn');
		}
		$result = $stm->get_result();
		if ($result->num_rows == 0) {
			return array('code'=>2,'error'=>'Tài khoản không tồn tại');
		}
		$sql = "UPDATE taikhoan set is_activated = 1 where email = ?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$email);
		if (!$stm->execute()){
			return array('code'=>1,'error'=>'Lỗi truy vấn');
		}
		return array('code'=>0,'msg'=>'Kích hoạt tài khoản thành công');

	}
	//KÍCH HOẠT TÀI KHOẢN VÀO LỚP HỌC
	function activeClass($malop,$matk) {
		$sql = "SELECT * From thanhvien where matk = ? and malop = ? and trangthai =1";
		$conn = open_db();
		$stm = $conn->prepare($sql);
		$stm->bind_param('is',$matk,$malop);
		if (!$stm->execute()){
			return array('code'=>1,'error'=>'Lỗi truy vấn');
		}
		$result = $stm->get_result();
		if ($result->num_rows > 0) {
			return array('code'=>2,'error'=>'Tài khoản đã tham gia lớp học');
		}
		$sql = "UPDATE thanhvien set trangthai = 1 where malop = ? and matk = ?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('si',$malop,$matk);
		if (!$stm->execute()){
			return array('code'=>1,'error'=>'Lỗi truy vấn');
		}
		return array('code'=>0,'msg'=>'Tham gia lớp thành công');

	}
	//TẠO MÃ LỚP
	function createMalop($length = 6) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[Rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	//KIỂM TRA MÃ LỚP
	function isExist_malop($malop) {
		$sql = "SELECT malop FROM lop WHERE malop= ?";
		$conn = open_db();
		$stm =$conn->prepare($sql);
		$stm->bind_param('s',$malop);
		if (!$stm->execute()) {
			die('Querry error: '.$stm->error);
		}
		$result = $stm->get_result();
		if ($result->num_rows > 0) {
			return true; //có mã lớp
		}else {
			return false;
		}
	}

	//TẠO LỚP HỌC
	function createLophoc($tenlop,$monhoc,$phonghoc,$anhdaidien,$id) {
		$malop = createMalop();
		while (isExist_malop($malop)) {
			$malop = createMalop();
		}
		$sql = "insert into lop(malop, tenlop,monhoc,phonghoc,anhdaidien,matk) values(?,?,?,?,?,?)";
		$conn = open_db();
		$stm =$conn->prepare($sql);
		$stm->bind_param('sssssi',$malop, $tenlop,$monhoc,$phonghoc,$anhdaidien,$id);
		if (!$stm->execute()) {
			echo 'Không thể thêm';
		}
		$conn->query("insert into thanhvien(malop,matk,trangthai) values('$malop',$id,1)");
		getLop($id);
	}
	//createLophoc('ttttttaaaaa','aaa','al11','',19);
	//Xóa lớp học
	function deleteClass($malop) {
		$conn = open_db();
		$sql="DELETE from lop WHERE malop = ?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$malop);
		if (!$stm->execute()) {
			return array('code' => 1,'error' => 'Cannot execute command');
		}
		$sql="DELETE from thanhvien WHERE malop = ?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$malop);
		if (!$stm->execute()) {
			return array('code' => 1,'error' => 'Cannot execute command');
		}
		getallLop();
	}

	//CẬP NHẬT THÔNG TIN LỚP
	function updateClass($malop,$tenlop,$monhoc,$phonghoc,$anhdaidien) {
		$conn = open_db();
		$sql = "UPDATE lop set tenlop = ?,monhoc = ?,phonghoc = ?,anhdaidien = ? where malop = ?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('sssss',$tenlop,$monhoc,$phonghoc,$anhdaidien,$malop);
		if (!$stm->execute()){
			return array('code'=>1,'error'=>'Không thể sửa thông tin');
		}
		getallLop();
	}
	function editClass($malop,$tenlop,$monhoc,$phonghoc) {
		$conn = open_db();
		$sql = "UPDATE lop set tenlop = ?,monhoc = ?,phonghoc = ? where malop = ?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('ssss',$tenlop,$monhoc,$phonghoc,$malop);
		if (!$stm->execute()){
			return json_encode(array('code'=>1,'error'=>'Không thể sửa thông tin'));
		}
		$sql = "SELECT * from lop where malop= ?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$malop);
		if (!$stm->execute()){
			return json_encode(array('code'=>1,'error'=>'Không thể tìm lớp'));
		}
		else {
			$result = $stm->get_result();
			$row = $result->fetch_assoc();
			echo json_encode(array('code'=>0,'Lop'=>$row));			
		}
	}
	//editClass('f9FjAP','Lập trình Website','Website','a203');
	//THAM GIA LỚP BẰNG MÃ LỚP
	function joinLophoc($malop,$matk) {
		if (checkLop($malop) && isExist_tk_class($matk,$malop) == false) {
			$sql = "insert into thanhvien(malop,matk) values(?,?)";
			$conn = open_db();
			$stm =$conn->prepare($sql);
			$stm->bind_param('si',$malop,$matk);
			if (!$stm->execute()) {
				echo 'Không thể thêm';
			}
			else {
				getLop($matk);
			}			
		}
		else if (checkLop($malop) == false){
			//1 = "Lớp không tồn tại hoặc đã bị xóa"
			echo '1';
		}
		else if (isExist_tk_class($matk,$malop) == true) {
			//2 = "Tài khoản đã tồn tại trong lớp"
			echo '2';
		}
	}
	function checkLop($malop) {
		$sql = "SELECT * from lop where malop= ?";
		$conn = open_db();
		$stm =$conn->prepare($sql);
		$stm->bind_param('s',$malop);
		if (!$stm->execute()) {
			echo 'Không thể thêm';
		}
		$result = $stm->get_result();
		$row = $result->fetch_assoc();
		if ($row['is_deleted'] == 1){
			return false;
		}
		else {
			return true;
		}
	}
	//GIẢNG VIÊN ACTIVE CHO TÀI KHOẢN VÀO LỚP
	function activeThanhvien($matk,$malop) {
		$conn = open_db();
		$sql = "UPDATE thanhvien SET trangthai = 1 WHERE matk = ?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('i',$matk);
		if (!$stm->execute()) {
			return array('code'=>1,'error'=>'Không thể kích hoạt');
		}
		//nếu mà ko gọi hàm notify thì éo lỗi
		notifyJoinclass($malop);
		//echo json_encode(array("code"=>0,"msg"=>"Kích hoạt thành công"));
	}
	//Không chấp thuận thành viên join
	function skipThanhvien($matk,$malop) {
		$conn = open_db();
		$sql = "DELETE FROM thanhvien WHERE matk = ? and malop=?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('is',$matk,$malop);
		if (!$stm->execute()) {
			return array('code'=>1,'error'=>'Không thể kích hoạt');
		}
		//nếu mà ko gọi hàm notify thì éo lỗi
		notifyJoinclass($malop);
		//echo json_encode(array("code"=>0,"msg"=>"Kích hoạt thành công"));
	}

	//THÊM THÀNH VIÊN BẰNG EMAIL
	function addClass_byEmail($email,$malop) {
		$sql = "SELECT matk From taikhoan where email = ?";
		$conn = open_db();
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$email);
		if (!$stm->execute()){
			echo 'Không thêm dc';
		}
		else if (isExist_email($email)) {
			$result = $stm->get_result();
			$ids = $result->fetch_assoc();
			$id = $ids['matk'];
			if (isExist_tk_class($id,$malop)==false) {
				$sql = "insert into thanhvien(malop,matk,trangthai) values(?,?,?)";
				$conn = open_db();
				$trangthai = 2;
				$stm =$conn->prepare($sql);
				$stm->bind_param('sii',$malop,$id,$trangthai);
				if (!$stm->execute()) {
					echo "Lỗi truy vấn";
				}
				sendEmail_activeClass($email,$malop,$id);
				echo  "Đã thêm thành viên có email:$email vào lớp học, vui lòng đợi thành viên chấp nhận lời mời";
			}
			else {
				echo $error= "Tài khoản đã có trong lớp";
			}
		}
		else {
			echo $error= "Email không có";
		}
	}
	//addClass_byEmail('trangiaky3','n5BaLS');

	function notifyJoinclass($malop) {
		$conn = open_db();
		$sql = "SELECT * from thanhvien where malop = ? and trangthai = 0";
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$malop);
		if (!$stm->execute()) {
			echo "Không thể truy vấn";
		}
		$result = $stm->get_result();
		while ($row = $result->fetch_assoc()) {
			get_mem_join($row['matk'],$malop);
		}
		//echo json_encode(array('code'=>0,'thongbao'=>$thongbao));
	}
	function get_mem_join($matk,$malop) {
		$conn = open_db();
		$sql = "SELECT * from taikhoan where matk = ? and is_deleted=0";
		$stm = $conn->prepare($sql);
		$stm->bind_param('i',$matk);
		$stm->execute();
		if (!$stm->execute()) {
			echo "lỗi truy vấn";
		}
		$result = $stm->get_result();

		$stt=0;
		while ($row = $result->fetch_assoc()) {
		?>
			<tr id="tk<?=$row['matk'] ?>">
				<td><?=$stt+=1 ?></td>
				<td><?=$row['hoten'] ?></td>
				<td><?=$row['email'] ?></td> 
				<td hidden><?=$row['matk'] ?></td>
				<td style="display: flex;">
				    <button type="button" class="btn btn-primary checkBTN" onclick="acceptSV('tk<?=$row['matk'] ?>','<?=$malop ?>')">Confirm</button>
				    <button type="button" class="btn btn-danger checkBTN" onclick="skipSV('tk<?=$row['matk'] ?>','<?=$malop ?>')">Skip</button>
				</td>             
			</tr>
		<?php
		}
	}
	//addClass_byEmail('dinhdat187199@gmail.com','f9FjAP');
	//PHÂN QUYỀN 
	function phanquyen($matk,$trangthai) {
		$conn = open_db();
		if ($trangthai != 1) {
			$trangthai =1;	
		}else {
			$trangthai =2;
		}
		$sql="UPDATE taikhoan set maquyen = ? where matk = ?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('ii',$trangthai,$matk);
		if (!$stm->execute()) {
			echo 'Cannot execute command';
		}
		getallTaikhoan();
	}
	//XÓA THÀNH VIÊN KHỎI LỚP
	function deleteMember($matk,$malop,$matk_gv) {
		$conn = open_db();
		$sql="DELETE FROM thanhvien where matk = ? && malop = ?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('is',$matk,$malop);
		if (!$stm->execute()) {
			echo 'Cannot execute command';
		}
		$sql="DELETE FROM nopbai where matk = ? && malop = ?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('is',$matk,$malop);
		if (!$stm->execute()) {
			echo 'Cannot execute command';
		}

		getSV_client($malop,$matk_gv);
	}
	//getSV_client('0oBwPo',19);
	//deleteMember(21,'0oBwPo',19);
	function deleteMember_admin($matk,$malop) {
		$conn = open_db();
		$sql="DELETE FROM thanhvien where matk = ? && malop = ?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('is',$matk,$malop);
		if (!$stm->execute()) {
			return $error= "Lỗi truy vấn";
		}
		getSV_GV($malop);
	}

	//GỬI EMAIL MỜI THAM GIA LỚP HỌC
	function sendEmail_activeClass($email,$malop,$matk) {

		// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {
		    //Server settings
		    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;  
		    $mail ->CharSet = "UTF-8";                    // Enable verbose debug output
		    $mail->isSMTP();                                            // Send using SMTP
		    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
		    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		    $mail->Username   = 'dinhdat187199@gmail.com';                     // SMTP username
		    $mail->Password   = 'zjndxyokdndfgeaz';                               // SMTP password
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

		    //Recipients
		    $mail->setFrom('dinhdat187199@gmail.com', 'Mời tham gia lớp học');
		    $mail->addAddress($email, 'Người nhận');     // Add a recipient

		    // Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = 'Mời tham gia lớp học của hệ thống TDT Classroom';
		    $mail->Body    = "Bạn được mời tham gia lớp học.Click <a href='http://localhost:8888/classroom/activeClass.php?email=$email&malop=$malop&matk=$matk'>vào đây</a> để vào lớp của bạn. <br>";
		    $mail->send();
		    echo "Đã gửi lời mời tham gia lớp học cho địa chỉ email: $email";
		} catch (Exception $e) {
		    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
	function nopbai($mabd,$matk,$malop,$bainop) {
  		$conn = open_db();
		$sql = "insert into nopbai(mabd,matk, malop, bainop) values(?,?,?,?)";
		$stm =$conn->prepare($sql);
		$stm->bind_param('iiss',$mabd,$matk,$malop,$bainop);
		if (!$stm->execute()) {
			return array('code' => 1,'error' => 'Cannot execute command');
		}
		//submitFile($mabd,$matk);
	}
	function checkSubmit($mabd,$matk) {
  		$conn = open_db();
		$sql = "select trangthai from nopbai where mabd = ? and matk =?";
		$stm =$conn->prepare($sql);
		$stm->bind_param('ii',$mabd,$matk);
		if (!$stm->execute()) {
			return array('code' => 1,'error' => 'Cannot execute command');
		}
		$result = $stm->get_result();
		if ($result->num_rows > 0) {
			return true; //có tài khoản tồn tại
		}else {
			return false;
		}
	}

	//Kiểm tra xem còn hạn hay khonng6
	function checkNgay($mabd) {
		$conn = open_db();
		$result = $conn->query("select ngaynop from baidang where mabd =".$mabd);
		$row = $result->fetch_assoc();
		$ngaynop = $row['ngaynop'];
		$ngayhientai = date("Y-m-d");
		$songay= (strtotime($ngaynop) - strtotime($ngayhientai))/86400;
		if ( $songay < 0)  {
			return false;
		}
		else {
			return true;
		}

	}
	//CONVERT NGÀY SNAG DẠNG Dec 12,2020
	function getNgay_convert($mabd) {
		$conn = open_db();
		$result = $conn->query("select ngaynop from baidang where mabd =".$mabd);
		$row = $result->fetch_assoc();
		$ngaynop = $row['ngaynop'];
		echo $day = date('M d,Y',strtotime($ngaynop));

	}

	//LẤY TO-TO
	function getTodo($malop) {
		$conn = open_db();
		$sql = "SELECT * from baidang where malop = ? and loaibd = 1";
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$malop);
		if (!$stm->execute()) {
			echo "lỗi";
			return "Lỗi truy vấn";
		}
		$result = $stm->get_result();
		while ($row = $result->fetch_assoc()) {
	   ?>
	   	<a href="detailBaidang.php?malop=<?=$malop?>&&mabd=<?=$row['mabd']?>">
	        <div class="nodue-details">
	            <div class="dueItem">
	                <h2><?=$row['tieude'] ?></h2>
	                <div class="Subject"><?=get_name_class($malop) ?></div>
	            </div>

	            <span class="deadlineTime">
	                <p class="Date"><?=getNgay_convert($row['mabd']) ?></p> 
	                <p>,</p>
	                <p class="timeDead">11:59 AM</p>
	            </span>
	        </div>		   		
	   	</a>

	    <?php
		}			
	}
	//Lấy số ngày còn hạn 
	function getNgay($mabd) {
		$conn = open_db();
		$result = $conn->query("select ngaynop from baidang where mabd =".$mabd);
		$row = $result->fetch_assoc();
		$ngaynop = $row['ngaynop'];
		$ngayhientai = date("Y-m-d");
		$songay= (strtotime($ngaynop) - strtotime($ngayhientai))/86400;
		if ( $songay < 0)  {
			echo 'Quá hạn';
		}
		else {
			echo  "Còn $songay ngày để nộp bài";
		}
	}
	function getFile_submit($mabd,$matk) {
  		$conn = open_db();
		$sql = "select bainop from nopbai where mabd = ? and matk =?";
		$stm =$conn->prepare($sql);
		$stm->bind_param('ii',$mabd,$matk);
		if (!$stm->execute()) {
			return array('code' => 1,'error' => 'Cannot execute command');
		}
		$result = $stm->get_result();
			while($row = $result->fetch_assoc()) {
			$split = explode(".", $row['bainop']);
			if ($split[1] == 'docx') {
		      $logo = '<i class="fa fa-file-word-o" style="font-size:24px"></i>';
		    }
		    else if ($split[1] == 'pptx') {
		      $logo = '<i class="fa fa-file-powerpoint-o" style="font-size:24px"></i>';
		    }
		    else if ($split[1] == 'xlxs') {
		      $logo = '<i class="fa fa-file-excel-o" style="font-size:24px"></i>';
		    }
		    else if ($split[1] == 'zip') {
		      $logo = '<i class="fa fa-file-zip-o" style="font-size:24px"></i>';
		    }
		    else if ($split[1] == 'pdf') {
		      $logo = '<i class="fa fa-file-pdf-o" style="font-size:24px"></i>';
		    }
		?>
			<li class="save-file-item">
				<a href="uploads/<?= $row['bainop']?>">
					<div class="save-file-format"><p class="format-text"><?=$logo ?></p></div>
					<div class="save-file-name text-truncate"><?= $row['bainop']?></div>
				</a>
			</li>
		<?php

		}
	}
	//Lấy file nộp cho giảng viên
	function get_all_file_nop($mabd) {
		$conn = open_db();
		$sql = "select * from nopbai where mabd = ?";
		$stm =$conn->prepare($sql);
		$stm->bind_param('i',$mabd);
		if (!$stm->execute()) {
			return array('code' => 1,'error' => 'Cannot execute command');
		}
		$result = $stm->get_result();
		while ($row = $result->fetch_assoc()) {
		?>
        <div class="card" id="submit">
            <div id="flex">
                <img src="https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/s32-c-fbw=1/photo.jpg" alt="">
                <div>
                    <h6><?=get_name_tk($row['matk'])?></h6>
                    <small><?= date('d-m-Y', strtotime($row['ngaynopbai']))?></small>
                </div>
            </div> 
            <a href="uploads/<?=$row['bainop']?>">
                <div class="itemss">
                    <div class="details">
						<i class="fa fa-download" aria-hidden="true"></i>
						<div class="text-truncate">
							<p class="mb-0" id="p"><?= $row['bainop']; ?></p>
							<p class="mb-0" id="p1">File Upload</p>
						</div>
                    </div>
                </div>
            </a>
        </div>
		<?php
		}

	}
	//Lấy file hiển thị ra thông báo
	function get_file_baidang($mabd){
		$conn = open_db();
		$sql = "select * from baidang where mabd = ?";
		$stm =$conn->prepare($sql);
		$stm->bind_param('i',$mabd);
		if (!$stm->execute()) {
			return array('code' => 1,'error' => 'Cannot execute command');
		}
		$result = $stm->get_result();
		$row = $result->fetch_assoc();
		if ($row['tepdinhkem'] != NULL) {
		?>
		<div class="file col-lg-6">
            <a class="agh" target="_blank" href="uploads/<?=$row['tepdinhkem'] ?>">
                <i class="fa fa-download" aria-hidden="true"></i>
                <div class="file-name">
                   <?=$row['tepdinhkem'] ?>
                </div>
            </a>
        </div>
		<?php
	}
	}

	//get malop theo mabd
	function getMalop($mabd) {
		$conn = open_db();
		$sql = "SELECT malop FROM baidang where mabd =?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('i',$mabd);
		if (!$stm->execute()){
			echo ("Không thể truy vấn");
			return array('code'=>'1',"msg"=>"Không thể truy vấn");
		}
		$result = $stm->get_result();
		$row = $result->fetch_assoc();
		return $row['malop'];

	}
	//Check Submit File sau đó hiển thị Ô submit 
	function submitFile($mabd,$matk) {
		if (checkSubmit($mabd,$matk)) {
		?>
		<div class="submit-title">
			<span>Bài tập</span>
			<span></span>
			<span class="status">Đã nộp</span>
		</div>
		<ul id='file-list'>
			<?=getFile_submit($mabd,$matk) ?>
		</ul>
		<div class="btn-work mt-2">
			<button type="button" disabled class="btn btn-primary btn-submit mt-3 p-2">Đã nộp</button>
		</div>
		<?php
		}
		else {
		?>
		<div class="submit-title">
			<span>Your work</span>
			<span></span>
		<?php
		if(checkNgay($mabd)==false) {
		?>
		<span class="status-false"><?=getNgay($mabd) ?></span>
		<?php
		}
		else {
		?>
		<span class="status"><?=getNgay($mabd) ?></span>
		</div>
		<form action="detailBaidang.php?mabd=<?=$mabd?>&malop=<?=getMalop($mabd)?>" method="POST" enctype="multipart/form-data">
		<div class="file-upload">
            <div class="custom-file mb-3">
                <ul hidden id='save-file-list'>
                    <li class="save-file-item">
                        <div class="save-file-format">
                            <p id="show-file-format" class="format-text"></p>
                        </div>
                        <div id="show-file-name" class="save-file-name"></div>
                        <div id="show-file-size"class="save-file-size"></div>
                    </li>
                </ul>
                
                <div class="choose-file">
                    <label class="file-upload-label" for="file">Choose file from your computer</label>
                    <input style="display: none;" type="file" id="file" name="filename_nopbai">                            
                </div>
            </div>
		</div>
		<div class="btn-work mt-2">
			<button type="submit" name="btn_nopbai" class="btn btn-primary btn-submit mt-3 p-2" >Nộp bài</button>
		</div>			
		</form>
		<?php
		}
		}
	}
	//ĐĂNG THÔNG BÁO
	function createAnnouncement($matk,$malop,$tieude,$loaibd,$noidung,$tepdinhkem,$ngaynop){
		$conn = open_db();
		$sql = "insert into baidang(matk, malop, tieude, loaibd,tepdinhkem, noidung,ngaynop) values(?,?,?,?,?,?,?)";
		$stm =$conn->prepare($sql);
		$stm->bind_param('ississs',$matk,$malop,$tieude,$loaibd,$tepdinhkem,$noidung,$ngaynop);
		if (!$stm->execute()) {
			return array('code' => 1,'error' => 'Cannot execute command');
		}
		sendMail($malop);
		//getBaidang($malop, $matk);
	}
		//SỬA BÀI ĐĂNG
	function updateAnnouncement($mabd,$tieude,$loaibd,$noidung,$tepdinhkem,$ngaynop) {
		$conn = open_db();
		$sql = "UPDATE baidang set tieude = ?,loaibd = ?,noidung = ?,tepdinhkem = ?,ngaynop = ? where mabd = ?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('sissssi',$tieude,$loaibd,$noidung,$tepdinhkem,$ngaynop,$mabd);
		if (!$stm->execute()){
			return array('code'=>1,'error'=>'Éo dc');
		}
		echo 'ok';
		return array('code'=>0,'msg'=>'oke');
	}
	//DELETE BÀI ĐĂNG
	function deleteBaidang($mabd,$malop,$matk) {
		$conn = open_db();
		$sql="DELETE From baidang where mabd = ? and malop=?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('is',$mabd,$malop);
		if (!$stm->execute()) {
			return array('code' => 1,'error' => 'Cannot execute command');
		}
		else {
			getBaidang($malop,$matk);
			return array('code' => 0,'msg' => 'Xóa bài thành công');
		}

	}
	//GET BÀI ĐĂNG CLIENT
	function getBaidang($malop,$matk) {
		$conn = open_db();
		$sql = "SELECT * FROM baidang where malop =? ORDER BY mabd DESC";
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$malop);
		if (!$stm->execute()){
			echo ("Không thể truy vấn");
		}
		$result = $stm->get_result();
		while ($row = $result->fetch_assoc()) {
			if ($row['loaibd'] == 1) {
		?>
			<div class="new-assign">
				<a href="detailBaidang.php?mabd=<?= $row['mabd']?>&malop=<?= $malop?>">
					<div class="abc">
						<i class="fa fa-list-alt" aria-hidden="true"></i>
					</div>

					<div class="dcb">
						<span class="noti"><?=get_name_GV($malop) ?> posted a new assignment: <?=$row['tieude'] ?></span>
						<span class="time"><?=$row['ngaytao'] ?></span>
					</div>
				</a>
				<?php
            	if (checkTK($matk)) {
            	?>
            	<i class="fa fa-trash" aria-hidden="true" onclick="deleteBaidang(<?=$row['mabd'] ?>,'<?= $malop?>',<?=$matk?>)"></i>
            	<?php
            	}
                ?>
			</div>
		<?php
		}
			else if ($row['loaibd'] == 0) {
		?>
            <div class="new-post">
                <div class="gdg">
                    <div class="abc">
                        <img src="https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/s40-c-fbw=1/photo.jpg" alt="">
                    </div>

                    <div class="dcb">
                        <span class="poster"><?=get_name_GV($malop) ?></span>
                        <span class="time"><?=$row['ngaytao'] ?></span>
                    </div>
                    <?php
                	if (checkTK($matk)) {
                	?>
					<i class="fa fa-trash" aria-hidden="true" onclick="deleteBaidang(<?=$row['mabd'] ?>,'<?= $malop?>',<?=$matk?>)"></i>                               	
                	<?php
                	}
                    ?>
                </div>
                <div class="post-content">
                    <p class="dfd"><?=$row['noidung'] ?></p>
                </div>

                <div class="all-files">
                    	<?=get_file_baidang($row['mabd']) ?>
                </div>
                <div class="showCmt" data-toggle="modal" data-target="#myModal3"  data-matk="<?=$matk ?>" data-mabd="<?=$row['mabd'] ?>">
                    <p><?=get_count_comment($row['mabd']) ?></p> 
                    <p>&nbsp;class comment</p> 

                </div>
                <!-- The Modal -->
            </div>
		<?php
			
			}
		}
	}

	//LẤY CHI TIẾT BÀI ĐĂNG
	function get_detail_baidang($mabd) {
		$conn = open_db();
		$sql = "SELECT * FROM baidang where mabd =?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('i',$mabd);
		if (!$stm->execute()){
			echo ("Không thể truy vấn");
		}
		$result = $stm->get_result();
		$row = $result->fetch_assoc();
		return array('code'=>0,'baidang'=>$row);
	}

	//Bình luận bài tập/thông báo
	function comment($matk,$mabd,$noidung) {
		$conn = open_db();
		$sql = "insert into binhluan(mabd,matk, noidung) values (?,?,?)";
		$stm = $conn->prepare($sql);
		$stm->bind_param('iis',$mabd,$matk,$noidung);
		if (!$stm->execute()) {
			return array('code' => 1,'error' => 'Cannot execute command');
		}
		$malop = get_malop_cmt($mabd);
		getComment($mabd,$matk);
		send_mail_comment($mabd,$matk,$malop);
	}
	//Xóa bình luận
	function deleteComment($mabd,$mabl,$matk) {
		$conn = open_db();
		$sql="DELETE From binhluan where mabl = ?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('i',$mabl);
		if (!$stm->execute()) {
			return array('code' => 1,'error' => 'Cannot execute command');
		}
		else {
			getComment($mabd,$matk);
			return array('code' => 0,'msg' => 'Xóa bài thành công');
		}

	}
	//Lấy comment
	function getComment($mabd,$matk) {
		$conn = open_db();
		$sql = "SELECT * FROM binhluan where mabd =?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('i',$mabd);
		if (!$stm->execute()){
			return array('code'=>1,'error'=>'Không thể truy vấn');
		}
		$result = $stm->get_result();
		while($row = $result->fetch_assoc()) {
		?>
		    <div class="view-cmt">
	            <div class="abc col-1 col-lg-1">
	                <img src="images/user-login.jpg" alt="">
	            </div>
		        <div class="cmt col-11 col-lg-11">
		        	<?php
		        	if (checkTK($matk)) {
		        	?>
					<i class="fa fa-times" aria-hidden="true" onclick="deleteComment(<?=$mabd?>,<?=$row['mabl']?>,<?=$matk?>)"></i>		        	
		        	<?php
		        	}
		        	?>
					<h5 class="commentator"><?=get_name_tk($row['matk']) ?></h5>
		            <p class="cmt-content"><?=$row['noidung']?></p>
		        </div>
            </div>

        <?php                              
		}
	}

	//Lấy số lượng comment 
	function get_count_comment($mabd) {
		$conn = open_db();
		$sql = "SELECT COUNT(mabl) FROM binhluan where mabd =".$mabd;
		$result = $conn->query($sql);
		$soluong = $result->fetch_assoc();
		return ($soluong['COUNT(mabl)']);

	}
	//LẤY DANH SACH THÀNH VIÊN THEO LỚP
	function get_matk($malop) {
		$matk = array();
		$conn = open_db();
		$sql = "SELECT matk from thanhvien where malop = ? and trangthai=1";
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$malop);
		if (!$stm->execute()){
			echo "Không thể truy vấn";
			return array('code'=>1,'error'=>'Không thể tìm thành viên');
		}
		$result = $stm->get_result();
		while ($row = $result->fetch_assoc()) {
			array_push($matk, $row['matk']);
		}
		$giangvien = array();
		$sinhvien = array();
		for ($i=0; $i<count($matk); $i++) {
			$sql = "SELECT * FROM taikhoan WHERE matk = " . $matk[$i];
	    	$result = $conn->query($sql);
	    	$row = $result->fetch_assoc();
	        if ($row['maquyen'] == 1) {
	        	array_push($giangvien, $row);
	        }
	        else if ($row['maquyen'] == 2) {
	        	array_push($sinhvien, $row);
	        }
	        
    	}
    	//echo json_encode(array('code'=>0,'giangvien' => $giangvien,'sinhvien'=>$sinhvien));
    	return array('code'=>0,'giangvien' => $giangvien,'sinhvien'=>$sinhvien);
	}
	function get_name_GV($malop) {
		$conn = open_db();
		$sql = "SELECT matk from lop where malop = ?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$malop);
		if (!$stm->execute()){
			echo "Không thể truy vấn";
		}
		$result = $stm->get_result();
		$row = $result->fetch_assoc();
		return get_name_tk($row['matk']);

	}
	//Lấy giaảng viên theo lớp trang admin
	function getGV($malop) {
		$result = get_matk($malop);
		$dataSV = $result['sinhvien'];
		$dataGV = $result['giangvien'];
		foreach ($dataGV as $dt) {	
		?>
			<tr>
				<td><?= $stt+=1 ?></td>
				<td><?=$dt['hoten'] ?></td>
				<td><?=$dt['ngaysinh']?></td>
				<td><?=$dt['email']?></td>
				<td><?=$dt['sdt']?></td>
				<td></td>
			</tr>
		<?php
		}
	}
	function getGV_client($malop) {
		$result = get_matk($malop);
		$dataGV = $result['giangvien'];
		foreach ($dataGV as $dt) {	
		?>
	        <div class="item-content">
	            <div class="abc">
	                <i class="fa fa-user" aria-hidden="true"></i>
	            </div>
	            <div class="item-content-title">
	                <span class="ict"><?=$dt['hoten'] ?></span>
	            </div>
	        </div>
		<?php
		}
	}

	function getSV_GV($malop) {
		?>
		<thead>
			<tr>
				<th>STT</th>
				<th>Họ tên</th>
				<th>Ngày sinh</th>
				<th>Email</th>
				<th>SĐT</th>
				<th>Xóa</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th colspan="6">Giảng viên</th>
			</tr>
			<?=getGV($malop)?>
			<tr>
				<th colspan="6">Sinh viên</th>
			</tr>
			<?=getSV($malop)?>
		</tbody>
		<?php
	}

	///LẤY BÀI ĐĂNG 
	function getBaidang_admin($malop){
		$conn = open_db();
		$sql = "SELECT * from baidang where malop = ?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$malop);
		if (!$stm->execute()){
			return array('code'=>1,'error'=>'Không thể tìm thành viên');
		}
		$result = $stm->get_result();
		$stt=0;
		while ($row = $result->fetch_assoc()) {
			$loaibd = ($row['loaibd'] == 1) ? 'Thông báo' : 'Bài tập';
		?>
			<tr>
				<td><?=$stt+=1?></td>
				<td><?=$row['tieude'] ?></td>
				<td><?=$loaibd ?></td>
				<td><?=$row['ngaytao'] ?></td>
				<td><?=get_name_tk($row['matk']) ?></td>
				<td><button type="button" class="btn btn-danger" onclick="deleteBaidang_admin(<?=$row['mabd'] ?>,'<?=$malop ?>')">Xóa</button></td>                       
			</tr>
		<?php
		}
	}
	function deleteBaidang_admin($mabd,$malop) {
		$conn = open_db();
		$sql="DELETE From baidang where mabd = ? and malop=?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('is',$mabd,$malop);
		if (!$stm->execute()) {
			return array('code' => 1,'error' => 'Cannot execute command');
		}
		else {
			getBaidang_admin($malop);
			return array('code' => 0,'msg' => 'Xóa bài thành công');
		}

	}
	//Lấy sinh viên theo lớp trang admin
	function getSV($malop) {
		$result = get_matk($malop);
		$dataSV = $result['sinhvien'];
		$dataGV = $result['giangvien'];
		foreach ($dataSV as $dt) {	
		?>
			<tr>
				<td class="stt"><?= $stt+=1 ?></td>
				<td><?=$dt['hoten'] ?></td>
				<td><?=$dt['ngaysinh']?></td>
				<td><?=$dt['email']?></td>
				<td><?=$dt['sdt']?></td>
				<td><button type="button" class="btn btn-danger" onclick="deleteMember_admin(<?=$dt['matk'] ?>,'<?=$malop ?>')">Xóa</button></td>                       

			</tr>
		<?php
		}
	}
	function checkTK($matk) {
		$conn = open_db();
		$sql = "SELECT * FROM taikhoan where matk =?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('i',$matk);
		if (!$stm->execute()){
			return array('code'=>1,'error'=>'Không thể tìm lớp học');
		}
		$result = $stm->get_result();
		$row = $result->fetch_assoc();
		if($row['maquyen'] == 1) {
			//Là giáo viên
			return true;
		}
		return false;
	}
	//notifyJoinclass('0oBwPo');
	//LẤY SINH VIÊN CLIENT
	function getSV_client($malop,$matk) {
		$result = get_matk($malop);
		$dataSV = $result['sinhvien'];
		foreach ($dataSV as $dt) {	
		?>
			<div class="item-content">
	            <div class="abc">
	                <i class="fa fa-user" aria-hidden="true"></i>
	            </div>
	            <div class="item-content-title">
	                <span class="ict"><?=$dt['hoten'] ?></span>
				</div>
				<?php
				if (checkTK($matk) == TRUE) {
				?>
				<i class="fa fa-ellipsis-v" aria-hidden="true" onclick = "showDelete('tk<?=$dt['matk'] ?>')">
					<div id="tk<?=$dt['matk'] ?>" class="deletePeople" onclick="deleteSV(this.id,'<?=$malop ?>',<?=$matk?>)">
						Remove
					</div>
				</i>				
				<?php
				}
				?>

	        </div>
		<?php
		}
	}
	//getSV('f9FjAP');
	//Lấy số lượng lớp
	function get_ds_Lop($matk) {
		$conn = open_db();
		$sql = "SELECT malop FROM thanhvien where matk =? and trangthai=1";
		$stm = $conn->prepare($sql);
		$stm->bind_param('i',$matk);
		if (!$stm->execute()){
			return array('code'=>1,'error'=>'Không thể tìm lớp học');
		}
		$result = $stm->get_result();
		$malop = array();
		while ($row = $result->fetch_assoc()) {
			array_push($malop, $row['malop']);
		}
		$lop = array();
		for ($i=0; $i<count($malop); $i++) {
	        $sql = "SELECT * FROM lop WHERE is_deleted = 0 and malop ='$malop[$i]'";
	        $result = $conn->query($sql);
	        $row = $result->fetch_assoc();
	       	if (!empty($row)){
	        	array_push($lop, $row);	 
	        }
	    }
	    if ($lop == NUll) {
	    	return array('code'=>1,'error'=>'Bạn chưa tham gia lớp học nào');
	    }
	    else {
	    	//echo json_encode(array('code'=>0,'lop' => $lop));
	    	return array('code'=>0,'lop' => $lop);
	    }
	}
	//LẤY DANH SÁCH LỚP theo tài khoản
	function getLop($matk) {
		$conn = open_db();
		$sql = "SELECT * FROM thanhvien where matk =?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('i',$matk);
		if (!$stm->execute()){
			return array('code'=>1,'error'=>'Không thể tìm lớp học');
		}
		$result = $stm->get_result();
		$malop = array();
		while ($row = $result->fetch_assoc()) {
			array_push($malop, $row['malop']);
		}
		$lop = array();
		for ($i=0; $i<count($malop); $i++) {
	        $sql = "SELECT * FROM lop WHERE is_deleted = 0 and malop ='$malop[$i]'";
	        $result = $conn->query($sql);
	        $row = $result->fetch_assoc();
	        if (!empty($row)){
	        	array_push($lop, $row);	 
	    ?>
	    		<div class="col-md-6 col-12 col-lg-3">
					<div class="card">
						<div class="card-title">
							<p class="className text-truncate"><?=$row['tenlop'] ?></p>
							<div class="avtImg">
								<img src="images/user-login.jpg" alt="">
							</div>
						</div>
						<div class="card-body">
						</div>
						<div class="card-footer">
							<div class="footer-name">
								<p class="lecturersName"><?=get_name_GV($row['malop']);?></p>
							</div>
							<div class="footer-content">
							<?php
							if (checkTK_lop($matk,$row['malop']) == '1') {
							?>
								<a href="class.php?malop=<?=$row['malop']?>"><button type="button" class="btn btn-primary">Vào lớp</button></a>
							<?php
							}
							else if (checkTK_lop($matk,$row['malop']) == '2') {
							?>
							<button type="button" class="btn btn-danger">Kiểm tra mail</button>
							<?php
							}
							else {
							?>
							<button type="button" class="btn btn-danger">Đợi</button>
							<?php
							}
							?>
		
							</div>
						</div>
					</div>
				</div>
	    <?php
	    }       	
	        }
	        //print_r($row);
	}//getLop(19);

	function checkTK_lop($matk,$malop) {
		$conn = open_db();
		$sql = "SELECT * FROM thanhvien where matk =? and malop = ?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('is',$matk,$malop);
		if (!$stm->execute()){
			return array('code'=>1,'error'=>'Không thể truy vấn');
		}
		$result = $stm->get_result();
		$row = $result->fetch_assoc();
		if($row['trangthai'] == 1) {
			return '1';
		}
		else if ($row['trangthai'] == 2) {
			return '2';
		}
		return '0';
	}

	//Hiển thị tên giáo viên
	function get_name_tk($matk) {
		$conn = open_db();
		$sql = "SELECT hoten FROM taikhoan where matk =?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('i',$matk);
		if (!$stm->execute()){
			return array('code'=>1,'error'=>'Không  tìm tên giảng viên');
		}
		$result = $stm->get_result();
		$row = $result->fetch_assoc();
		return $row['hoten'];
	}
	//get_mem_join(19);
	//notifyJoinclass('f9FjAP');


	//Hiển thị lớp cho admin
	function getallLop() {
		$conn = open_db();
		$sql = "SELECT * FROM lop where is_deleted=0";
		$result = $conn->query($sql);
		$stt = 0;
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
			?>
				<tr class="dslop" data-toggle="collapse" data-target="#tk<?=$row['malop'] ?>">
					<td><i class="fa fa-caret-down" aria-hidden="true"></i></td>
					<td><?=$stt+=1 ?></td>
					<td><?=$row['tenlop'] ?></td>
					<td><?=$row['monhoc'] ?></td>
					<td><?=$row['phonghoc'] ?></td>  
					<td><?=get_name_tk($row['matk']) ?></td>
					<td><a href="quanlyLop.php?malop=<?=$row['malop']?>">Chi tiết</a></td>
					<td> <button type="button" class="btn btn-danger" onclick="deleteClass('<?=$row['malop'] ?>')">Xóa</button></td>                
				</tr>
		        <tr id="tk<?=$row['malop']?>" class="collapse chitiet">
	                  <td colspan="9">
	                  	<div colspan="9"><strong>Thông tin tài khoản</strong></div>
	                    <div class="row">
	                      <div class="col-6">
	                        <div class="form-group">
	                          <label for="hoten">Tên lớp:</label>
	                          <input type="text" class="form-control" id="tenlop<?=$row['malop'] ?>" value="<?=$row['tenlop'] ?>" name="tenlop">
	                        </div>
	                      </div>
	                      <div class="col-6">
	                        <div class="form-group">
	                          <label for="mon">Môn học:</label>
	                          <input type="text" class="form-control" id="monhoc<?=$row['malop'] ?>" value="<?=$row['monhoc'] ?>" name="subject">
	                        </div>
	                      </div>
	                      <div class="col-6">
	                        <div class="form-group">
	                          <label for="mon">Phòng học:</label>
	                          <input type="text" class="form-control" id="phonghoc<?=$row['malop'] ?>" value="<?=$row['phonghoc'] ?>" name="room-num">
	                        </div>
	                      </div>
	                      <div class="col-6">
	                        <div class="form-group">
	                          <label for="file">Ảnh đại diện</label>
	                          <div class="custom-file mb-3">
	                            <input onchange="getfile(this.id)" type="file" class="custom-file-input" id="<?=$row['malop'] ?>" name="filename" multiple accept="image/*"/>
	                            <label class="custom-file-label" id="file<?=$row['malop']?>" for="customFile">Choose file</label>
	                          </div>                                
	                        </div>
	                      </div>
	                      <div id="show-error" hidden>
	                      	<div id="msg-error" class="alert alert-danger"></div>
	                      </div>
	                      <div class="col-12">
	                        <button type="button" onclick="updateLop('<?=$row['malop'] ?>')" class="btn btn-primary mt-3">Chỉnh sửa</button>                 	
	                      </div>
	                  </td>                        
                </tr>
			<?php	
			}
		}
	}

	//Hiển thị tài khoản cho admin
	function getallTaikhoan() {
		$conn = open_db();
		$sql = "SELECT * FROM taikhoan where maquyen != 0 and is_deleted=0";
		$result = $conn->query($sql);
		$taikhoan = array();
		$stt = 0;
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$is_admin = ($row['maquyen'] == 1) ? 'Giáo viên' : 'Sinh viên';
				$is_active = ($row['is_activated'] == 1) ? 'Actived' : 'non-Active';
			?>
			<tr>
                <td><?=$stt +=1 ?></td>
                <td><?=$row['taikhoan'] ?></td>
                <td><?=$is_admin ?></td>
                <td><?=$row['hoten'] ?></td>
                <td><?=$row['ngaysinh'] ?></td>
                <td><?=$row['email'] ?></td>
                <td>0<?= $row['sdt']?></td>
                <td><?= $is_active?></td>  
                <td><button type="button" class="btn btn-danger" onclick="phanquyen(<?=$row['matk'] ?>,<?=$row['maquyen'] ?>)"><?=$is_admin ?></button></td> 
            </tr>                 
			<?php
			}
		}
	}

	//Hiển thị số lượng TK
	function getamountTk(){
		$conn = open_db();
		$sql = "SELECT COUNT(matk) FROM taikhoan where maquyen != 0 and is_deleted=0";
		$result = $conn->query($sql);
		$soluong = $result->fetch_assoc();
		return ($soluong['COUNT(matk)']);
	}

	//Hiển thị số lượng lóp
	function getamountClass(){
		$conn = open_db();
		$sql = "SELECT COUNT(malop) FROM lop where is_deleted=0";
		$result = $conn->query($sql);
		$soluong = $result->fetch_assoc();
		echo ($soluong['COUNT(malop)']);
	}
	//Hiển thị tên lớp
	function get_name_class($malop) {
		$conn = open_db();
		$sql = "SELECT tenlop FROM lop where malop = ? and is_deleted=0";
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$malop);
		$stm->execute();
		if (!$stm->execute()) {
			echo "lỗi";
			return $error="Lỗi";
		}
		$result = $stm->get_result();
		$row = $result->fetch_assoc();
		echo ($row['tenlop']);
	}
	//Hine6 thị các assingment
	function getAssignment($malop) {
		$conn = open_db();
		$sql = "SELECT * from baidang where malop = ? and loaibd = 1";
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$malop);
		if (!$stm->execute()) {
			echo "lỗi";
			return "Lỗi truy vấn";
		}
		$result = $stm->get_result();
		while ($row = $result->fetch_assoc()) {
			if (checkNgay($row['mabd']) == true) {
	   ?>
	   	<a href="detailBaidang.php?mabd=<?=$row['mabd']?>&malop=<?=$row['malop'] ?>">
            <div class="item-content">
                <div class="abc">
                    <i class="fa fa-book" aria-hidden="true"></i>
                </div>
                <div class="item-content-title">
                    <span class="ict"><?=$row['tieude'] ?></span>
                </div>
                <div class="item-content-time">Posted <?=$row['ngaytao'] ?></div>
            </div>
        </a>
	   <?php
	}
		}
	}
	function getAssignment_index($malop) {
		$conn = open_db();
		$sql = "SELECT * from baidang where malop = ? and loaibd = 1";
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$malop);
		if (!$stm->execute()) {
			echo "lỗi";
			return "Lỗi truy vấn";
		}
		$result = $stm->get_result();
		while ($row = $result->fetch_assoc()) {
			if (checkNgay($row['mabd']) == true) {
	   ?>
            <div class="item-content">
                <div class="item-content-title">
                    <span class="ict"><?=$row['tieude'] ?></span>
                </div>
                <div class="item-content-time"><Strong>Due</Strong> <?=getNgay_convert($row['mabd'])?></div>
            </div>
        </a>
	   <?php
	}
		}
	}
	function getDeadline($malop) {
		$conn = open_db();
		$sql = "SELECT * from baidang where malop = ? and loaibd = 1";
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$malop);
		if (!$stm->execute()) {
			echo "lỗi";
			return "Lỗi truy vấn";
		}
		$result = $stm->get_result();
		while ($row = $result->fetch_assoc()) {
	   ?>
	        <h2 class="upcoming"><STRONG><?=$row['tieude']?></STRONG></h2>
            <span class="due-date"><?=getNgay($row['mabd'])?></span>
	   <?php
		}	
	}

	//mới them
	//Hiển thị môn học
	function get_subject_class($malop) {
		$conn = open_db();
		$sql = "SELECT monhoc FROM lop where malop = ? and is_deleted=0";
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$malop);
		$stm->execute();
		if (!$stm->execute()) {
			echo "lỗi";
			return $error="Lỗi";
		}
		$result = $stm->get_result();
		$row = $result->fetch_assoc();
		echo ($row['monhoc']);
	}

	//Hiển thị phòng học
	function get_room_class($malop) {
		$conn = open_db();
		$sql = "SELECT phonghoc FROM lop where malop = ? and is_deleted=0";
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$malop);
		$stm->execute();
		if (!$stm->execute()) {
			echo "lỗi";
			return $error="Lỗi";
		}
		$result = $stm->get_result();
		$row = $result->fetch_assoc();
		echo ($row['phonghoc']);
	}
	//GỬI MAIL LÚC THÔNG BÁO
	function get_mail($matk) {
		$conn = open_db();
		$sql = "SELECT email from taikhoan where matk = ? and is_activated=1";
		$stm = $conn->prepare($sql);
		$stm->bind_param('i',$matk);
		if (!$stm->execute()){
			echo "Không thể truy vấn";
			return array('code'=>1,'error'=>'Không thể tìm thành viên');
		}
		$result = $stm->get_result();
		$row = $result->fetch_assoc();
		return $row['email'];
	}
	function sendMail($malop) {
		$to =array();
		$conn = open_db();
		$sql = "SELECT matk from thanhvien where malop = ? and trangthai = 1";
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$malop);
		if (!$stm->execute()){
			echo "Không thể truy vấn";
			return array('code'=>1,'error'=>'Không thể tìm thành viên');
		}
		$result = $stm->get_result();
		while ($row = $result->fetch_assoc()) {
			// echo $row["matk"]."\n"; 
			$email = get_mail($row['matk']);
		    array_push($to, $email);
		} 
		$name = get_name_GV($malop);
		sendEmail_baidang($to,$name,$malop);
	}
	function get_malop_cmt($mabd) {
		$conn = open_db();
		$sql = "SELECT malop from baidang where mabd = ?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('i',$mabd);
		if (!$stm->execute()){
			echo "Không thể truy vấn";
			return array('code'=>1,'error'=>'Không thể tìm thành viên');
		}
		$result = $stm->get_result();
		$row = $result->fetch_assoc();
		return $row['malop'];
	}
	function get_matk_bd($mabd) {
		$conn = open_db();
		$sql = "SELECT matk from baidang where mabd = ?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('i',$mabd);
		if (!$stm->execute()){
			echo "Không thể truy vấn";
			return array('code'=>1,'error'=>'Không thể tìm thành viên');
		}
		$result = $stm->get_result();
		$row = $result->fetch_assoc();
		if ($row->num_rows > 0) {
			return $row['matk'];			
		}
		else{
			return null;
		}
	}
	function send_mail_comment($mabd,$matk,$malop) {
		$to =array();
		$conn = open_db();
		$sql = "SELECT matk from binhluan where mabd = ?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('i',$mabd);
		if (!$stm->execute()){
			echo "Không thể truy vấn";
			return array('code'=>1,'error'=>'Không thể tìm thành viên');
		}
		$result = $stm->get_result();
		while ($row = $result->fetch_assoc()) {
			// echo $row["matk"]."\n"; 
			$email = get_mail($row['matk']);
		    array_push($to, $email);
		} 
		$name = get_name_tk($matk);
		sendEmail_comment($to,$name,$malop);
	}
	function sendEmail_comment($to,$name,$malop) {
		$mail = new PHPMailer(true);
		try {
		    //Server settings
		    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;  
		    $mail ->CharSet = "UTF-8";                    // Enable verbose debug output
		    $mail->isSMTP();                                            // Send using SMTP
		    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
		    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		    $mail->Username   = '';                     // SMTP username
		    $mail->Password   = '';                               // SMTP password
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
		    //Recipients
		    $mail->setFrom('dinhdat187199@gmail.com', '[Accnouncement]');
		    foreach ($to as $to_send) {
		    	$mail->addAddress($to_send,'Classroom Mail');     // Add a recipient
		    }
	    	$mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = 'Một thành viên đã bình luận về bài viết mà bạn quan tâm';
		    $mail->Body    = "<p><h2>$name vừa bình luận, nhấn để xem</h2></p></br><a href='http://localhost:8888/classroom/class.php?malop=$malop'><button>Xem</button></a>";
		    $mail->send();
		} catch (Exception $e) {
		    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
		//GỬI MAIL KÍCH HOẠT TÀI KHOẢN
	function sendActivateEmail($email, $token) {

		// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {
		    //Server settings
		    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
		    $mail ->CharSet = "UTF-8";                      // Enable verbose debug output
		    $mail->isSMTP();                                            // Send using SMTP
		    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
		    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		    $mail->Username   = '';                     // SMTP username
		    $mail->Password   = '';                               // SMTP password
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

		    //Recipients
		    $mail->setFrom('dinhdat187199@gmail.com', 'Test Feature Mail');
		    $mail->addAddress($email, 'Người nhận');     // Add a recipient
		    // Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = 'Active Email';
		    $mail->Body    = "<h2 class='h2' style='color: orange;margin-bottom: 20px;'>TDT Classroom</h2><h3 class='h3' style='font-size: 20px;'>Hi there,</h3><p>Cám ơn vì đã sử dụng dịch vụ của chúng tôi,bạn cần xác thực tại khoản của mình bằng cách nhấn vào nút dưới đây.<br><a style='color: orange;text-decoration: none;' href=''>TDT Classroom</a> account</p><a href='http://localhost:8888/classroom/active.php?email=$email&token=$token'><button type='submit' class='btn btn-primary' style='margin-top: 20px;background: green;border: none;font-size: 18px;ont-weight: 500;box-shadow: 5px 5px 15px #4399c14d;'>Verify your email address</button></a><p>Thanks</p><img style='width: 60px;height: 60px;object-fit: contain;' src='https://seeklogo.net/wp-content/uploads/2020/09/google-classroom-logo.png' alt=''>";
		    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		    $mail->send();
		    
		} catch (Exception $e) {
		    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}

	}
	function sendEmail_baidang($to,$name,$malop) {
		$mail = new PHPMailer(true);
		try {
		    //Server settings
		    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;  
		    $mail ->CharSet = "UTF-8";                    // Enable verbose debug output
		    $mail->isSMTP();                                            // Send using SMTP
		    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
		    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		    $mail->Username   = '';                     // SMTP username
		    $mail->Password   = '';                               // SMTP password
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
		    //Recipients
		    $mail->setFrom('dinhdat187199@gmail.com', 'Classroom Accnouncement');
		    foreach ($to as $to_send) {
		    	$mail->addAddress($to_send);     // Add a recipient
		    }
	    	$mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = 'New announcement: "[Thông báo]';
		    $mail->Body    = "<h3>$name vừa đăng một thông báo</h3></br><a href='http://localhost:8888/classroom/class.php?malop=$malop'><button>Xem</button></a>";
		    $mail->send();
		} catch (Exception $e) {
		    return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}" ;
		}
	}
?>