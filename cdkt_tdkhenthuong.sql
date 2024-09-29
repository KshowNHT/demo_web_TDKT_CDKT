-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3308
-- Thời gian đã tạo: Th9 27, 2024 lúc 07:01 AM
-- Phiên bản máy phục vụ: 10.4.24-MariaDB
-- Phiên bản PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `cdkt_tdkhenthuong`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhgiacn`
--

CREATE TABLE `danhgiacn` (
  `MaDGCN` int(20) NOT NULL,
  `MaCN` int(20) NOT NULL,
  `MaKhoa` int(20) NOT NULL,
  `SoQD` varchar(50) NOT NULL,
  `Manam` int(20) NOT NULL,
  `DanhGia` varchar(50) NOT NULL,
  `Ngay` date NOT NULL,
  `DonVi` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhgiatt`
--

CREATE TABLE `danhgiatt` (
  `MaDGTT` int(20) NOT NULL,
  `MaKhoa` int(20) NOT NULL,
  `SoQD` varchar(100) NOT NULL,
  `Manam` int(20) NOT NULL,
  `DanhGia` varchar(50) NOT NULL DEFAULT 'Chờ Đánh Giá',
  `Ngay` date NOT NULL,
  `DonVi` varchar(30) NOT NULL,
  `FilePDF` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khethuongkyluat`
--

CREATE TABLE `khethuongkyluat` (
  `MaKTKL` int(11) NOT NULL,
  `MaCN` int(11) NOT NULL,
  `KhenThuong` varchar(30) NOT NULL,
  `KyLuat` varchar(30) NOT NULL,
  `Manam` int(20) NOT NULL,
  `SoQuyetDinh` varchar(30) NOT NULL,
  `NgayQuyetDinh` date NOT NULL,
  `DonVi` varchar(30) NOT NULL,
  `FilePDF` varchar(50) NOT NULL,
  `GhiChu` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khoa`
--

CREATE TABLE `khoa` (
  `MaKhoa` int(20) NOT NULL,
  `TenKhoa` varchar(50) NOT NULL,
  `MoTa` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `khoa`
--

INSERT INTO `khoa` (`MaKhoa`, `TenKhoa`, `MoTa`) VALUES
(32, 'Khoa Công nghệ - Thủy sản', 'Khoa Công nghệ - Thủy sản'),
(33, 'Khoa Công nghệ thông tin - Truyền thông', 'Khoa Công nghệ thông tin - Truyền thông'),
(34, 'Khoa Khoa học cơ bản', 'Khoa Khoa học cơ bản'),
(35, 'Khoa Nông nghiệp', 'Khoa Nông nghiệp'),
(36, 'Khoa Quản trị kinh doanh', 'Khoa Quản trị kinh doanh'),
(37, 'Khoa Tài chính - Kế toán', 'Khoa Tài chính - Kế toán'),
(38, 'Phòng Công tác học sinh, sinh viên', 'Phòng Công tác học sinh, sinh viên'),
(39, 'Phòng Hành chính - Tổ chức', 'Phòng Hành chính - Tổ chức'),
(40, 'Phòng Kế hoạch - Tài chính', 'Phòng Kế hoạch - Tài chính'),
(41, 'Phòng Quản lý đào tạo', 'Phòng Quản lý đào tạo'),
(42, 'Phòng Quản lý Khoa học - Hợp tác', 'Phòng Quản lý Khoa học - Hợp tác'),
(43, 'Phòng Quản trị thiết bị', 'Phòng Quản trị thiết bị'),
(44, 'Phòng Thanh tra - Đảm bảo chất lượng', 'Phòng Thanh tra - Đảm bảo chất lượng'),
(45, 'Trung tâm Kỹ thuật -Nông nghiệp', 'Trung tâm Kỹ thuật -Nông nghiệp'),
(46, 'Trung tâm Ngoại ngữ - Tin học', 'Trung tâm Ngoại ngữ - Tin học'),
(47, 'Trung tâm Trợ giúp kinh doanh', 'Trung tâm Trợ giúp kinh doanh'),
(48, 'Giám Hiệu', 'Giám Hiệu');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nam`
--

CREATE TABLE `nam` (
  `Manam` int(20) NOT NULL,
  `Nam` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `nam`
--

INSERT INTO `nam` (`Manam`, `Nam`) VALUES
(7, '2015'),
(8, '2016'),
(9, '2017'),
(10, '2018'),
(11, '2019'),
(12, '2020'),
(13, '2021-2022'),
(14, '2022-2023'),
(15, '2023-2024'),
(16, '2024-2025');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sangkien`
--

CREATE TABLE `sangkien` (
  `MaSK` int(11) NOT NULL,
  `MaCN` int(11) NOT NULL,
  `Manam` int(11) NOT NULL,
  `TenSK` varchar(50) DEFAULT NULL,
  `QD` varchar(20) DEFAULT NULL,
  `CapSK` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taikhoan`
--

CREATE TABLE `taikhoan` (
  `MaTk` int(11) NOT NULL,
  `TenTk` varchar(50) NOT NULL,
  `MatKhau` varchar(255) NOT NULL,
  `VaiTro` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `taikhoan`
--

INSERT INTO `taikhoan` (`MaTk`, `TenTk`, `MatKhau`, `VaiTro`) VALUES
(3, 'thuan123', '$2y$10$TpEsHj/d4YR3VEQ6McG7C.m8z6jhkqfj9EGXPA0sKVj0IgXnphvrW', 'Quản Trị'),
(4, 'thuan456', '$2y$10$.7iGv2HqGqnBRmm2JedBrO9eVsSEb6ACRtQgXXphvcoGeUdOcFLdO', 'Giảng Viên'),
(5, 'Thuan678', '$2y$10$PcKQeopNjJiFaME.1GOlQOyLAypMxfOeLWLgWL43JxBqRbIhWECEK', 'Khoa'),
(6, 'giangvien', '$2y$10$NXemjRp4IZcz2wPth4ESv.qKOjjCz.90aZqFs5SxInNdeG3oIvsX.', 'Giảng Viên'),
(7, 'quantri', '$2y$10$mse1.KlwY4dntjn4A6AZEer2S5Oy2zBfmndesRKrdCE2S0b/4zA16', 'Quản Trị'),
(8, 'khoa', '$2y$10$20KJ/7mqGaacA4JJ2vylhOSja02BVmFk7R7u.hDVKq.YnABRl2Njm', 'Khoa'),
(9, 'giangvien1', '$2y$10$rKkuex6uyyNIGT/MfeD/SOEoeENYrtCq3lWZtrcGPxHVNUnZo/4Pq', 'Giảng Viên');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thongtincanhan`
--

CREATE TABLE `thongtincanhan` (
  `MaCN` int(11) NOT NULL,
  `HoTen` varchar(30) NOT NULL,
  `NgaySinh` date NOT NULL,
  `MaKhoa` int(20) DEFAULT NULL,
  `ChuVu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `thongtincanhan`
--

INSERT INTO `thongtincanhan` (`MaCN`, `HoTen`, `NgaySinh`, `MaKhoa`, `ChuVu`) VALUES
(173, 'Nguyễn Thành Long', '1964-08-22', 48, 'Hiệu trưởng, Chủ tịch Hội đồng trường'),
(174, 'Lê Hoàng Thanh', '1974-05-18', 32, 'Phó Hiệu trưởng'),
(175, 'Lương Uyên Uyên', '1972-01-01', 32, 'phó Khoa Công nghệ -Thủy sản'),
(176, 'Hồ Mỹ Hạnh', '1971-01-22', 32, 'Trưởng khoa'),
(177, 'Nguyễn Quang Trung', '1971-02-24', 32, 'Trưởng Bộ môn'),
(178, 'LÊ THỊ NGỌC HÂN', '1976-06-16', 32, 'Giảng viên'),
(179, 'Nguyễn Thị Kiều Diễm', '1982-12-23', 32, 'Giảng viên'),
(180, 'Nguyễn Quốc Thanh', '1961-12-05', 32, 'Giảng viên'),
(181, 'Trần Diễm Phượng', '1983-12-06', 32, 'Giảng viên'),
(182, 'Phạm Quang Khôi', '1988-07-22', 32, 'Giảng viên'),
(183, 'Lâm Tấn Phát', '1988-06-09', 32, 'Giảng viên'),
(184, 'Tống Thành Thống', '1985-08-06', 33, 'Giảng viên'),
(185, 'Châu Lê Sa Lin', '1987-03-08', 33, 'Giảng viên'),
(186, 'Nguyễn Văn Chí', '1983-01-17', 33, 'Giảng viên'),
(187, 'Phạm Phi Giang', '1983-03-07', 33, 'Ủy viên BCH Đảng bộ, Phó trưởng Khoa CNTT-TT, Trưở'),
(188, 'Lương Minh Giang', '1980-05-17', 33, 'Giảng viên'),
(189, 'Võ Hoàng Tú', '1988-01-05', 33, 'Giảng viên - Trưởng BM'),
(190, 'Lê Thị Phương Phi', '1984-07-11', 33, 'Giảng viên'),
(191, 'Chung Thanh Hùng', '1982-08-08', 33, 'Giảng viên'),
(192, 'Nguyễn Minh Đợi', '1972-04-13', 33, 'Giảng viên'),
(193, 'Huỳnh Nguyễn Huyền Trang', '1972-04-21', 33, 'Không'),
(194, 'Trần Thị Bích Liên', '1986-01-17', 33, 'Giảng viên'),
(195, 'Nguyễn Minh Quyền', '1975-09-03', 33, 'Trưởng khoa'),
(196, 'Nguyễn Mạc Thái Nguyên', '1989-06-03', 34, 'Giảng viên'),
(197, 'Nguyễn Công Quyền', '1988-12-07', 34, 'Giảng viên'),
(198, 'Nguyễn Quốc Đoàn Kết', '1980-01-01', 34, 'Giảng viên'),
(199, 'La Thị Diệu Hạnh', '1982-09-11', 34, 'Giảng viên'),
(200, 'Lê Thị Hồng Quế', '1980-04-30', 34, 'giảng viên'),
(201, 'Lê Bích Thuận', '1975-11-10', 34, 'Trưởng bộ môn Ngoại Ngữ'),
(202, 'Nguyễn Thị Mai Hương', '1978-10-10', 34, 'Giảng viên'),
(203, 'LÂM KHÁNH LINH', '1984-05-23', 34, 'Trưởng Bộ môn giáo dục chính trị'),
(204, 'Nguyễn Dương Anh Thắng', '1988-07-21', 34, 'Giảng viên'),
(205, 'Trần Kim Linh', '1981-12-15', 34, 'Giảng viên'),
(206, 'Nguyễn Hoàng Nguyên', '1988-10-05', 34, 'Giảng viên'),
(207, 'Huỳnh Văn Tánh', '1979-09-14', 34, 'Giảng viên'),
(208, 'KHỔNG MINH NGỌC', '1981-01-27', 34, 'Giảng viên'),
(209, 'QUÁCH HOÀNG OANH', '1984-03-19', 34, 'Giảng viên'),
(210, 'Tạ Vũ Trân', '1962-01-05', 34, 'Trưởng khoa'),
(211, 'NGUYỄN BÁ VI', '1985-02-04', 34, 'Trưởng Bộ Môn'),
(212, 'Trần Thái Nhật Lam', '1969-08-18', 34, 'Giảng viên'),
(213, 'Nguyễn Mỹ Hạnh', '1980-01-13', 34, 'Giảng viên'),
(214, 'Ngô Lê Ngọc Lưỡng', '1971-05-22', 34, 'Phó trưởng khoa Khoa học Cơ bản'),
(215, 'Nguyễn Thị Hưng Hải', '1968-10-03', 35, 'Phó trưởng khoa nông nghiệp'),
(216, 'Nguyễn Thị Mỹ Hạnh', '1987-12-18', 35, 'Giảng viên'),
(217, 'Nguyễn Thị Hồng Phượng', '1988-04-11', 35, 'Giảng viên'),
(218, 'NGUYỄN NGỌC THANH LAM', '1976-08-18', 35, 'Giảng viên'),
(219, 'Hoàng Ngọc Khánh', '1987-03-18', 35, 'Giảng viên'),
(220, 'PHAN THỊ LỆ THI', '1982-12-16', 35, 'Giảng Viên'),
(221, 'Phan Thị Xuân Thủy', '1978-12-31', 35, 'Giảng viên'),
(222, 'Nguyễn Phúc Hảo', '1984-12-22', 35, 'Giảng viên'),
(223, 'Châu Trùng Dương', '1982-08-23', 35, 'Giảng viên'),
(224, 'Nguyễn Hồng Thảo', '1978-04-15', 35, 'Giảng viên'),
(225, 'Thái Thị Thanh Trang', '1973-03-20', 35, 'Giảng viên'),
(226, 'Lê Thị Bảo Châu', '1976-12-24', 35, 'Phó Khoa Nông Nghiệp, trưởng bộ môn Trồng tro'),
(227, 'Tô Thị Mộng Cầm', '1995-12-06', 35, 'Giảng viên'),
(228, 'Trần Phát Đạt', '1977-03-25', 35, 'Trợ Giảng'),
(229, 'Quách Huỳnh Mỹ Anh', '1982-07-11', 35, 'Giảng viên'),
(230, 'Mai Thuỳ Dương', '1982-03-02', 35, 'Giảng viên'),
(231, 'Nguyễn Kim Khoa', '1976-06-24', 35, 'Trưởng Bộ Môn'),
(232, 'Đinh Nguyễn Ánh Dương', '1987-04-17', 35, 'Giảng viên giáo dục nghề nghiệp lý thuyết hạng III'),
(233, 'Trần Thảo Vy', '1993-01-28', 35, 'Giảng viên'),
(234, 'Nguyễn Mỹ Linh', '1985-03-17', 36, 'Phó trưởng khoa'),
(235, 'Ngô Hà Lợi Lợi', '1985-07-16', 36, 'Giảng viên'),
(236, 'Nguyễn Thị Hoàng Yến', '1990-01-12', 36, 'Giảng viên'),
(237, 'Huỳnh Ngọc Ngân', '1992-07-25', 36, 'Giảng viên'),
(238, 'TRẦN THỊ TRÚC HẰNG', '1981-09-15', 36, 'giảng viên'),
(239, 'LÊ ANH THƯ', '1984-05-17', 36, 'Giảng viên'),
(240, 'Nguyễn Minh Thúy An', '1987-06-02', 36, 'Giảng viên'),
(241, 'Đỗ Hữu Nghị', '1980-08-20', 36, 'Giảng viên-Phó Giám đốc TT Trợ giúp Kinh doanh'),
(242, 'Mai Huỳnh Kiều Linh', '1981-10-10', 36, 'Giảng viên'),
(243, 'Nguyễn Thị Lệ', '1975-06-25', 36, 'Giảng viên chính hạng II, mã số: V.09.02.02/ Trưởn'),
(244, 'Nguyễn Thị Thanh Nhàn', '1992-02-17', 36, 'Giảng viên'),
(245, 'HUỲNH KIM NGÂN', '1992-10-22', 36, 'giảng viên'),
(246, 'NGUYỄN BÍCH NGỌC', '1984-09-03', 37, 'GIẢNG VIÊN'),
(247, 'PHẠM THANH PHONG', '1978-04-04', 37, 'phó Trưởng khoa'),
(248, 'Chung Diệu Nga', '1975-12-04', 37, 'Giảng viên'),
(249, 'Lưu Phạm Anh Thi', '1991-11-29', 37, 'Giảng viên'),
(250, 'TÔ NGỌC HÀ', '1980-01-31', 37, 'Giảng viên'),
(251, 'Nguyễn Thị Hồng', '1976-08-12', 37, 'Giảng viên'),
(252, 'NGUYỄN THỊ KIM QUYÊN', '1985-12-19', 37, 'Giảng viên'),
(253, 'VÕ THỊ HỒNG NHUNG', '1984-06-24', 37, 'Giảng viên'),
(254, 'Trần Thị Thúy Hồng', '1975-01-18', 37, 'Trưởng khoa'),
(255, 'Đặng Thị Kim Phượng', '1977-12-01', 37, 'giảng viên hạng 3'),
(256, 'Tạ Thị Thùy Hương', '1985-12-03', 37, 'GIẢNG VIÊN'),
(257, 'Lý Quốc Nguyên', '1993-04-15', 38, 'cán bộ Quản lý Khu nhà ở sinh viên'),
(258, 'Huỳnh Cảnh Thanh Lam', '1993-08-30', 38, 'Phó Trưởng phòng Công tác Học sinh, Sinh viên; Giả'),
(259, 'Nguyễn Hồng Thanh', '1962-08-10', 38, 'Trưởng phòng'),
(260, 'Trần Cẩm Trinh', '1986-07-13', 38, 'Chuyên viên'),
(261, 'Đỗ Thị Út', '1982-07-02', 38, 'Cán sự'),
(262, 'Tăng Thị Ngân', '1985-07-04', 39, 'Chuyên viên kiêm giảng viên'),
(263, 'Dương Văn Nghĩa', '1980-10-15', 39, 'Phó trưởng phòng'),
(264, 'Châu Minh Tân', '1970-04-10', 39, 'Trưởng phòng'),
(265, 'Đoàn Sĩ Nguyên', '2000-02-18', 39, 'Cán sự'),
(266, 'NGUYỄN THANH THIỆN', '1985-05-18', 39, 'Chuyên viên'),
(267, 'Trần Hiếu Thuận', '1996-06-28', 39, 'Cán sự'),
(268, 'NGUYỄN MINH TOÀN', '2000-04-16', 39, 'Cán sự'),
(269, 'HỒ PHẠM THANH LAN', '1987-04-20', 39, 'Chuyên viên'),
(270, 'Bùi Thị Thúy Chi', '1987-09-18', 39, 'Phó Trưởng phòng Hành chính - Tổ chức'),
(271, 'lLương Thị Kiều Oanh', '1982-02-01', 40, 'Kế toán viên'),
(272, 'Đỗ Hoàng Vân', '1983-12-14', 40, 'Chuyên viên'),
(273, 'Phạm Diễm Phương', '1986-03-22', 40, 'Không'),
(274, 'HUỲNH THỊ MINH PHƯƠNG', '1977-05-18', 40, 'KẾ TOÁN'),
(275, 'Châu Kiến Phong', '1974-01-04', 40, 'Trưởng phòng KH-TC/ Kế toán trưởng'),
(276, 'PHẠM THANH PHONG', '1978-11-02', 41, 'Trưởng phòng'),
(277, 'Đinh Thế An Huy', '1983-08-20', 41, 'Phó trưởng phòng Quản lý Đào tạo'),
(278, 'Võ Thị Hồng Hạnh', '1980-12-13', 41, 'Cán sự'),
(279, 'HUỲNH THỊ LÀI', '1981-11-06', 41, 'chuyên viên'),
(280, 'Phạm Hồng Cẩm', '1985-12-12', 41, 'Chuyên viên'),
(281, 'Lê Thị Kim Liên', '1983-02-03', 41, 'Chuyên viên'),
(282, 'Trương Thị Minh Giang', '1976-06-16', 41, 'Phó trưởng phòng'),
(283, 'Đỗ Hoàng Đại', '2000-04-26', 41, 'Cán Sự'),
(284, 'Nguyễn Thùy Dương', '1990-12-05', 42, 'Chuyên viên'),
(285, 'Vương Quốc Duy', '1988-10-03', 42, 'Phó Trưởng phòng'),
(286, 'Trần Văn Trọng', '1993-07-01', 42, 'Chuyên viên'),
(287, 'Đỗ Thị Viên', '1982-03-02', 42, 'Chuyên viên'),
(288, 'nguyễn thị lan anh', '1985-11-05', 42, 'chuyên viên'),
(289, 'Trần Thị Hiền', '1975-02-12', 42, 'Chuyên viên'),
(290, 'Hồ Việt Thống', '1982-09-10', 43, 'Phó Trưởng phòng'),
(291, 'Võ Hồng Anh', '1988-01-01', 43, 'Kỹ sư'),
(292, 'Đinh Đức Thành', '1987-10-16', 43, 'Trưởng phòng'),
(293, 'Bùi Phạm Mỹ Quyên', '1983-03-16', 43, 'Nhân viên phục vụ'),
(294, 'Bùi Kim Ngọc', '1969-04-12', 43, 'Nhân viên phục vụ'),
(295, 'Nguyễn Bùi Bảo Trân', '1990-09-19', 43, 'Nhân viên phục vụ'),
(296, 'Tô Văn Cảnh', '1984-01-01', 43, 'Nhân viên kỹ thuật'),
(297, 'Trần Thị Út', '1976-10-20', 43, 'Phó trưởng phòng'),
(298, 'Lê Thanh Hải', '1989-06-06', 43, 'Kỹ sư'),
(299, 'giảng thanh nhường', '1988-06-18', 43, 'Trưởng bộ phận'),
(300, 'Trần Văn Bảnh', '1970-03-30', 43, 'NV Bảo vệ'),
(301, 'Lê Văn An', '1971-01-01', 43, 'NV Kỹ thuật - Bảo vệ'),
(302, 'PHẠM HỮU NHÂN', '1965-01-26', 44, 'Trưởng phòng'),
(303, 'Nguyễn Hữu Vang', '1977-05-18', 44, 'Chuyên viên'),
(304, 'Lý Quốc Thống', '1994-11-27', 44, 'Bảo vệ'),
(305, 'Huỳnh Văn Nghĩa', '1963-04-13', 44, 'Bảo vệ'),
(306, 'Phạm Văn Thịnh', '1969-02-02', 44, 'Chuyên viên'),
(307, 'Nguyễn Văn Mít', '1986-06-27', 44, 'Nhân viên bảo vệ'),
(308, 'Đặng Thị Phương Lan', '1978-04-06', 45, 'Kế toán viên'),
(309, 'Nguyễn Văn Quyền', '1963-10-02', 45, 'Trưởng Khoa');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `danhgiacn`
--
ALTER TABLE `danhgiacn`
  ADD PRIMARY KEY (`MaDGCN`),
  ADD KEY `fk_khoa_danhgiacanhan` (`MaKhoa`),
  ADD KEY `fk_thongtin_danhgiacanhan` (`MaCN`);

--
-- Chỉ mục cho bảng `danhgiatt`
--
ALTER TABLE `danhgiatt`
  ADD PRIMARY KEY (`MaDGTT`),
  ADD KEY `fk_khoa_danhgiatapthe` (`MaKhoa`),
  ADD KEY `fk_nam_danhgiatapthe` (`Manam`);

--
-- Chỉ mục cho bảng `khethuongkyluat`
--
ALTER TABLE `khethuongkyluat`
  ADD PRIMARY KEY (`MaKTKL`),
  ADD KEY `fk_MaCn` (`MaCN`),
  ADD KEY `fk_Manam` (`Manam`);

--
-- Chỉ mục cho bảng `khoa`
--
ALTER TABLE `khoa`
  ADD PRIMARY KEY (`MaKhoa`);

--
-- Chỉ mục cho bảng `nam`
--
ALTER TABLE `nam`
  ADD PRIMARY KEY (`Manam`);

--
-- Chỉ mục cho bảng `sangkien`
--
ALTER TABLE `sangkien`
  ADD PRIMARY KEY (`MaSK`),
  ADD KEY `fk_ttcn` (`MaCN`),
  ADD KEY `fk_nam` (`Manam`);

--
-- Chỉ mục cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`MaTk`);

--
-- Chỉ mục cho bảng `thongtincanhan`
--
ALTER TABLE `thongtincanhan`
  ADD PRIMARY KEY (`MaCN`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `danhgiacn`
--
ALTER TABLE `danhgiacn`
  MODIFY `MaDGCN` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `danhgiatt`
--
ALTER TABLE `danhgiatt`
  MODIFY `MaDGTT` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;

--
-- AUTO_INCREMENT cho bảng `khethuongkyluat`
--
ALTER TABLE `khethuongkyluat`
  MODIFY `MaKTKL` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `khoa`
--
ALTER TABLE `khoa`
  MODIFY `MaKhoa` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT cho bảng `nam`
--
ALTER TABLE `nam`
  MODIFY `Manam` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `sangkien`
--
ALTER TABLE `sangkien`
  MODIFY `MaSK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `MaTk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `thongtincanhan`
--
ALTER TABLE `thongtincanhan`
  MODIFY `MaCN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=310;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `danhgiacn`
--
ALTER TABLE `danhgiacn`
  ADD CONSTRAINT `fk_khoa_danhgiacanhan` FOREIGN KEY (`MaKhoa`) REFERENCES `khoa` (`MaKhoa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_thongtin_danhgiacanhan` FOREIGN KEY (`MaCN`) REFERENCES `thongtincanhan` (`MaCN`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `danhgiatt`
--
ALTER TABLE `danhgiatt`
  ADD CONSTRAINT `fk_khoa_danhgiatapthe` FOREIGN KEY (`MaKhoa`) REFERENCES `khoa` (`MaKhoa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_nam_danhgiatapthe` FOREIGN KEY (`Manam`) REFERENCES `nam` (`Manam`);

--
-- Các ràng buộc cho bảng `khethuongkyluat`
--
ALTER TABLE `khethuongkyluat`
  ADD CONSTRAINT `fk_MaCn` FOREIGN KEY (`MaCN`) REFERENCES `thongtincanhan` (`MaCN`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_Manam` FOREIGN KEY (`Manam`) REFERENCES `nam` (`Manam`);

--
-- Các ràng buộc cho bảng `sangkien`
--
ALTER TABLE `sangkien`
  ADD CONSTRAINT `fk_nam` FOREIGN KEY (`Manam`) REFERENCES `nam` (`Manam`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ttcn` FOREIGN KEY (`MaCN`) REFERENCES `thongtincanhan` (`MaCN`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
