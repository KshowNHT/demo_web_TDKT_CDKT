-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Aug 05, 2024 at 10:57 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cdkt_tdkhenthuong`
--

-- --------------------------------------------------------

--
-- Table structure for table `danhgiacn`
--

CREATE TABLE `danhgiacn` (
  `MaDGCN` int(20) NOT NULL,
  `MaCN` int(20) NOT NULL,
  `MaKhoa` int(20) NOT NULL,
  `SoQD` varchar(50) NOT NULL,
  `Manam` int(20) NOT NULL,
  `DanhGia` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `danhgiacn`
--

INSERT INTO `danhgiacn` (`MaDGCN`, `MaCN`, `MaKhoa`, `SoQD`, `Manam`, `DanhGia`) VALUES
(11, 29, 25, '23', 0, 'Hoàn Thành Nhiệm Vụ');

-- --------------------------------------------------------

--
-- Table structure for table `danhgiatt`
--

CREATE TABLE `danhgiatt` (
  `MaDGTT` int(20) NOT NULL,
  `MaKhoa` int(20) NOT NULL,
  `SoQD` varchar(100) NOT NULL,
  `Manam` int(20) NOT NULL,
  `DanhGia` varchar(50) NOT NULL DEFAULT 'Chờ Đánh Giá'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `danhgiatt`
--

INSERT INTO `danhgiatt` (`MaDGTT`, `MaKhoa`, `SoQD`, `Manam`, `DanhGia`) VALUES
(70, 25, '23', 3, 'Hoàn Thành Tốt Nhiệm Vụ'),
(75, 25, '23', 1, 'TT_LAO_DONG_TIEN_TIEN'),
(76, 25, '23', 2, 'TT_LAO_DONG_XS'),
(77, 25, '23', 1, 'TT_LAO_DONG_XS'),
(78, 25, '23', 1, 'TT_LAO_DONG_XS'),
(79, 25, '23', 1, 'TT_LAO_DONG_XS'),
(80, 25, '23', 4, 'Hoàn Thành Nhiệm Vụ'),
(81, 25, '23', 4, 'TT_LAO_DONG_TIEN_TIEN'),
(82, 25, '23', 3, 'GK_Hieu_Truong'),
(83, 25, '23', 3, 'BK_UBNDTP'),
(84, 25, '23', 1, 'BK_UBNDTP'),
(85, 25, '23', 1, 'BK_UBNDTP'),
(86, 25, '23', 3, 'BK_TTCP'),
(87, 25, '23', 4, 'Huan_Chuong_Lao_Dong_Hang_Ba'),
(88, 25, '23', 4, 'Huan_Chuong_Lao_Dong_Hang_Nhi');

-- --------------------------------------------------------

--
-- Table structure for table `khoa`
--

CREATE TABLE `khoa` (
  `MaKhoa` int(20) NOT NULL,
  `TenKhoa` varchar(50) NOT NULL,
  `MoTa` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `khoa`
--

INSERT INTO `khoa` (`MaKhoa`, `TenKhoa`, `MoTa`) VALUES
(25, 'Công Nghệ Thông Tin', 'Công Nghệ Thông Tin'),
(28, 'Ngoại Ngữ', 'Ngoại Ngữ'),
(29, 'Xây Dựng', 'Xây Dựng'),
(30, 'Kinh Tế', 'Kinh Tế');

-- --------------------------------------------------------

--
-- Table structure for table `nam`
--

CREATE TABLE `nam` (
  `Manam` int(20) NOT NULL,
  `Nam` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nam`
--

INSERT INTO `nam` (`Manam`, `Nam`) VALUES
(1, '2024'),
(2, '2023'),
(3, '2022'),
(4, '2021'),
(6, '2020');

-- --------------------------------------------------------

--
-- Table structure for table `taikhoan`
--

