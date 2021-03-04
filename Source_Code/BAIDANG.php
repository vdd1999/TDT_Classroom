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

		if (isset($_POST['tieude'])) {
			$tieude = $_POST['tieude'];
		}

		if (isset($_POST['loaibd'])) {
			$loaibd = $_POST['loaibd'];
		}

		if (isset($_POST['noidung'])) {
			$noidung = $_POST['noidung'];
		}

		if (isset($_POST['tepdinhkem'])) {
			$tepdinhkem = $_POST['tepdinhkem'];
		}

		if (isset($_POST['bainop'])) {
			$bainop = $_POST['bainop'];
		}

		if (isset($_POST['matk'])) {
			$matk = $_POST['matk'];
		}

		if (isset($_POST['mabd'])) {
			$mabd = $_POST['mabd'];
		}

		if (isset($_POST['mabl'])) {
			$mabl = $_POST['mabl'];
		}

		if (isset($_POST['ngaynop'])) {
			$ngaynop = $_POST['ngaynop'];
		}
		if ($action == 'getComment') {
			getComment($mabd,$matk);
		}
		if ($action == 'createAnnouncement'){
			createAnnouncement($matk,$malop,$tieude,$loaibd,$noidung,$tepdinhkem,$ngaynop);
		}
		if ($action == 'comment') {
			comment($matk,$mabd,$noidung);
		}
		if ($action == 'deleteComment') {
			deleteComment($mabd,$mabl,$matk);
		}
		if ($action == 'updateAnnouncement') {
			//echo $mabd." ".$tieude." ".$loaibd." ".$noidung." ".$tepdinhkem." ".$ngaynop." ".$bainop;
			updateAnnouncement($mabd,$tieude,$loaibd,$noidung,$tepdinhkem,$ngaynop);
		}
		if ($action == 'nopbai') {
			nopbai($mabd,$matk,$malop,$bainop);
		}
		if ($action == 'deleteBaidang_admin') {
			deleteBaidang_admin($mabd,$malop);
		}

	}
?>