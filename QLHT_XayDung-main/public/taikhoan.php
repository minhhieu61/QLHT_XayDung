<?php
// Giả sử ID người dùng đang đăng nhập được lưu trong Session
// $user_id = $_SESSION['user_id'];
// $sql_user = "SELECT * FROM users WHERE id = 1"; // Thay bằng biến session thực tế
// $res_user = mysqli_query($conn, $sql_user);
// $user = mysqli_fetch_assoc($res_user);
// php echo $user['fullname'];
?>

<link rel="stylesheet" href="css/taikhoan.css">

<div class="account-container">
    <header class="vattu-header-top">
        <div class="header-title-ql">
            <h1><i class="fas fa-user-circle"></i> TÀI KHOẢN CÁ NHÂN</h1>
            <p>Quản lý thông tin hồ sơ và bảo mật tài khoản</p>
        </div>
    </header>

    <div class="account-grid">
        <div class="account-card profile-sidebar">
            <div class="profile-usertitle">
                <div class="profile-name"> Trần Minh Khải</div>
                <div class="profile-role">Quản trị viên hệ thống</div>
            </div>
            <div class="profile-status">
                <span class="dot green"></span> Đang hoạt động
            </div>
        </div>

        <div class="account-card profile-content">
            <form action="xuly_taikhoan.php" method="POST">
                <div class="form-section">
                    <h3><i class="fas fa-info-circle"></i> Thông tin cơ bản</h3>
                    <div class="form-group">
                        <label>Họ và tên</label>
                        <input type="text" name="fullname" value="Trần Minh Khải" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="email" readonly>
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input type="text" name="phone" value="phone">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3><i class="fas fa-lock"></i> Thay đổi mật khẩu</h3>
                    <div class="form-group">
                        <label>Mật khẩu mới (Để trống nếu không đổi)</label>
                        <input type="password" name="new_password" placeholder="********">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Cập nhật thông tin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>