-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2026 at 08:31 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qlht_xaydung_vlute`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','manager','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `fullname`, `username`, `password`, `role`, `created_at`) VALUES
(4, 'Trần Minh Khải', '23004228', '$2y$10$Et3YlZ4dPCBKr6prdmUwXeDPb7p4g2mvPA9oYTUS5vrUlrA7qhGbi', 'admin', '2026-03-20 10:56:21'),
(5, 'Võ Minh Hiếu GÃY', '23004221admin', '$2y$10$VMD7j8R0eAK2o6znVqUJfuleV9hgO5MA4d82Tqv1jc1l9/DEzJ2Pa', 'admin', '2026-03-20 11:22:14'),
(6, 'Phan Hải Băng', '230042aa', '$2y$10$L/bFolIrZc8xM22bOxd8hOQ/5QZGLsDb8L5EBcDI.uLbaP2KBLntm', 'user', '2026-03-20 11:44:11'),
(7, 'Minh Khải', 'Khai123', '$2y$10$bc7Vsi47aDe7EJYXF1FgIupq//uIUGwANfLfKjpz2bMEuRNYpgU7C', 'user', '2026-03-20 12:10:15'),
(9, 'Phạm Duy tân', 'duytan123', '$2y$10$QCu45MUJBR2h7srE4acbZuURU2Qjm/Sn.HIyyG4NiCONVlc/996hW', 'manager', '2026-03-21 08:26:41'),
(10, 'Võ Minh Hiếu', 'hieuMana', '$2y$10$Ll2Ad73LU7sRqh8oATwt4eLoyWdcRcZrH.mCxPrEnrXn48tOJvA02', 'manager', '2026-05-31 16:29:02'),
(11, 'Võ Minh Hiếu', 'hieu123', '$2y$10$FlLiQXAE4qRoR8M7l9biJuQzYizn7NI.P0hmQVVTvV.GnUx39/L8y', 'user', '2026-06-01 16:22:49');

-- --------------------------------------------------------

--
-- Table structure for table `chuthau`
--

CREATE TABLE `chuthau` (
  `id` int(11) NOT NULL,
  `ma_ct` varchar(20) NOT NULL,
  `ten_don_vi` varchar(255) NOT NULL,
  `nguoi_dai_dien` varchar(100) DEFAULT NULL,
  `so_dien_thoai` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tong_von` decimal(15,2) DEFAULT NULL,
  `trang_thai` enum('Đang hợp tác','Đang trống') DEFAULT 'Đang hợp tác',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chuthau`
--

INSERT INTO `chuthau` (`id`, `ma_ct`, `ten_don_vi`, `nguoi_dai_dien`, `so_dien_thoai`, `email`, `tong_von`, `trang_thai`, `created_at`) VALUES
(1, '#CT042', 'Công ty Xây dựng Delta', 'Nguyễn Văn A', '0270.3822.111', 'delta@build.vn', 5200000000.00, 'Đang hợp tác', '2026-05-05 12:18:06'),
(2, '#CT088', 'Tổng Công ty Xây dựng Trường Sơn', 'Trần Văn Nam', '0243.5566.777', 'truongson@construction.vn', 12500000000.00, 'Đang hợp tác', '2026-05-05 12:20:52'),
(3, '#CT102', 'Công ty Cổ phần Đầu tư Hòa Bình', 'Lê Thị Thu Thủy', '0283.9100.222', 'contact@hoabinh.com.vn', 8900000000.00, 'Đang trống', '2026-05-05 12:20:52'),
(4, '#CT056', 'Xây dựng dân dụng VinaConex', 'Phạm Hoàng Long', '0243.1234.567', 'info@vinaconex.vn', 4300000000.00, 'Đang hợp tác', '2026-05-05 12:20:52'),
(5, '#CT091', 'Tập đoàn Xây dựng Coteccons', 'Nguyễn Mạnh Hùng', '0283.8445.566', 'office@coteccons.vn', 15000000000.00, 'Đang trống', '2026-05-05 12:20:52');

-- --------------------------------------------------------

--
-- Table structure for table `duan`
--

CREATE TABLE `duan` (
  `id` int(11) NOT NULL,
  `ma_da` varchar(20) NOT NULL,
  `ten_du_an` varchar(255) NOT NULL,
  `vi_tri` varchar(255) DEFAULT NULL,
  `mo_ta` text DEFAULT NULL,
  `tong_kinh_phi` decimal(15,2) DEFAULT 0.00,
  `chu_dau_tu` varchar(255) DEFAULT NULL,
  `nguoi_phu_trach_cdt` varchar(100) DEFAULT NULL,
  `id_nha_thau` int(11) DEFAULT NULL,
  `trang_thai` enum('Đang thực hiện','Hoàn thành','Tạm dừng') DEFAULT 'Đang thực hiện',
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `duan`
--

INSERT INTO `duan` (`id`, `ma_da`, `ten_du_an`, `vi_tri`, `mo_ta`, `tong_kinh_phi`, `chu_dau_tu`, `nguoi_phu_trach_cdt`, `id_nha_thau`, `trang_thai`, `ngay_tao`) VALUES
(1, '#DA-C1-2026', 'Xây dựng Nhà học C1 - VLUTE', 'Khu A - Cơ sở chính VLUTE', NULL, 0.00, 'Ban Quản lý VLUTE', 'ThS. Nguyễn Văn A', 1, 'Đang thực hiện', '2026-05-05 12:28:27'),
(2, '#DA-IOT-2026', 'Xây dựng hệ thống Lab IoT - Khu C', 'Tầng 3, Nhà C - Khu Lab Công nghệ', NULL, 0.00, 'Khoa Công nghệ thông tin', 'Võ Minh Hiếu', 1, 'Hoàn thành', '2026-05-05 12:28:52'),
(3, '#DA-PK-2026', 'Hệ thống quản lý bãi giữ xe thông minh', 'Cổng chính & Cổng phụ VLUTE', NULL, 0.00, 'Trung tâm Dịch vụ VLUTE', 'ThS. Lê Văn B', 2, 'Tạm dừng', '2026-05-05 12:28:52'),
(4, '#DA-CL-2026', 'Hệ thống quản lý phòng bệnh cách ly', 'Trung tâm Y tế / Trạm xá VLUTE', NULL, 5000000000.00, 'Phòng Quản trị thiết bị', 'Võ Minh Hiếu', 3, 'Đang thực hiện', '2026-05-05 12:28:52'),
(5, '#DA-PM-2026', 'Nâng cấp hệ thống mạng máy tính Khu B', 'Toàn bộ dãy nhà Khu B - VLUTE', 'Đang trong tiến trình xây dựng', 9999999999993.00, 'Ban Quản lý dự án VLUTE', 'Lê Thị Phương Thảo', 4, '', '2026-05-05 12:28:52'),
(6, '#DA-TX-2026', 'a', 'a', NULL, 0.00, 'a', NULL, NULL, 'Đang thực hiện', '2026-05-05 15:44:05'),
(7, 'DA-2026-NEW', 'Xây dựng khu F', 'Đường XYZ', NULL, 0.00, 'VLUTE', NULL, NULL, 'Đang thực hiện', '2026-06-02 06:11:53'),
(8, 'DA-2026-Z', 'Xây dựng khu Z', 'Đường ABC', NULL, 0.00, 'VLUTE', NULL, NULL, 'Đang thực hiện', '2026-06-02 06:30:33');

--
-- Triggers `duan`
--
DELIMITER $$
CREATE TRIGGER `sau_khi_them_du_an` AFTER INSERT ON `duan` FOR EACH ROW BEGIN
    INSERT INTO nhat_ky (noi_dung) 
    VALUES (CONCAT('Một dự án mới vừa được tạo: ', NEW.ten_du_an));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `hoa_don`
--

CREATE TABLE `hoa_don` (
  `id` int(11) NOT NULL,
  `id_du_an` int(11) NOT NULL,
  `ten_chi_phi` varchar(255) NOT NULL,
  `so_tien` decimal(15,2) NOT NULL,
  `ngay_thanh_toan` date NOT NULL,
  `ghi_chu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hoa_don`
--

INSERT INTO `hoa_don` (`id`, `id_du_an`, `ten_chi_phi`, `so_tien`, `ngay_thanh_toan`, `ghi_chu`) VALUES
(1, 5, 'Mua Xi măng', 50000000.00, '2026-05-31', '');

-- --------------------------------------------------------

--
-- Table structure for table `nhan_su`
--

CREATE TABLE `nhan_su` (
  `id` int(11) NOT NULL,
  `ma_nv` varchar(20) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `nam_sinh` int(4) DEFAULT NULL,
  `chuc_vu` varchar(50) DEFAULT NULL,
  `chuyen_nganh` varchar(100) DEFAULT NULL,
  `don_vi` varchar(100) DEFAULT NULL,
  `so_dien_thoai` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nhan_su`
