<?php
session_start();

if (isset($_SESSION['user'])) {
    // Nếu đã đăng nhập -> Vào thẳng Dashboard quản lý
    header("Location: trangchu.php");
} else {
    // Nếu chưa đăng nhập -> Xem trang giới thiệu trường
    header("Location: home.php");
}
exit();
