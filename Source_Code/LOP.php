<?php
	require_once('conn.php');
	if (isset($_POST['action'])) {
		$action = $_POST['action'];
		
		if (isset($_POST['email'])) {
			$email = $_POST['email'];
		}

		if (isset($_POST['malop'])) {
			$malop = $_POST['malop'];
		}

		if (isset($_POST['tenlop'])) {
			$tenlop = $_POST['tenlop'];
		}

		if (isset($_POST['monhoc'])) {
			$monhoc = $_POST['monhoc'];
		}

		if (isset($_POST['phonghoc'])) {
			$phonghoc = $_POST['phonghoc'];
		}

		if (isset($_POST['anhdaidien'])) {
			$anhdaidien = $_POST['anhdaidien'];
		}
		if (isset($_POST['trangthai'])) {
			$trangthai = $_POST['trangthai'];
		}
		if (isset($_POST['matk'])) {
			$matk = $_POST['matk'];
		}
		if (isset($_POST['matk_gv'])){
			$matk_gv = $_POST['matk_gv'];
		}
		if (isset($_POST['mabd'])){
			$mabd= $_POST['mabd'];
		}

		
		
		
		if ($action == 'addClassbyEmail') {
			addClass_byEmail($email,$malop);
		}
		if ($action == 'phanquyen') {
			phanquyen($matk,$trangthai);
		}
		if ($action == 'createLophoc') {
			createLophoc($tenlop,$monhoc,$phonghoc,$anhdaidien,$matk);
		}
		if ($action == 'joinLophoc') {
			joinLophoc($malop,$matk);
		}
		if ($action == 'activeThanhvien') {
			$result = activeThanhvien($matk,$malop);
		}
		if ($action == 'skipThanhvien') {
			$result = skipThanhvien($matk,$malop);
		}
		if ($action == 'deleteMember') {
			$result = deleteMember($matk,$malop,$matk_gv);
		}
		if($action == 'deleteMember_admin'){
			deleteMember_admin($matk,$malop);
		}
		if ($action == 'getLop') {
			getLop($matk);
		}
		if ($action == 'getMember') {
			getMember($malop);
		}
		if ($action == 'deleteClass') {
			deleteClass($malop);
		}
		if ($action == 'updateClass') {
			updateClass($malop,$tenlop,$monhoc,$phonghoc,$anhdaidien);
		}
		if ($action == 'editClass') {
			editClass($malop,$tenlop,$monhoc,$phonghoc);
		}
		if ($action == 'deleteComment') {
			deleteComment($mabd,$malop);
		}	
		if ($action == 'deleteBaidang') {
			deleteBaidang($mabd,$malop,$matk);
		}
	}
?>