--

INSERT INTO `nhan_su` (`id`, `ma_nv`, `ho_ten`, `nam_sinh`, `chuc_vu`, `chuyen_nganh`, `don_vi`, `so_dien_thoai`) VALUES
(1, 'NS-202601', 'Nguyễn Thành Trung', 1985, 'Quản lý dự án', 'Kỹ thuật Xây dựng', 'Phòng Kiến trúc', '0912345678'),
(2, 'NS-202602', 'Lê Thị Phương Thảo', 1992, 'Kế toán trưởng', 'Kế toán tổng hợp', 'Phòng Tài chính', '0988777666');

-- --------------------------------------------------------

--
-- Table structure for table `nhat_ky`
--

CREATE TABLE `nhat_ky` (
  `id` int(11) NOT NULL,
  `thoi_gian` datetime DEFAULT current_timestamp(),
  `noi_dung` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nhat_ky`
--

INSERT INTO `nhat_ky` (`id`, `thoi_gian`, `noi_dung`) VALUES
(1, '2026-06-02 13:30:33', 'Một dự án mới vừa được tạo: Xây dựng khu Z'),
(2, '2026-06-02 13:30:48', 'Hồ sơ \"qlht_xaydung_vlute_Hieu01_06.sql\" vừa được lưu trữ vào hệ thống.');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'Người nhận thông báo (NULL nếu cho tất cả)',
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0 COMMENT '0: Chưa đọc, 1: Đã đọc',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `is_read`, `created_at`) VALUES
(1, NULL, 'Admin vừa cập nhật sơ đồ thiết kế khu B', 0, '2026-03-21 09:25:10'),
(2, NULL, 'Có báo cáo vật tư mới cần ký duyệt từ tổ đội thi công', 0, '2026-03-21 09:25:10'),
(3, NULL, 'Hệ thống sẽ bảo trì vào lúc 23h đêm nay', 0, '2026-03-21 09:25:10');

-- --------------------------------------------------------

--
-- Table structure for table `tai_lieu`
--

CREATE TABLE `tai_lieu` (
  `id` int(11) NOT NULL,
  `ma_du_an` varchar(50) DEFAULT NULL,
  `ten_tai_lieu` varchar(255) DEFAULT NULL,
  `loai_tai_lieu` varchar(50) DEFAULT NULL,
  `duong_dan` varchar(255) DEFAULT NULL,
  `noi_dung_van_ban` longtext DEFAULT NULL,
  `hash_noi_dung` varchar(64) DEFAULT NULL,
  `ai_status` varchar(20) DEFAULT 'Normal',
  `ai_score` float DEFAULT 0,
  `ngay_tai` datetime DEFAULT current_timestamp(),
  `kich_thuoc` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tai_lieu`
--

INSERT INTO `tai_lieu` (`id`, `ma_du_an`, `ten_tai_lieu`, `loai_tai_lieu`, `duong_dan`, `noi_dung_van_ban`, `hash_noi_dung`, `ai_status`, `ai_score`, `ngay_tai`, `kich_thuoc`) VALUES
(1, 'Bản vẽ kỷ thuật công trình Khu A', 'BanVeKyThuatKhuB.txt', 'Bản vẽ', 'uploads/1778402447_BanVeKyThuatKhuB.txt', 'BẢN VẼ KỸ THUẬT: HỆ THỐNG ĐIỆN TẦNG 1 - KHU B\\r\\nMã hiệu: BV-VLUTE-B1-01qwq\\r\\nQuy chuẩn: etwetTCVN 9206:2012\\r\\nNội dung: rew\\r\\nVật tư chính: adsadas\\r\\nNgày lập: 08/05/2026. Người lập: KS. DS TIẾN\\r\\n', '2c67a86e2da6116856a82924a1f77a5cd594046e1b3180bcaf23dc05703cd779', 'Normal', 0, '2026-05-10 15:40:47', '0.22 KB'),
(4, 'Bản vẽ kỷ thuật công trình Khu B', 'a.txt', 'Bản vẽ', 'uploads/1778402664_a.txt', 'aa', '961b6dd3ede3cb8ecbaacbd68de040cd78eb2ed5889130cceb4c49268ea4d506', 'Normal', 0, '2026-05-10 15:44:24', '0 KB'),
(5, 'Bản vẽ kỷ thuật công trình Khu C', 'BanVeKyThuatKhuB.txt', 'Bản vẽ', 'uploads/1778402681_BanVeKyThuatKhuB.txt', 'BẢN VẼ KỸ THUẬT: HỆ THỐNG ĐIỆN TẦNG 1 - KHU B\\r\\nMã hiệu: BV-VLUTE-B1-01qwq\\r\\nQuy chuẩn: etwetTCVN 9206:2012\\r\\nNội dung: rew\\r\\nVật tư chính: adsadas\\r\\nNgày lập: 08/05/2026. Người lập: KS. DS TIẾN\\r\\n', '2c67a86e2da6116856a82924a1f77a5cd594046e1b3180bcaf23dc05703cd779', 'Duplicate', 100, '2026-05-10 15:44:41', '0.22 KB'),
(6, 'Bản vẽ kỷ thuật công trình Khu D', 'b.txt', 'Bản vẽ', 'uploads/1778403180_b.txt', 'alo em à nhớ a không', 'bc183998eabdd23d09128fb786204b3ee106a9f80d9ded2c62293e815d4274e5', 'Normal', 20.15, '2026-05-10 15:53:00', '0.02 KB'),
(7, '#DA-TX-2026', 'qlht_xaydung_vlute_Hieu01_06.sql', 'Bản vẽ', 'uploads/documents/1780380049_qlht_xaydung_vlute_Hieu01_06.sql', NULL, NULL, 'Chưa phân tích', 0, '2026-06-02 08:00:49', '12.7 KB'),
(8, 'DA-2026-Z', 'qlht_xaydung_vlute_Hieu01_06.sql', 'Hợp đồng', 'uploads/documents/1780381848_qlht_xaydung_vlute_Hieu01_06.sql', NULL, NULL, 'Normal', 0, '2026-06-02 08:30:48', '12.7 KB');

--
-- Triggers `tai_lieu`
--
DELIMITER $$
CREATE TRIGGER `sau_khi_them_tai_lieu` AFTER INSERT ON `tai_lieu` FOR EACH ROW BEGIN
    INSERT INTO nhat_ky (noi_dung) 
    VALUES (CONCAT('Hồ sơ "', NEW.ten_tai_lieu, '" vừa được lưu trữ vào hệ thống.'));
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `chuthau`
--
ALTER TABLE `chuthau`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `duan`
--
ALTER TABLE `duan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_da` (`ma_da`),
  ADD KEY `fk_duan_chuthau` (`id_nha_thau`);

--
-- Indexes for table `hoa_don`
--
ALTER TABLE `hoa_don`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_hoadon_duan` (`id_du_an`);

--
-- Indexes for table `nhan_su`
--
ALTER TABLE `nhan_su`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_nv` (`ma_nv`);

--
-- Indexes for table `nhat_ky`
--
ALTER TABLE `nhat_ky`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tai_lieu`
--
ALTER TABLE `tai_lieu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `chuthau`
--
ALTER TABLE `chuthau`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `duan`
--
ALTER TABLE `duan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `hoa_don`
--
ALTER TABLE `hoa_don`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `nhan_su`
--
ALTER TABLE `nhan_su`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nhat_ky`
--
ALTER TABLE `nhat_ky`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tai_lieu`
--
ALTER TABLE `tai_lieu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `duan`
--
ALTER TABLE `duan`
  ADD CONSTRAINT `fk_duan_chuthau` FOREIGN KEY (`id_nha_thau`) REFERENCES `chuthau` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `hoa_don`
--
ALTER TABLE `hoa_don`
  ADD CONSTRAINT `fk_hoadon_duan` FOREIGN KEY (`id_du_an`) REFERENCES `duan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
