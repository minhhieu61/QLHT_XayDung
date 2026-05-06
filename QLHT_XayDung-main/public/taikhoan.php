<?php
/** @var mysqli $conn */
include 'ketnoi.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 4; 
$sql_user = "SELECT * FROM accounts WHERE id = $user_id"; 
$res_user = mysqli_query($conn, $sql_user);

if ($res_user && mysqli_num_rows($res_user) > 0) {
    $user = mysqli_fetch_assoc($res_user);
} else {
    echo "Không tìm thấy dữ liệu cho ID: " . $user_id;
    exit;
}
?>

<link rel="stylesheet" href="css/taikhoan.css">

<div class="account-container">
    <header class="vattu-header-top">
        <div class="header-title-ql">
            <h1><i class="fas fa-user-circle"></i> TÀI KHOẢN CÁ NHÂN</h1>
            <p>Quản lý hồ sơ tại hệ thống VLUTE CMS</p>
        </div>
    </header>

    <div class="account-grid">
        <div class="account-card profile-sidebar">
            <div class="profile-usertitle">
                <div class="profile-name" id="display-fullname"><?php echo $user['fullname']; ?></div>
                <div class="profile-role">
                    <?php 
                        $roles = ['admin' => 'Quản trị viên', 'manager' => 'Quản lý', 'user' => 'Nhân viên'];
                        echo $roles[$user['role']] ?? 'Người dùng';
                    ?>
                </div>
            </div>
            <div class="profile-status">
                <span class="dot green"></span> Đang hoạt động
            </div>
        </div>

        <div class="account-card profile-content">
            <!-- Form sử dụng ID để xử lý AJAX -->
            <form id="form-taikhoan">
                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">

                <div class="form-section">
                    <h3><i class="fas fa-info-circle"></i> Thông tin tài khoản</h3>
                    <div class="form-group">
                        <label>Họ và tên</label>
                        <!-- Thêm disabled để khóa lúc đầu -->
                        <input type="text" name="fullname" id="input-fullname" value="<?php echo $user['fullname']; ?>" required disabled>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Tên đăng nhập (Username)</label>
                            <input type="text" value="<?php echo $user['username']; ?>" readonly style="background: #f0f0f0;">
                        </div>
                        <div class="form-group">
                            <label>Quyền hạn</label>
                            <input type="text" value="<?php echo strtoupper($user['role']); ?>" readonly style="background: #f0f0f0;">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3><i class="fas fa-lock"></i> Bảo mật</h3>
                    <div class="form-group">
                        <label>Mật khẩu mới</label>
                        <input type="password" name="new_password" id="input-password" placeholder="Để trống nếu không đổi" disabled>
                    </div>
                </div>

                <div class="form-actions">
                    <!-- Nút điều khiển chính -->
                    <button type="button" id="btn-main" class="btn-save" style="background: #000077; transition: all 0.3s ease;">
                        <i class="fas fa-edit"></i> CẬP NHẬT THÔNG TIN
                    </button>  
                </div>
            </form>
        </div>
    </div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const btnMain = document.getElementById('btn-main');
    const form = document.getElementById('form-taikhoan');
    const inputs = form.querySelectorAll('input[name="fullname"], input[name="new_password"]');
    let isEditing = false;

    btnMain.addEventListener('click', function() {
        if (!isEditing) {
            // Chế độ: Nhấn để sửa
            isEditing = true;
            inputs.forEach(input => input.disabled = false); // Mở khóa các ô
            inputs[0].focus();
            
            this.innerHTML = '<i class="fas fa-save"></i> LƯU THAY ĐỔI';
            this.style.backgroundColor = "#28a745"; // Đổi sang màu xanh lá
        } else {
            // Chế độ: Nhấn để lưu (Gửi AJAX)
            saveData();
        }
    });

    function saveData() {
        const formData = new FormData(form);
        formData.append('btnUpdate', 'true'); // Giả lập nút nhấn cho PHP

        fetch('xuly_taikhoan.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            // Hiển thị thông báo
            alert('Lưu thông tin thành công!');
            
            // Cập nhật lại giao diện
            document.getElementById('display-fullname').innerText = document.getElementById('input-fullname').value;
            
            // Khóa lại các ô nhập liệu
            isEditing = false;
            inputs.forEach(input => input.disabled = true);
            document.getElementById('input-password').value = ''; // Xóa mật khẩu đã nhập
            
            // Đưa nút về trạng thái ban đầu
            btnMain.innerHTML = '<i class="fas fa-edit"></i> CẬP NHẬT THÔNG TIN';
            btnMain.style.backgroundColor = "#000077";
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Có lỗi xảy ra khi lưu dữ liệu!');
        });
    }
});
</script>
</div>