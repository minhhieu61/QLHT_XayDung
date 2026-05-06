-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 06, 2026 lúc 07:24 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `qlht_xaydung_vlute`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `accounts`
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
-- Đang đổ dữ liệu cho bảng `accounts`
--

INSERT INTO `accounts` (`id`, `fullname`, `username`, `password`, `role`, `created_at`) VALUES
(4, 'Trần Minh Khải', '23004228', '$2y$10$Et3YlZ4dPCBKr6prdmUwXeDPb7p4g2mvPA9oYTUS5vrUlrA7qhGbi', 'admin', '2026-03-20 10:56:21'),
(5, 'Võ Minh Hiếu GÃY', '23004221admin', '$2y$10$VMD7j8R0eAK2o6znVqUJfuleV9hgO5MA4d82Tqv1jc1l9/DEzJ2Pa', 'admin', '2026-03-20 11:22:14'),
(6, 'Phan Hải Băng', '230042aa', '$2y$10$L/bFolIrZc8xM22bOxd8hOQ/5QZGLsDb8L5EBcDI.uLbaP2KBLntm', 'user', '2026-03-20 11:44:11'),
(7, 'Minh Khải', 'Khai123', '$2y$10$bc7Vsi47aDe7EJYXF1FgIupq//uIUGwANfLfKjpz2bMEuRNYpgU7C', 'user', '2026-03-20 12:10:15'),
(9, 'Phạm Duy tân', 'duytan123', '$2y$10$QCu45MUJBR2h7srE4acbZuURU2Qjm/Sn.HIyyG4NiCONVlc/996hW', 'manager', '2026-03-21 08:26:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chuthau`
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
-- Đang đổ dữ liệu cho bảng `chuthau`
--

INSERT INTO `chuthau` (`id`, `ma_ct`, `ten_don_vi`, `nguoi_dai_dien`, `so_dien_thoai`, `email`, `tong_von`, `trang_thai`, `created_at`) VALUES
(1, '#CT042', 'Công ty Xây dựng Delta', 'Nguyễn Văn A', '0270.3822.111', 'delta@build.vn', 5200000000.00, 'Đang hợp tác', '2026-05-05 12:18:06'),
(2, '#CT088', 'Tổng Công ty Xây dựng Trường Sơn', 'Trần Văn Nam', '0243.5566.777', 'truongson@construction.vn', 12500000000.00, 'Đang hợp tác', '2026-05-05 12:20:52'),
(3, '#CT102', 'Công ty Cổ phần Đầu tư Hòa Bình', 'Lê Thị Thu Thủy', '0283.9100.222', 'contact@hoabinh.com.vn', 8900000000.00, 'Đang trống', '2026-05-05 12:20:52'),
(4, '#CT056', 'Xây dựng dân dụng VinaConex', 'Phạm Hoàng Long', '0243.1234.567', 'info@vinaconex.vn', 4300000000.00, 'Đang hợp tác', '2026-05-05 12:20:52'),
(5, '#CT091', 'Tập đoàn Xây dựng Coteccons', 'Nguyễn Mạnh Hùng', '0283.8445.566', 'office@coteccons.vn', 15000000000.00, 'Đang trống', '2026-05-05 12:20:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `duan`
--

CREATE TABLE `duan` (
  `id` int(11) NOT NULL,
  `ma_da` varchar(20) NOT NULL,
  `ten_du_an` varchar(255) NOT NULL,
  `vi_tri` varchar(255) DEFAULT NULL,
  `chu_dau_tu` varchar(255) DEFAULT NULL,
  `nguoi_phu_trach_cdt` varchar(100) DEFAULT NULL,
  `id_nha_thau` int(11) DEFAULT NULL,
  `trang_thai` enum('Đang thực hiện','Hoàn thành','Tạm dừng') DEFAULT 'Đang thực hiện',
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `duan`
--

INSERT INTO `duan` (`id`, `ma_da`, `ten_du_an`, `vi_tri`, `chu_dau_tu`, `nguoi_phu_trach_cdt`, `id_nha_thau`, `trang_thai`, `ngay_tao`) VALUES
(1, '#DA-C1-2026', 'Xây dựng Nhà học C1 - VLUTE', 'Khu A - Cơ sở chính VLUTE', 'Ban Quản lý VLUTE', 'ThS. Nguyễn Văn A', 1, 'Đang thực hiện', '2026-05-05 12:28:27'),
(2, '#DA-IOT-2026', 'Xây dựng hệ thống Lab IoT - Khu C', 'Tầng 3, Nhà C - Khu Lab Công nghệ', 'Khoa Công nghệ thông tin', 'ThS. Nguyễn Văn A', 1, 'Đang thực hiện', '2026-05-05 12:28:52'),
(3, '#DA-PK-2026', 'Hệ thống quản lý bãi giữ xe thông minh', 'Cổng chính & Cổng phụ VLUTE', 'Trung tâm Dịch vụ VLUTE', 'ThS. Lê Văn B', 2, 'Tạm dừng', '2026-05-05 12:28:52'),
(4, '#DA-CL-2026', 'Hệ thống quản lý phòng bệnh cách ly', 'Trung tâm Y tế / Trạm xá VLUTE', 'Phòng Quản trị thiết bị', 'ThS. Phạm Thị C', 3, 'Đang thực hiện', '2026-05-05 12:28:52'),
(5, '#DA-PM-2026', 'Nâng cấp hệ thống mạng máy tính Khu B', 'Toàn bộ dãy nhà Khu B - VLUTE', 'Ban Quản lý dự án VLUTE', 'ThS. Đỗ Hoàng D', 4, 'Hoàn thành', '2026-05-05 12:28:52'),
(6, '#DA-TX-2026', 'a', 'a', 'a', NULL, NULL, 'Đang thực hiện', '2026-05-05 15:44:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `position` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhan_su`
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
-- Đang đổ dữ liệu cho bảng `nhan_su`
--

INSERT INTO `nhan_su` (`id`, `ma_nv`, `ho_ten`, `nam_sinh`, `chuc_vu`, `chuyen_nganh`, `don_vi`, `so_dien_thoai`) VALUES
(1, 'NS-202601', 'Nguyễn Thành Trung', 1985, 'Quản lý dự án', 'Kỹ thuật Xây dựng', 'Phòng Kiến trúc', '0912345678'),
(2, 'NS-202602', 'Lê Thị Phương Thảo', 1992, 'Kế toán trưởng', 'Kế toán tổng hợp', 'Phòng Tài chính', '0988777666');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'Người nhận thông báo (NULL nếu cho tất cả)',
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0 COMMENT '0: Chưa đọc, 1: Đã đọc',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `is_read`, `created_at`) VALUES
(1, NULL, 'Admin vừa cập nhật sơ đồ thiết kế khu B', 0, '2026-03-21 09:25:10'),
(2, NULL, 'Có báo cáo vật tư mới cần ký duyệt từ tổ đội thi công', 0, '2026-03-21 09:25:10'),
(3, NULL, 'Hệ thống sẽ bảo trì vào lúc 23h đêm nay', 0, '2026-03-21 09:25:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'Đang thi công',
  `progress` int(11) DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `projects`
--

INSERT INTO `projects` (`id`, `name`, `status`, `progress`, `updated_at`) VALUES
(1, 'Nhà đa năng VLUTE', 'Hoàn thành', 0, '2026-03-21 09:24:57'),
(2, 'Khoa CNTT', 'Đang thi công', 0, '2026-03-21 09:24:57'),
(3, 'Nhà của Băng', 'Đang thi công', 0, '2026-03-21 09:24:57'),
(4, 'a', 'Chuẩn bị', 0, '2026-03-21 09:24:57'),
(5, 'b', 'Hoàn thiện', 0, '2026-03-21 09:24:57'),
(6, 'Xây dựng Nhà xưởng Khu A', 'ongoing', 65, '2026-03-21 09:25:10'),
(7, 'Lắp đặt hệ thống điện Khu B', 'ongoing', 40, '2026-03-21 09:25:10'),
(8, 'Hoàn thiện mặt bằng Giai đoạn 1', 'completed', 100, '2026-03-21 09:25:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `reports`
--

INSERT INTO `reports` (`id`, `project_id`, `author_id`, `content`, `created_at`) VALUES
(1, 1, 10, 'Báo cáo tiến độ tuần 3 tháng 3', '2026-03-21 09:25:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected','in_progress') DEFAULT 'pending',
  `assigned_to` int(11) DEFAULT NULL COMMENT 'Nhân viên thực hiện',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tasks`
--

INSERT INTO `tasks` (`id`, `project_id`, `task_name`, `status`, `assigned_to`, `created_at`) VALUES
(1, 1, 'Đổ bê tông sàn tầng 2', 'pending', NULL, '2026-03-21 09:25:10'),
(2, 2, 'Kéo dây cáp trung thế', 'pending', NULL, '2026-03-21 09:25:10');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `chuthau`
--
ALTER TABLE `chuthau`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `duan`
--
ALTER TABLE `duan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_da` (`ma_da`),
  ADD KEY `fk_duan_chuthau` (`id_nha_thau`);

--
-- Chỉ mục cho bảng `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Chỉ mục cho bảng `nhan_su`
--
ALTER TABLE `nhan_su`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_nv` (`ma_nv`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Chỉ mục cho bảng `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `chuthau`
--
ALTER TABLE `chuthau`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `duan`
--
ALTER TABLE `duan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `nhan_su`
--
ALTER TABLE `nhan_su`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `duan`
--
ALTER TABLE `duan`
  ADD CONSTRAINT `fk_duan_chuthau` FOREIGN KEY (`id_nha_thau`) REFERENCES `chuthau` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