CREATE TABLE `taikhoan` (
  `MaTk` int(11) NOT NULL,
  `TenTk` varchar(50) NOT NULL,
  `MatKhau` varchar(255) NOT NULL,
  `VaiTro` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `taikhoan`
--

INSERT INTO `taikhoan` (`MaTk`, `TenTk`, `MatKhau`, `VaiTro`) VALUES
(3, 'thuan123', '$2y$10$zsWqrF7Chmt8rg4sjMrn1u4QCRx94Sw6qWBold3vM8f1gmgA3ZBA6', 'Quản Trị'),
(4, 'thuan456', '$2y$10$.7iGv2HqGqnBRmm2JedBrO9eVsSEb6ACRtQgXXphvcoGeUdOcFLdO', 'Giảng Viên'),
(5, 'Thuan678', '$2y$10$PcKQeopNjJiFaME.1GOlQOyLAypMxfOeLWLgWL43JxBqRbIhWECEK', 'Khoa'),
(6, 'giangvien', '$2y$10$NXemjRp4IZcz2wPth4ESv.qKOjjCz.90aZqFs5SxInNdeG3oIvsX.', 'Giảng Viên'),
(7, 'quantri', '$2y$10$mse1.KlwY4dntjn4A6AZEer2S5Oy2zBfmndesRKrdCE2S0b/4zA16', 'Quản Trị'),
(8, 'khoa', '$2y$10$20KJ/7mqGaacA4JJ2vylhOSja02BVmFk7R7u.hDVKq.YnABRl2Njm', 'Khoa'),
(9, 'giangvien1', '$2y$10$rKkuex6uyyNIGT/MfeD/SOEoeENYrtCq3lWZtrcGPxHVNUnZo/4Pq', 'Giảng Viên');

-- --------------------------------------------------------

--
-- Table structure for table `thongtincanhan`
--

CREATE TABLE `thongtincanhan` (
  `MaCN` int(11) NOT NULL,
  `HoTen` varchar(30) NOT NULL,
  `NgaySinh` date NOT NULL,
  `MaKhoa` varchar(50) DEFAULT NULL,
  `ChuVu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `thongtincanhan`
--

INSERT INTO `thongtincanhan` (`MaCN`, `HoTen`, `NgaySinh`, `MaKhoa`, `ChuVu`) VALUES
(29, 'Nguyễn Hữu Thuận ', '2024-07-05', '25', 'Thực Tập '),
(34, 'Vũ', '2024-07-03', '26', 'Thực Tập');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `danhgiacn`
--
ALTER TABLE `danhgiacn`
  ADD PRIMARY KEY (`MaDGCN`),
  ADD KEY `fk_khoa_danhgiacanhan` (`MaKhoa`),
  ADD KEY `fk_thongtin_danhgiacanhan` (`MaCN`);

--
-- Indexes for table `danhgiatt`
--
ALTER TABLE `danhgiatt`
  ADD PRIMARY KEY (`MaDGTT`),
  ADD KEY `fk_khoa_danhgiatapthe` (`MaKhoa`),
  ADD KEY `fk_nam_danhgiatapthe` (`Manam`);

--
-- Indexes for table `khoa`
--
ALTER TABLE `khoa`
  ADD PRIMARY KEY (`MaKhoa`);

--
-- Indexes for table `nam`
--
ALTER TABLE `nam`
  ADD PRIMARY KEY (`Manam`);

--
-- Indexes for table `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`MaTk`);

--
-- Indexes for table `thongtincanhan`
--
ALTER TABLE `thongtincanhan`
  ADD PRIMARY KEY (`MaCN`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `danhgiacn`
--
ALTER TABLE `danhgiacn`
  MODIFY `MaDGCN` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `danhgiatt`
--
ALTER TABLE `danhgiatt`
  MODIFY `MaDGTT` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `khoa`
--
ALTER TABLE `khoa`
  MODIFY `MaKhoa` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `nam`
--
ALTER TABLE `nam`
  MODIFY `Manam` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `MaTk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `thongtincanhan`
--
ALTER TABLE `thongtincanhan`
  MODIFY `MaCN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `danhgiacn`
--
ALTER TABLE `danhgiacn`
  ADD CONSTRAINT `fk_khoa_danhgiacanhan` FOREIGN KEY (`MaKhoa`) REFERENCES `khoa` (`MaKhoa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_thongtin_danhgiacanhan` FOREIGN KEY (`MaCN`) REFERENCES `thongtincanhan` (`MaCN`) ON DELETE CASCADE;

--
-- Constraints for table `danhgiatt`
--
ALTER TABLE `danhgiatt`
  ADD CONSTRAINT `fk_khoa_danhgiatapthe` FOREIGN KEY (`MaKhoa`) REFERENCES `khoa` (`MaKhoa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_nam_danhgiatapthe` FOREIGN KEY (`Manam`) REFERENCES `nam` (`Manam`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
