<?php
// 1. Khai báo các thông số kết nối
$servername = "localhost"; // Mặc định của XAMPP là localhost
$username = "root";        // Mặc định của XAMPP là root
$password = "";            // Mặc định của XAMPP là để trống
$dbname = "qlht_xaydung_vlute"; // THAY ĐỔI: Nhập đúng tên Database bạn đã tạo

// 2. Tạo kết nối
$conn = mysqli_connect($servername, $username, $password, $dbname);

// 3. Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// 4. Thiết lập font tiếng Việt để không bị lỗi dấu khi hiển thị
mysqli_set_charset($conn, "utf8");

// Thông báo kết nối thành công (Chỉ dùng để test, khi chạy thật nên ẩn đi)
// echo "Kết nối thành công!"; 
?>