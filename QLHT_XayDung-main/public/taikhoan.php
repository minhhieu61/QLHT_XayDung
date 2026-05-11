<?php
/** @var mysqli $conn */
include 'ketnoi.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lấy thông tin từ Session thực tế, nếu không có mặc định lấy ID đầu tiên để test
$user_id = $_SESSION['user_id'] ?? 4; 
$sql_user = "SELECT * FROM accounts WHERE id = $user_id"; 
$res_user = mysqli_query($conn, $sql_user);
$user = mysqli_fetch_assoc($res_user);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    /* 1. Tông màu chủ đạo Deep Blue & Slate */
    :root {
        --primary-blue: #1e3c72;
        --accent-blue: #2a5298;
        --bg-slate: #f1f5f9;
        --text-dark: #1e293b;
    }

    .account-container {
        width: 100%;
        padding: 20px 40px;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* 2. Thanh Header Blue */
    .header-top-blue {
        background: linear-gradient(to right, var(--primary-blue), var(--accent-blue));
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        color: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .header-top-blue h1 { margin: 0; font-size: 24px; text-transform: uppercase; letter-spacing: 1px; }
    .header-top-blue p { margin: 10px 0 0 0; opacity: 0.8; font-size: 14px; }

    /* 3. Bố cục Grid 2 cột */
    .account-grid {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 30px;
        align-items: start;
    }

    /* 4. Sidebar Profile */
    .profile-sidebar {
        background: white;
        padding: 40px 20px;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .avatar-wrapper {
        width: 120px;
        height: 120px;
        background: #f0f4f8;
        border-radius: 50%;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 50px;
        color: var(--primary-blue);
        border: 4px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .profile-name { font-size: 20px; font-weight: 700; color: var(--text-dark); margin-bottom: 5px; }
    .profile-role-badge {
        display: inline-block;
        padding: 5px 15px;
        background: #e0e7ff;
        color: #4338ca;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 20px;
    }
    .status-active { color: #10b981; font-weight: 600; font-size: 14px; display: flex; align-items: center; justify-content: center; gap: 6px; }

    /* 5. Vùng nội dung chỉnh sửa */
    .profile-content {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .form-section { margin-bottom: 35px; }
    .form-section h3 {
        font-size: 16px;
        color: var(--primary-blue);
        border-bottom: 2px solid #f1f5f9;
        padding-bottom: 10px;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 15px; }
    .form-group label { font-weight: 600; color: #64748b; font-size: 13px; }
    
    .form-group input {
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 15px;
        background: #f8fafc;
        transition: 0.3s;
    }
    .form-group input:disabled { background: #f1f5f9; cursor: not-allowed; color: #94a3b8; }
    .form-group input:focus:not(:disabled) { border-color: var(--primary-blue); outline: none; background: white; box-shadow: 0 0 0 4px rgba(30, 60, 114, 0.1); }

    .full-width { grid-column: span 2; }

    /* 6. Nút bấm thao tác */
    .btn-main-action {
        width: 100%;
        padding: 15px;
        border: none;
        border-radius: 12px;
        color: white;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: 0.3s;
    }
</style>

<div class="account-container">
    <header class="header-top-blue">
        <div class="header-title-ql">
            <h1><i class="fas fa-id-card"></i> Thông tin tài khoản</h1>
            <p>Xin chào, <strong><?php echo $user['fullname']; ?></strong>! Bạn có thể xem và cập nhật hồ sơ cá nhân tại đây.</p>
        </div>
    </header>

    <div class="account-grid">
        <div class="profile-sidebar">
            <div class="avatar-wrapper">
                <i class="fas fa-user-circle"></i>
            </div>
            <div class="profile-name" id="display-fullname"><?php echo $user['fullname']; ?></div>
            <div class="profile-role-badge">
                <i class="fas fa-shield-alt"></i> 
                <?php 
                    $roles = ['admin' => 'QUẢN TRỊ VIÊN', 'manager' => 'QUẢN LÝ', 'user' => 'NHÂN VIÊN'];
                    echo $roles[$user['role']] ?? 'NGƯỜI DÙNG';
                ?>
            </div>
            <div class="status-active">
                <span style="width:10px; height:10px; background:#10b981; border-radius:50%"></span> Đang hoạt động
            </div>
        </div>

        <div class="profile-content">
            <form id="form-taikhoan">
                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">

                <div class="form-section">
                    <h3><i class="fas fa-user-edit"></i> Hồ sơ cá nhân</h3>
                    <div class="form-group">
                        <label>Họ và tên đầy đủ</label>
                        <input type="text" name="fullname" id="input-fullname" value="<?php echo $user['fullname']; ?>" required disabled>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Tên đăng nhập</label>
                            <input type="text" value="<?php echo $user['username']; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Cấp độ tài khoản</label>
                            <input type="text" value="<?php echo strtoupper($user['role']); ?>" disabled>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3><i class="fas fa-key"></i> Thay đổi mật khẩu</h3>
                    <div class="form-group">
                        <label>Mật khẩu mới</label>
                        <input type="password" name="new_password" id="input-password" placeholder="Nhập để đổi, để trống nếu không thay đổi" disabled>
                    </div>
                </div>

                <button type="button" id="btn-main" class="btn-main-action" style="background: var(--primary-blue);">
                    <i class="fas fa-edit"></i> CẬP NHẬT THÔNG TIN
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const btnMain = document.getElementById('btn-main');
    const inputs = document.querySelectorAll('#input-fullname, #input-password');
    let isEditing = false;

    btnMain.addEventListener('click', function() {
        if (!isEditing) {
            isEditing = true;
            inputs.forEach(i => i.disabled = false);
            inputs[0].focus();
            this.innerHTML = '<i class="fas fa-save"></i> LƯU THAY ĐỔI NGAY';
            this.style.background = "#10b981"; // Đổi sang màu xanh lá khi đang sửa
        } else {
            saveData();
        }
    });

    function saveData() {
        const formData = new FormData(document.getElementById('form-taikhoan'));
        formData.append('btnUpdate', 'true');

        fetch('xuly_taikhoan.php', { method: 'POST', body: formData })
        .then(response => response.text())
        .then(data => {
            alert('Thông tin của bạn đã được cập nhật!');
            document.getElementById('display-fullname').innerText = document.getElementById('input-fullname').value;
            isEditing = false;
            inputs.forEach(i => i.disabled = true);
            document.getElementById('input-password').value = '';
            btnMain.innerHTML = '<i class="fas fa-edit"></i> CẬP NHẬT THÔNG TIN';
            btnMain.style.background = "#1e3c72";
        })
        .catch(err => alert('Lỗi kết nối hệ thống!'));
    }
});
</script>