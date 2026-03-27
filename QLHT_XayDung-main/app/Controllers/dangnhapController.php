<!-- chưa sửa xong -->
<?php
session_start();
require_once __DIR__ . '/../app/Core/Database.php';

// 1. Nếu đã đăng nhập rồi thì tự động chuyển hướng theo quyền luôn
if (isset($_SESSION['user']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: trangchu.php");
    }
    exit();
}

$error_server = "";

// 2. Xử lý khi bấm nút Đăng nhập
if (isset($_POST['btn_login'])) {
    $db = new Database();
    $conn = $db->conn;

    // Sửa dòng này trong dangnhap.php
    $u = trim($conn->real_escape_string($_POST['txt_user']));
    $p = $_POST['txt_pass'];

    // Truy vấn từ bảng accounts mới đổi tên
    $res = $conn->query("SELECT * FROM accounts WHERE username = '$u'");

    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();

        // Kiểm tra mật khẩu (Phải là mã hash trong DB mới khớp)
        if (password_verify($p, $row['password'])) {
            // Lưu các thông tin quan trọng vào Session
            $_SESSION['user'] = $row['fullname'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['username'] = $row['username'];

            // Kiểm tra quyền để chuyển hướng đúng trang
            if ($row['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: trangchu.php");
            }
            exit();
        } else {
            $error_server = "Mật khẩu không chính xác!";
        }
    } else {
        $error_server = "Tên đăng nhập không tồn tại!";
    }
}
