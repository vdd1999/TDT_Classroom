-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:8889
-- Thời gian đã tạo: Th12 02, 2020 lúc 10:07 PM
-- Phiên bản máy phục vụ: 5.7.26
-- Phiên bản PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Cơ sở dữ liệu: `classroom`
--
CREATE DATABASE IF NOT EXISTS `classroom` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `classroom`;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `baidang`
--

CREATE TABLE `baidang` (
  `mabd` int(5) NOT NULL,
  `matk` int(5) NOT NULL,
  `malop` varchar(6) NOT NULL,
  `tieude` varchar(100) DEFAULT NULL,
  `loaibd` bit(1) DEFAULT b'0',
  `noidung` varchar(20000) DEFAULT NULL,
  `tepdinhkem` varchar(100) DEFAULT NULL,
  `ngaytao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ngaynop` date DEFAULT NULL,
  `bainop` varchar(100) DEFAULT NULL,
  `is_deleted` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `baidang`
--

INSERT INTO `baidang` (`mabd`, `matk`, `malop`, `tieude`, `loaibd`, `noidung`, `tepdinhkem`, `ngaytao`, `ngaynop`, `bainop`, `is_deleted`) VALUES
(20, 19, 'f9FjAP', '', b'0', 'xin chào', 'midterm.png', '2020-12-02 15:00:10', NULL, NULL, b'0'),
(21, 19, 'f9FjAP', 'BTL', b'1', 'Làm theo nội dung như thế này:\r\nnén file zip\r\nnén tất cả vào 1 file', 'iphone-11-pro-max-256gb-black-400x400.jpg', '2020-12-02 15:17:16', '2020-12-11', NULL, b'0'),
(24, 19, '0QyigO', 'BTL CNPM', b'1', 'Nop bai tap lon tai day', 'midterm.png', '2020-12-02 16:02:28', '2020-12-20', NULL, b'0'),
(25, 19, '0QyigO', 'BTVN', b'1', 'Nộp BTVN tại đây', NULL, '2020-12-02 16:11:38', '2020-12-03', NULL, b'0');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `binhluan`
--

CREATE TABLE `binhluan` (
  `mabl` int(5) NOT NULL,
  `mabd` int(5) NOT NULL,
  `matk` int(5) NOT NULL,
  `noidung` varchar(1000) NOT NULL,
  `is_deleted` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `binhluan`
--

INSERT INTO `binhluan` (`mabl`, `mabd`, `matk`, `noidung`, `is_deleted`) VALUES
(9, 20, 19, 'chào thầy', b'0'),
(10, 20, 31, 'chào thầy', b'0'),
(11, 21, 19, 'các em nhớ làm bai nhé', b'0'),
(12, 21, 31, 'khong lam co bi gi khong thay?', b'0'),
(13, 20, 31, 'em ten la Dat09', b'0'),
(14, 20, 31, 'a khong em lon ten', b'0'),
(15, 24, 31, 'khong cho nut go bai ha :v', b'0'),
(16, 24, 31, '\nkhông', b'0'),
(17, 24, 31, '\nnộp là nộp luôn', b'0'),
(18, 24, 31, '\n:))))))))))))))))))', b'0');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lop`
--

CREATE TABLE `lop` (
  `malop` varchar(6) NOT NULL,
  `tenlop` varchar(100) NOT NULL,
  `monhoc` varchar(200) NOT NULL,
  `phonghoc` varchar(50) NOT NULL,
  `anhdaidien` varchar(200) DEFAULT NULL,
  `ngaytao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `matk` int(5) NOT NULL,
  `is_deleted` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `lop`
--

INSERT INTO `lop` (`malop`, `tenlop`, `monhoc`, `phonghoc`, `anhdaidien`, `ngaytao`, `matk`, `is_deleted`) VALUES
('0QyigO', 'CNPM', 'CONG NGHE PHAN MEM', 'aaaaaaaa', NULL, '2020-11-25 10:45:19', 19, b'0'),
('f9FjAP', 'Lập trình web', 'cntt', 'a22', NULL, '2020-11-21 16:30:35', 19, b'0'),
('wO2Grn', 'Tư Tưởng Hồ Chí Minh', 'Tư Tưởng', 'A0392', 'xiaomi-redmi-9-114620-094644-400x400.jpg', '2020-12-02 15:24:52', 19, b'0');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nopbai`
--

CREATE TABLE `nopbai` (
  `mabd` int(5) NOT NULL,
  `matk` int(5) NOT NULL,
  `malop` varchar(6) NOT NULL,
  `bainop` varchar(100) NOT NULL,
  `ngaynopbai` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `trangthai` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `nopbai`
--

INSERT INTO `nopbai` (`mabd`, `matk`, `malop`, `bainop`, `ngaynopbai`, `trangthai`) VALUES
(21, 31, 'f9FjAP', 'Project cuoi mon .pdf', '2020-12-02 15:17:49', b'1'),
(24, 6, '0QyigO', 'gui.py', '2020-12-02 16:04:16', b'1'),
(25, 6, '0QyigO', 'id15500525_classroom.txt.zip', '2020-12-02 16:11:55', b'1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quyen`
--

CREATE TABLE `quyen` (
  `maquyen` int(1) NOT NULL,
  `tenquyen` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `quyen`
--

INSERT INTO `quyen` (`maquyen`, `tenquyen`) VALUES
(0, 'Admin'),
(1, 'Giáo viên'),
(2, 'Học viên');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taikhoan`
--

CREATE TABLE `taikhoan` (
  `matk` int(5) NOT NULL,
  `taikhoan` varchar(50) NOT NULL,
  `matkhau` varchar(200) NOT NULL,
  `hoten` varchar(50) NOT NULL,
  `ngaysinh` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `sdt` int(11) NOT NULL,
  `token` varchar(32) NOT NULL,
  `is_activated` bit(1) NOT NULL DEFAULT b'0',
  `maquyen` int(1) DEFAULT '2',
  `is_deleted` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `taikhoan`
--

INSERT INTO `taikhoan` (`matk`, `taikhoan`, `matkhau`, `hoten`, `ngaysinh`, `email`, `sdt`, `token`, `is_activated`, `maquyen`, `is_deleted`) VALUES
(6, 'admin', '$2y$10$oNbY/pTmSb43ruG6LEGCq.WnI0tStxf0kCg0pmLU6l1tYvDEGGyli', 'Vũ Đạt', '2020-11-11', 'dinhdat187199@gmail.com', 868369514, 'df70cda0e72de85fa0d6912b286ef584', b'1', 0, b'0'),
(19, 'chinhnghia', '$2y$10$q9Lz5sSHF/FgIrX3GGTpj.kiPjf2W.WwvClqLMYt4WOUCHV0oE3RW', 'Chính Nghĩa', '1999-09-02', 'maxfixe258369@gmail.com', 921029102, 'b52cc2595675db620af23bbd6374bb70', b'1', 1, b'0'),
(20, 'giaky', '$2y$10$yC5.NBK5zvpWPepzyRctpuj0VrcPqAKaf5xhmZdw4b4NBAhTZmrya', 'Gia Kỳ', '1999-12-02', 'trangiaky2@gmail.com', 929193821, 'd19c8cdea3e1b57679867422940d2718', b'1', 2, b'0'),
(21, 'giaky3', '$2y$10$p3bvmuSRfI2EklkY4eaGG.o3F9SrkoIGa2AaMDwAkdeQP5X9w4K5q', 'Gia Kỳ Trần3', '1999-06-02', 'trangiaky3@gmail.com', 192109201, 'a8bf6d8a871da6380cea957466d133e2', b'1', 1, b'0'),
(22, 'giaky4', '$2y$10$w6DcH34G5YyhU69s6ybj5Orefxl1yvozagEl4043GePs1yesiA/Z6', 'Gia Kỳ Trần Kỳ', '1999-06-20', 'trangiaky24121999@gmail.com', 192109201, 'acfe9d40962a7fe40c52243416c29f0d', b'1', 2, b'0'),
(26, 'minhhai99', '$2y$10$kgGLi254JA.FfXo7d41sa.8TY6aqXPRqI1PzVO.YF03gROlAYrWN2', 'Nguyễn Minh Hải', '2020-11-26', 'xtrang2106@gmail.com', 367896503, '72e5c7bd294cbeedbec89f70791ab3e4', b'1', 2, b'0'),
(27, 'Chanchan', '$2y$10$hpqGNSuLeag5n/mwa0/ssuKF.NsYbt66q0zDXQdxU6dPTBZQz612G', 'Nguyễn Ngọc Thuỳ Trang', '1999-01-25', 'nntt25199@gmail.com', 792224571, '98c8fc8e849dd67302be556ef87a0022', b'1', 2, b'0'),
(28, 'hnam7999', '$2y$10$BHXmr2D5WNG5h8bc/nKhG.DtKKoBjycCZ38nrsxMb4zNadrfehonq', 'Hoàng Nam', '1995-09-07', 'hnam7999@gmail.com', 973051902, 'fc64568c91d33a19541552bfacbed89c', b'1', 2, b'0'),
(29, 'duyle2499', '$2y$10$/A4fxeBd7HWOBOLDUvVa4uHpSE2ETEi5oLq8X6pOSEQUfrAZs4Osa', 'Duy Lê', '1999-04-02', 'toilatoi@gmail.com', 775981234, '7d1c337a309127dd732930e4f3336c44', b'1', 2, b'0'),
(30, 'giahoang', '$2y$10$rT/tsbAhXDLT1ctVL54rTerPmfLqjCYClxnfREwlTEbw4bINccy4.', 'giahoang', '1999-12-02', 'gianuazaj.69@gmail.com', 910219021, '64ea4958a6a8dca3fb67805db5d3c524', b'1', 2, b'0'),
(31, 'minhhai', '$2y$10$HHIqknUqP3lAK3bgVzir8.l82T/PtCZmlJBadVPftSyeCnm9KKoE6', 'Minh Hải', '1999-02-02', 'nguyenminhhai1903@gmail.com', 192019201, '0efc9d709cece368036ce63e290f96bf', b'1', 2, b'0'),
(32, 'Mingtrang', '$2y$10$rwDt8V24ZKUwrVUgowupw.BbkKYE8KAG04AXUpIaG8Z5v1dOya39G', 'Lê Thị Minh Trang', '1999-02-20', 'mingtrang000@gmail.com', 90204853, '37386dbae059036c8cf935d0d4450f38', b'1', 2, b'0'),
(33, 'hixinh', '$2y$10$BN5Wk/l7VfjCuyHn7cJeq.SFtQxlf/OJo7DscU7HBBEM1b5POOEGG', 'Nguyễn Thị Thanh Hiền', '1999-02-21', 'hiengnguyen99@gmail.com', 924318700, 'a594b0562f2cb3b55ae4efd8e4e3166a', b'1', 2, b'0'),
(34, 'lexuanvu', '$2y$10$Dq.oS3k1b3o7.s8pWvdezOpgvvbQLg.R.0Dek41UmRIG/DJnEDBqe', 'Lê Xuân Vũ', '1999-12-29', 'vuxuanle99@gmail.com', 920392009, '23bf86ef7aedecc4cfdded0891758600', b'1', 2, b'0'),
(37, 'hienthanh', '$2y$10$YhES1uRaN6fKh6u4ELZRmedqrlNfob/9F4Xhu89dSmPrhH2XdvNqe', 'Hi Thanh', '1999-02-21', 'hiennguyen@gmail.com', 912221192, '6f04f130b6a56c110cdd2e98f4cdac83', b'1', 2, b'0'),
(38, 'dat09', '$2y$10$JYdHHWuXPHdosO25qGmBQO3IE7GhA3BL/uaW4oummg5SmNs7z6Jzy', 'dat09', '1999-10-01', 'dat09@gmail.com', 1642522400, '276b01be2cbb5e03233574198b339dbf', b'1', 2, b'0'),
(39, 'Stewieee', '$2y$10$qWP9kKQArrSoue79seNFK.8B3vIP6VpfXJb4rB4Es8Iw938kb6/bG', 'Phạm Xuân Lưu ', '1999-04-14', 'david1999vn2010@gmail.com', 938815662, 'c6bb22c5b644cf21548cc5c61e8f7222', b'1', 2, b'0'),
(41, 'hothang99', '$2y$10$535B6KmAVt.1dS4eht27N.WX1ECsNdBDVDkArRwX0qt.tDmYAVPNe', 'Hồ Thắng', '1999-11-09', 'hothang000192@gmail.com', 921298122, '2b3fb95fe88b36935d676b2a4b03da3f', b'1', 2, b'0'),
(42, 'hcnghiep99', '$2y$10$U6TcIlR/4RuWhUIF1kQeuOGTyD2BkFq5tjyYRZfgk6BbuYSiTwbQe', 'Hồng Cơ Nghiệp', '1999-02-06', 'hcnghiep99@gmail.com', 938146250, 'ad8ceb8d3a56023c2de9c343c3379433', b'1', 2, b'0'),
(43, 'thanhtam', '$2y$10$jc3Bj1PUI/AKbKDkKCo7vupTNRKX.fgWGP/.zVEJgZXGnP1HNSyWa', 'Thanh Tâm', '1999-12-24', 'tgky2412@gmail.com', 353752073, '693109bbf240719a47849c1d3d02c56f', b'1', 2, b'0'),
(44, 'lanlan', '$2y$10$2W6o2I4zivUBYUDK3nJf6.FRsaOUi3ygj/q9SZ/n45oy6gRt5wQWW', 'Lan Lan', '1999-12-24', 'doantrungnhat0402@gmail.com', 353752073, 'f81d1262658fa892b79af8720c312ae2', b'0', 2, b'0'),
(45, 'hoangdai', '$2y$10$brYbekX/11jVsUKD3.eLAOEzPXJhtF4Q.aDR7jXNBnVG4b2iFnbAC', 'Gia Kỳ Trần', '1999-12-24', 'thanhdang281299@gmail.com', 353752073, 'cda935e50e5629fb5fdcd5c94470ea09', b'0', 2, b'0'),
(46, 'dechoat', '$2y$10$aPqQ1uzFLWL6zFU/3P1UTuDkzNoNEeLi3b5SX69SQu9oORDLE2bgK', 'Xuân Mai', '1999-12-24', 'dangtran281299@gmail.com', 353752073, 'f02f1baa1583d35801050bf966dc21c7', b'0', 2, b'0'),
(47, 'anpham', '$2y$10$yiLvUF6yy5.Z2PiiA3jKTuGFmasXHNoNTSvpC5RJmAlI7CK7uGrpe', 'An Phạm', '1999-12-24', 'trangiaky4@gmail.com', 353752073, '8e470598a53d3bda2d18e6b1417d689d', b'0', 2, b'0'),
(48, 'anpham1', '$2y$10$KYGo8zX9o.1k/mlK5sl1gu3VkuCqvFghJk19CGS1UgekAbtRfVWaG', 'An Phạm', '1999-12-24', 'trangiaky5@gmail.com', 353752073, '1ffe43b49679d5996b8038d665cf0085', b'0', 2, b'0'),
(49, 'meobeo', '$2y$10$RyEMlHzQ2Rj8z4cM/k0X7eopyH9zWSsL.vqFSoKTMWkUcO.PYpo/C', 'Luân', '2020-12-01', 'luanle02468@gmail.com', 12345678, '8ff2b6abcaab994fae2c5c8f980e7f0f', b'0', 2, b'0'),
(50, 'thanhky', '$2y$10$eLK7UoLKF7x.826QaLvB2uwDuGBaZzIgn6YGuwF5KQxEf5jH/FWle', 'Thanh Kỳ', '1999-12-24', 'trangiaky6@gmail.com', 353752073, '00340f75c13b8937e70b51c2571b1f08', b'0', 2, b'0'),
(51, 'thanhmai', '$2y$10$EvkUdApCyGB9Ff.ucaQNwuIK.etHSgCZXMHsWeQs4JsfYvw.PgJuq', 'Thanh Mai', '1999-12-24', 'trangiaky7@gmail.com', 353752073, '65eb16cb966e0ad1b84a53381bbc636b', b'0', 2, b'0'),
(52, 'nhuquynh', '$2y$10$EX5O0ZBYj63MBX.YgB0LWuWF9RDbyKlgNqvx.3Bx.w5WcUcobPzs6', 'Như Quỳnh', '1999-12-24', 'trangiaky8@gmail.com', 353752073, 'a4c148e000d58ab341dd8c8dc699e8bc', b'0', 2, b'0'),
(53, 'hungphu', '$2y$10$C8LqgB06ra5hwvrcx3jG8e3ABUE0APZ2HBvAJmhRK.2oYyEibLzNW', 'Hưng Phú', '1999-12-24', 'trangiaky9@gmail.com', 353752073, '9dda6b843c4bf80e2f92ce836b0d48ac', b'0', 2, b'0'),
(54, 'admin60', '$2y$10$2Ul7LSk1xjCcmwqRd8hKzuMNyGMVY6go3v/Syq73.BTUdDaqCPQSm', 'Kỳ Kỳ', '1999-12-24', 'trangiaky10@gmail.com', 353752073, '5f050b1451f5baf5609e5e180840f6c7', b'0', 2, b'0'),
(55, 'kygia', '$2y$10$ujKZPGYek6ykroeGaC2E0OUT3F2O8Edo3B.vMet05uyBpwanHaD3O', 'Kỳ Gia', '1999-12-24', 'trangiaky11@gmail.com', 353752073, 'd29459cfb01c5111585033595b889c72', b'0', 2, b'0'),
(56, 'tamtam', '$2y$10$hUWLnpOpDjoeaztDTCxYCuF4u8QH83qZ.uA/ImkAySMa7qRHYGoKC', 'Tâm Tâm', '1999-12-24', 'trangiaky12@gmail.com', 353752073, '24b17a61ec3cbb848b4fd4c0f6ac5ce6', b'0', 2, b'0'),
(57, 'thanhthanh', '$2y$10$XS8Eq3SvVAUO.zrwiHDRfecBZW6XZHckz3SJCoiJFsijkEyms6XEK', 'Thanh Thanh', '1999-12-24', 'trangiaky13@gmail.com', 353752073, 'ac1b43cee51cc67161cb35ce9a90269e', b'0', 2, b'0'),
(58, 'lanthang', '$2y$10$AwftJc.tpUwl5mZYxE9//ex7BqvalxDKyxqSSCoBkjy3TVJE7m99.', 'Lan Thang', '1999-12-24', 'trangiaky14@gmail.com', 353752073, '85a7482aecab33508c6f515a9fbcacd6', b'0', 2, b'0'),
(59, 'minhthu', '$2y$10$HVQfhs9deg0qP6Jp7aSsSuFLq2iXz/IJXWsqk.YvztsdYCUdnl7tS', 'Minh Thư', '1999-12-24', 'trangiaky15@gmail.com', 353752073, '975ec20b5ef91f9d712f7f5789217b98', b'0', 2, b'0'),
(60, 'mymy', '$2y$10$NaRC1u4yP5sSCpPA2wamjuRndu4Cqpg3pqb8UwuPfavlbaFmkrtdG', 'Mỹ Mỹ', '1999-12-24', 'trangiaky16@gmail.com', 353752073, 'd16d7d69808a7dbe35c6798ace4530e4', b'0', 2, b'0'),
(61, 'ninhbinh', '$2y$10$qhyRXATa9FIKIZQc69q9aOAZGY3Z5S.8bzSQljSFFb9QpvdMLmUBW', 'Ninh Bình', '1999-12-24', 'trangiaky17@gmail.com', 353752073, '763cb44ae206a9f07aed2ad101c22028', b'0', 2, b'0'),
(62, 'nguyenthanh', '$2y$10$bWZD.kaXqjbDMJIFN5xG0.6HweFkJfRUxP.ofvD9NyRZlUpvm6Lx2', 'Nguyên Thành', '1999-12-24', 'trangiaky18@gmail.com', 353752073, '3048d644ac85d89f62c1cc41ee8af956', b'0', 2, b'0'),
(63, 'jackpit', '$2y$10$MMvhWu9uJyQq6Vc2CRi4DuPettxIrBS/VCp4h7uLq1HHeXdx3Ul.W', 'Jack Pit', '1999-12-24', 'trangiaky19@gmail.com', 353752073, '80f6ae08fd67447183d8dd615f74104b', b'0', 2, b'0'),
(64, 'steven', '$2y$10$CkloJP2O.w0wM4y19cTEFesRzNO0I0swQTONIq2BUOSgiYk1duXwm', 'Steven', '1111-12-24', 'trangiaky20@gmail.com', 353752073, '8a1a78c0e59938e8f5e444a78f77ffe9', b'0', 2, b'0'),
(65, 'admin1', '$2y$10$Tp/Kqudmrt0hO9yb2jYkGeIP5KZb5GIsZsSQi0fj5rb.kl6GS7pu2', 'admin1', '1111-12-24', 'trangiaky21@gmail.com', 353752073, '640c833c459ba6be63b12247d25790e2', b'0', 2, b'0'),
(66, 'admin2', '$2y$10$Noi.t9Ko/bCFjxKkgDkuIeNFW/9la1pHm9WNGdGiQh1L2ZZZ9w/bS', 'admin2', '1111-12-24', 'trangiaky22@gmail.com', 353752073, '3652dd96c923e39823b5cd08849a2ae3', b'0', 2, b'0'),
(67, 'admin3', '$2y$10$T8sBKMalOYePxjmXvWtLbOU1l1F.2DFlnhqnXaslPABaacPKspFC6', 'admin3', '1111-12-24', 'trangiaky23@gmail.com', 353752073, 'db70200996142b2a580afbcc7bfb7595', b'0', 2, b'0'),
(68, 'admin4', '$2y$10$snBAWW9Baat.Z7N.n2KmquJK5tjJLnX/I7US.gRTk2/wL25ksiEUC', 'admin4', '1111-12-24', 'trangiaky24@gmail.com', 353752073, 'b545b175f6289ab46466e259e0e35790', b'0', 2, b'0'),
(69, 'admin5', '$2y$10$/XvJzDK2QOvOvgt0Q07MSucej.oQLroahu.LcS882WzkIXWDM0dju', 'admin5', '1111-12-24', 'trangiaky25@gmail.com', 353752073, 'cf5394db6f3708cc26c419b52d65d8b1', b'0', 2, b'0'),
(70, 'admin6', '$2y$10$rziaHOyM3BpRxRxngp/XPulKbMlCaGWif8RZdR6/X2pTCC6uy90im', 'admin6', '1111-12-24', 'trangiaky26@gmail.com', 353752073, 'b11540184e0335b3f561a56c39c139b8', b'0', 2, b'0'),
(71, 'admin7', '$2y$10$s7RJlzByrrp.THjD20hqI.ivfm8eEtOXStyQjc9gmA3SeDlzE2Gxm', 'admin7', '1111-12-24', 'trangiaky27@gmail.com', 353752073, 'c7f1bd50118475fca9c19c3dd662cd89', b'0', 2, b'0'),
(72, 'admin8', '$2y$10$O309dK2Z.QFuzukL6gN8Ye/D0FwqotgW9CwPVo4F/11VETEOOA9fy', 'admin8', '1111-12-24', 'trangiaky28@gmail.com', 353752073, 'eb986453356222292c022ee3e53a6200', b'0', 2, b'0'),
(73, 'admin9', '$2y$10$z52ogzYcOTnp1OkxWhjKYexrCP1zVCHfNSTxHELQGoTYiQKZh65ri', 'admin9', '1111-12-24', 'trangiaky29@gmail.com', 353752073, 'fb838e0ae042caabff6a250344a37f52', b'0', 2, b'0'),
(74, 'admin10', '$2y$10$q.OKpZdeFiIcg0UetN/DweWbI3nPY.HrP9I3MILimGKtOGVL5VNcG', 'admin10', '1111-12-24', 'trangiaky30@gmail.com', 353752073, 'b6abee90924f65794a75fc4418a79e09', b'0', 2, b'0'),
(75, 'admin11', '$2y$10$flbzj747rDw8ra5Dfor/HutUgVB1HzoK0A5vMOV9enZhbUmJcUZxC', 'admin11', '1111-12-24', 'trangiaky31@gmail.com', 353752073, '084a3db6f7651f6d79dfb9696629bc42', b'0', 2, b'0'),
(76, 'admin12', '$2y$10$85.bVNZ7IfMh15f6NhzwDuninV/.qghLu2g7SVc4rJvUjLwzjc2fe', 'admin12', '1111-12-24', 'trangiaky32@gmail.com', 353752073, '935e167621db1360336eb4ef2fc50e10', b'0', 2, b'0'),
(77, 'admin13', '$2y$10$RgocptAL0y5dZ078qi3RcePpSpTWTapUk4ghgZ8hWkwMc/tUPsslO', 'admin13', '1111-12-24', 'trangiaky33@gmail.com', 353752073, 'fcb1c548b258531a77aa4d01d42097d6', b'0', 2, b'0'),
(78, 'admin14', '$2y$10$fhByOwWzJ3VHJVnfPhPPX.BexFAhShL6ZQskywELIBj0sf4nyZ8Ke', 'admin14', '1111-12-24', 'trangiaky34@gmail.com', 353752073, '3c6e259761ac5ba34f1fa41e7be34a30', b'0', 2, b'0'),
(79, 'admin15', '$2y$10$RaDMCgndlg2PPi/MtgpXeuC58aQvHZU3116zaq3gE51s/qQfgFgau', 'admin15', '1111-12-24', 'trangiaky35@gmail.com', 353752073, 'aa391f52e72857ff687473c749da1858', b'0', 2, b'0'),
(80, 'admin16', '$2y$10$KTHX3Eho56nLrkFVqYQ6p.9UKQ/87Vkz/ztbtQIcz6bemJbs3GmJS', 'admin16', '1111-12-24', 'trangiaky36@gmail.com', 353752073, '43c61bde0355fc8a2977a8a03dad6f8d', b'0', 2, b'0'),
(81, 'admin17', '$2y$10$VYPYZpXbsZ2O/ijQn8DMV.N4AIpHCI6gAwjQfwWHf3DbvU7V6LNPq', 'admin17', '1111-12-24', 'trangiaky37@gmail.com', 353752073, '1fe005d9cab470e6a595d3ad77557449', b'0', 2, b'0'),
(82, 'admin18', '$2y$10$iCCLlT6uBFWmvnGjAq5e2.lhfAg/N8immMMoK41zGyy3Hn0YlmpkW', 'admin18', '1111-12-24', 'trangiaky38@gmail.com', 353752073, 'cf7122075bc9b8b1fab78f77fe9f3055', b'0', 2, b'0'),
(83, 'admin19', '$2y$10$VIkSGZZzUhgGAAFJyYu91.titboms05fyUkuiE10Fu17kdLs2zR8u', 'admin19', '1111-12-24', 'trangiaky39@gmail.com', 353752073, '0a2a50dfad5682ec6a9ae3d243682103', b'0', 2, b'0'),
(84, 'admin20', '$2y$10$ievf8OGZAGXJtPgrLsW5XenU0UFvZNeAEM32a9FC9X3K/./eNIrcS', 'admin20', '1111-12-24', 'trangiaky40@gmail.com', 353752073, 'e916d0ac6924db40b58f1e4c92f5d35c', b'0', 2, b'0'),
(85, 'admin21', '$2y$10$eW.zoo3Z.GDRbyVylrWkaevEL8xJ/F3sBnoV9x/x90D9x/QdlytSi', 'admin21', '1111-12-24', 'trangiaky41@gmail.com', 353752073, '04a829ec3774a2930493c16ffbd13faa', b'0', 2, b'0'),
(86, 'admin22', '$2y$10$H3IU.iWTTUAYC7SkwLQaxuYdYih5oly29OW2WnrWBgHwWgzCq0Dzu', 'admin22', '1111-12-24', 'trangiaky42@gmail.com', 353752073, '6a5aae16b29e16de50c2a76572ae816e', b'0', 2, b'0'),
(87, 'admin23', '$2y$10$ynkzQOQqHI7v/3bgXxzZUem0cXAdXU/Lj0e3Lnuc5hFV7jwkk4QlW', 'admin23', '1111-12-24', 'trangiaky43@gmail.com', 353752073, '9bc03fc7bdd5c775a7e3936403f0c4b7', b'0', 2, b'0'),
(88, 'admin24', '$2y$10$63K6qVToQC25s5qhxSflbOO52KEGUTuIx4uI1z.fObYCM4UdD8Rg6', 'admin24', '1111-12-24', 'trangiaky44@gmail.com', 353752073, '98eddd3e13f8ad6f01a20bb53086869a', b'0', 2, b'0'),
(89, 'admin25', '$2y$10$YiUUs8NIpttViAPcFI7pY.Z4A4LFHeL5dWlYcj8mZAMX7j5cggsjO', 'admin25', '1110-12-24', 'trangiaky45@gmail.com', 353752073, '2ba59c8afd6efdd21e3b298c83892f73', b'0', 2, b'0'),
(90, 'admin26', '$2y$10$KzyG5eoit1V60vMw9yn1v.2yJCG1R1ydwYhKqbD4FH1Ji3SYkjhne', 'admin26', '1111-12-24', 'trangiaky46@gmail.com', 353752073, '3f37f9b7fcfd96dbfd8efb57bd26d1c7', b'0', 2, b'0'),
(91, 'admin27', '$2y$10$cYyZ8nb/EsSKvTXJpF.Jg.PbrSRi3INGbu.DohJLAJqeVfILenRdy', 'admin27', '1111-12-24', 'trangiaky47@gmail.com', 353752073, 'fa2b3434bf5c348bc4c59039b8e01a5f', b'0', 2, b'0'),
(92, 'admin28', '$2y$10$pmcMh/DiIDTAyX.OWJedcudrgG8tZAfySQOR/f0K9a.1Etpy4Eg3K', 'admin28', '1111-12-24', 'trangiaky48@gmail.com', 353752073, '938ab47c50fbe11ddd9e21a753301240', b'0', 2, b'0'),
(93, 'admin29', '$2y$10$GKRrD9iczcILvYTDOlWwTeQn9IExlMoQkuk647daBaT2.30PiP5sy', 'admin29', '1111-12-24', 'trangiaky49@gmail.com', 353752073, '2ce23865e7d9833b046daba3b484c18c', b'0', 2, b'0'),
(94, 'admin30', '$2y$10$3y.zxs/uXuO9oKiFpvjrdOjkaTa.e12kuH8GOhANKosJMaTb6AdQa', 'admin30', '1111-12-24', 'trangiaky50@gmail.com', 353752073, '6377e11f4ff889ed502244b42ef5d7bb', b'0', 2, b'0');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thanhvien`
--

CREATE TABLE `thanhvien` (
  `matk` int(5) NOT NULL,
  `malop` varchar(6) NOT NULL,
  `trangthai` int(1) NOT NULL DEFAULT '0',
  `is_deleted` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `thanhvien`
--

INSERT INTO `thanhvien` (`matk`, `malop`, `trangthai`, `is_deleted`) VALUES
(6, '0QyigO', 1, b'0'),
(6, 'qqwcnu', 0, b'0'),
(19, '0QyigO', 1, b'0'),
(19, 'f9FjAP', 1, b'0'),
(19, 'wO2Grn', 1, b'0'),
(22, 'f9FjAP', 1, b'0'),
(30, 'wO2Grn', 1, b'0'),
(31, 'f9FjAP', 1, b'0'),
(31, 'wO2Grn', 1, b'0'),
(33, 'wO2Grn', 1, b'0'),
(34, 'wO2Grn', 1, b'0');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `baidang`
--
ALTER TABLE `baidang`
  ADD PRIMARY KEY (`mabd`);

--
-- Chỉ mục cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  ADD PRIMARY KEY (`mabl`);

--
-- Chỉ mục cho bảng `lop`
--
ALTER TABLE `lop`
  ADD PRIMARY KEY (`malop`);

--
-- Chỉ mục cho bảng `quyen`
--
ALTER TABLE `quyen`
  ADD PRIMARY KEY (`maquyen`);

--
-- Chỉ mục cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`matk`);

--
-- Chỉ mục cho bảng `thanhvien`
--
ALTER TABLE `thanhvien`
  ADD PRIMARY KEY (`matk`,`malop`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `baidang`
--
ALTER TABLE `baidang`
  MODIFY `mabd` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  MODIFY `mabl` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `matk` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
