<?php
session_start();

if (isset($_SESSION['user'])) {
    // Nếu đã đăng nhập -> Chuyển hướng đến URL của trang chủ
    // Lưu ý: Đường dẫn tính từ thư mục gốc của Web Server (htdocs)
    header("Location: public/trangchu.php");
} else {
    // Nếu chưa đăng nhập -> Xem trang giới thiệu
    header("Location: public/home.php");
}
exit();
