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
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản - VLUTE System</title>
    <link rel="stylesheet" href="css/dangky.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="login-wrapper">
        <!-- Lớp nền ảnh trường (Dùng chung bộ nhận diện với trang đăng nhập) -->
        <div class="login-background">
            <img src="img/anhtruong.jpg" alt="VLUTE Campus" onerror="this.src='https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=1350&q=80'">
            <div class="overlay"></div>
        </div>

        <div class="login-container">
            <!-- Header Logo -->
            <div class="login-header">
                <img src="img/logo.jpg" alt="Logo" onerror="this.src='https://upload.wikimedia.org/wikipedia/vi/c/c7/Logo-vlute.png'">
                <h1>VLUTE SYSTEM</h1>
                <p>Hệ Thống Quản Lý Công Trình Xây Dựng</p>
            </div>

            <!-- Form Đăng ký -->
            <div class="login-card">
                <form action="" method="POST">
                    <h2>TẠO TÀI KHOẢN</h2>

                    <?php if ($msg != ""): ?>
                        <div class="msg-box <?php echo ($msg_type == 'error') ? 'error-msg' : 'success-msg'; ?>">
                            <?php echo $msg; ?>
                        </div>
                    <?php endif; ?>

                    <div class="input-group">
                        <label><i class="fas fa-id-card"></i> Họ và Tên</label>
                        <input type="text" name="txt_fullname" placeholder="Nhập họ và tên đầy đủ" required>
                    </div>

                    <div class="input-group">
                        <label><i class="fas fa-user"></i> Tên đăng nhập</label>
                        <input type="text" name="txt_user" placeholder="Ví dụ: 21004001" required>
                    </div>

                    <div class="input-group">
                        <label><i class="fas fa-lock"></i> Mật khẩu</label>
                        <input type="password" name="txt_pass" placeholder="********" required>
                    </div>

                    <div class="input-group">
                        <label><i class="fas fa-check-double"></i> Xác nhận mật khẩu</label>
                        <input type="password" name="txt_repass" placeholder="********" required>
                    </div>

                    <button type="submit" name="btn_register" class="btn-login">ĐĂNG KÝ NGAY</button>

                    <div class="form-footer">
                        <a href="home.php">← Quay lại trang chủ</a>
                        <a href="dangnhap.php">Đã có tài khoản? Đăng nhập</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>