-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2026 at 10:42 AM
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
(7, 'Hiếu thứ 1', 'hieu123', '$2y$10$bc7Vsi47aDe7EJYXF1FgIupq//uIUGwANfLfKjpz2bMEuRNYpgU7C', 'user', '2026-03-20 12:10:15'),
(9, 'Phạm Duy tân', 'duytan123', '$2y$10$QCu45MUJBR2h7srE4acbZuURU2Qjm/Sn.HIyyG4NiCONVlc/996hW', 'manager', '2026-03-21 08:26:41');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
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
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'Đang thi công',
  `progress` int(11) DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
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
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `project_id`, `author_id`, `content`, `created_at`) VALUES
(1, 1, 10, 'Báo cáo tiến độ tuần 3 tháng 3', '2026-03-21 09:25:10');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
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
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `project_id`, `task_name`, `status`, `assigned_to`, `created_at`) VALUES
(1, 1, 'Đổ bê tông sàn tầng 2', 'pending', NULL, '2026-03-21 09:25:10'),
(2, 2, 'Kéo dây cáp trung thế', 'pending', NULL, '2026-03-21 09:25:10');

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
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
