<?php
session_start();
require_once __DIR__ . '/../app/Core/Database.php';

// TỰ ĐỘNG CHUYỂN HƯỚNG NẾU ĐÃ ĐĂNG NHẬP
if (isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'admin':
            header("Location: admin_dashboard.php");
            break;
        case 'manager':
            header("Location: manager_dashboard.php");
            break;
        default:
            header("Location: trangchu.php");
            break;
    }
    exit();
}

$error_server = "";

// 2. XỬ LÝ KHI BẤM NÚT ĐĂNG NHẬP
if (isset($_POST['btn_login'])) {
    $db = new Database();
    $conn = $db->conn;

    $u = trim($conn->real_escape_string($_POST['txt_user']));
    $p = $_POST['txt_pass'];

    $res = $conn->query("SELECT * FROM accounts WHERE username = '$u'");

    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();

        if (password_verify($p, $row['password'])) {
            // Lưu thông tin vào Session
            $_SESSION['user_id']  = $row['id'];
            $_SESSION['user'] = $row['fullname'];
            $_SESSION['role'] = $row['role']; // admin, manager, hoặc user
            $_SESSION['username'] = $row['username'];

            // Điều hướng dựa trên role
            if ($row['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } elseif ($row['role'] === 'manager') {
                header("Location: manager_dashboard.php");
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
?>
<!-- Giữ nguyên phần HTML của bạn bên dưới -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - VLUTE System</title>
    <!-- Kiểm tra lại đường dẫn CSS này có đúng file bạn đã gộp không -->
    <link rel="stylesheet" href="css/dangnhap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="login-wrapper">
        <div class="login-background">
            <img src="img/anhtruong31.jpg" alt="VLUTE Campus" onerror="this.src='https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=1350&q=80'">
            <div class="overlay"></div>
        </div>

        <div class="login-container">
            <div class="login-header">
                <img src="img/logo.jpg" alt="Logo" onerror="this.src='https://upload.wikimedia.org/wikipedia/vi/c/c7/Logo-vlute.png'">
                <h1>VLUTE SYSTEM</h1>
                <p>Hệ Thống Quản Lý Công Trình Xây Dựng</p>
            </div>

            <div class="login-card">
                <form action="" method="POST">
                    <h2>ĐĂNG NHẬP</h2>

                    <?php if ($error_server != ""): ?>
                        <div class="error-msg" style="color: red; background: #fee; padding: 10px; border-radius: 5px; margin-bottom: 10px; text-align: center;">
                            <?php echo $error_server; ?>
                        </div>
                    <?php endif; ?>

                    <div class="input-group">
                        <label><i class="fas fa-user"></i> Tên đăng nhập</label>
                        <input type="text" name="txt_user" placeholder="Mã số cán bộ/sinh viên" required>
                    </div>

                    <div class="input-group password-group">
                        <label><i class="fas fa-lock"></i> Mật khẩu</label>
                        <div class="password-input-wrapper">
                            <input type="password" name="txt_pass" id="txt_pass" placeholder="********" required>
                            <!-- Icon con mắt -->
                            <i class="fas fa-eye toggle-password" id="toggleIcon" onclick="togglePassword()"></i>
                        </div>
                        <div class="forgot-pass-wrapper">
                            <a href="#" class="forgot-link">Quên mật khẩu?</a>
                        </div>
                    </div>

                    <button type="submit" name="btn_login" class="btn-login">VÀO HỆ THỐNG</button>
                    <div class="form-footer">
                        <a href="home.php">← Quay lại trang chủ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>