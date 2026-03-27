<!-- chưa sửa xong -->
<?php
session_start();
require_once __DIR__ . '/../app/Core/Database.php';

$msg = "";
$msg_type = "";

if (isset($_POST['btn_register'])) {
    $db = new Database();
    $conn = $db->conn;

    $ho_ten = $conn->real_escape_string($_POST['txt_fullname']);
    $user = $conn->real_escape_string($_POST['txt_user']);
    $pass = $_POST['txt_pass'];
    $re_pass = $_POST['txt_repass'];

    if ($pass !== $re_pass) {
        $msg = "Mật khẩu xác nhận không khớp!";
        $msg_type = "error";
    } else {
        // Kiểm tra trùng
        $check_user = $conn->query("SELECT id FROM accounts WHERE username = '$user'");
        if ($check_user->num_rows > 0) {
            $msg = "Tên đăng nhập này đã được sử dụng!";
            $msg_type = "error";
        } else {
            // Sửa đoạn query INSERT trong file dangky.php của bạn:
            $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
            $role = 'user'; // Mặc định là người dùng thường
            // Chèn dữ liệu mới
            $sql = "INSERT INTO accounts (fullname, username, password, role) 
        VALUES ('$ho_ten', '$user', '$hashed_pass', '$role')";

            if ($conn->query($sql)) {
                $msg = "Đăng ký thành công! Đang chuyển hướng đăng nhập...";
                $msg_type = "success";
                header("refresh:2; url=dangnhap.php"); // Đã sửa tên file
            } else {
                $msg = "Lỗi hệ thống: " . $conn->error;
                $msg_type = "error";
            }
        }
    }
}
