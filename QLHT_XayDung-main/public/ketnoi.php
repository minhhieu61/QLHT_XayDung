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
// --- ĐOẠN CODE BỔ SUNG VÀO CUỐI FILE KETNOI.PHP ---

// Đảm bảo Session đã được start để lấy thông tin người dùng đăng nhập
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra xem biến session lưu tên người dùng của bạn là gì (Ví dụ: $_SESSION['ho_ten'] hoặc $_SESSION['user_name'])
// Ở đây tôi tạm thời lấy tên từ Session, nếu chưa đăng nhập thì để trống
$ten_nguoi_dung = isset($_SESSION['user']) ? $_SESSION['user'] : (isset($_SESSION['username']) ? $_SESSION['username'] : '');

if (!empty($ten_nguoi_dung) && $conn) {
    // Ép kiểu chuỗi an toàn
    $ten_nguoi_dung_safe = mysqli_real_escape_string($conn, $ten_nguoi_dung);

    // Gán biến tên người dùng vào phiên làm việc của MySQL. 
    // Từ lúc này, mọi trigger chạy trong lượt truy cập này đều đọc được biến @current_user_name
    mysqli_query($conn, "SET @current_user_name = '$ten_nguoi_dung_safe';");
}
