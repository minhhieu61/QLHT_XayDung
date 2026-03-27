<?php
session_start();

// Hủy bỏ tất cả các biến session
$_SESSION = array();

// Nếu muốn xóa sạch cả Cookie session thì thêm đoạn này
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// Hủy hoàn toàn phiên làm việc
session_destroy();

// Chuyển hướng về trang chủ hoặc trang đăng nhập
header("Location: home.php");
exit();
