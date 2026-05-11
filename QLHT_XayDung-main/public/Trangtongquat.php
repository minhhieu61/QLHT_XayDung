<?php
/**
 * TRANG TỔNG QUAN - VLUTE CMS (Bản có hình nền)
 */
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Kiểm tra quyền truy cập
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='dangnhap.php';</script>";
    exit();
}

$ten_nhan_vien = $_SESSION['user'] ?? 'Thành viên'; 
$ma_nv         = $_SESSION['username'] ?? 'N/A';
$role          = $_SESSION['role'] ?? 'user'; 

$chuc_vu = "Nhân viên hệ thống";
if ($role === 'admin') $chuc_vu = "Quản trị viên cấp cao";
elseif ($role === 'manager') $chuc_vu = "Quản lý điều hành";

$ngay_hien_tai = date('d / m / Y');
$gio_hien_tai  = date('H:i');
$gio           = (int)date('H');

if ($gio >= 5 && $gio < 12) { $cau_chao = "Chào buổi sáng"; $icon_chao = "fa-sun"; }
elseif ($gio >= 12 && $gio < 18) { $cau_chao = "Buổi chiều năng suất"; $icon_chao = "fa-cloud-sun"; }
else { $cau_chao = "Buổi tối vui vẻ"; $icon_chao = "fa-moon"; }
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* Container chính có hình nền */
    .dashboard-welcome-container {
        width: 100%;
        min-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px;
        box-sizing: border-box;
        position: relative;
        /* THAY ĐỔI: Thêm hình nền tại đây */
        background-image: url('img/anhtruong31.jpg'); 
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        border-radius: 15px;
        overflow: hidden;
    }

    /* Lớp phủ mờ trên hình nền để chữ dễ đọc hơn */
    .dashboard-welcome-container::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(240, 242, 245, 0.6); /* Phủ lớp trắng mờ 60% */
        backdrop-filter: blur(5px); /* Làm mờ nhẹ hình nền */
        z-index: 1;
    }

    /* Thẻ Card nội dung (Nổi lên trên lớp phủ) */
    .welcome-glass-card {
        width: 100%;
        max-width: 1050px;
        background: linear-gradient(135deg, rgba(30, 60, 114, 0.95) 0%, rgba(42, 82, 152, 0.95) 100%);
        border-radius: 30px;
        padding: 50px 60px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        z-index: 2; /* Nổi lên trên lớp phủ nền */
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Phần nội dung chữ */
    .welcome-content { flex: 1; }
    .welcome-content h2 { 
        font-size: 1.1rem; 
        text-transform: uppercase; 
        letter-spacing: 2px; 
        margin-bottom: 15px; 
        color: rgba(255, 255, 255, 0.8); 
    }
    .welcome-content h1 { 
        font-size: 3.2rem; 
        margin: 0 0 20px 0; 
        font-weight: 800; 
    }
    .welcome-content p { 
        font-size: 1.1rem; 
        color: rgba(255, 255, 255, 0.9); 
        margin-bottom: 30px; 
        max-width: 500px; 
    }

    /* Badges thông tin */
    .info-badges { display: flex; gap: 12px; flex-wrap: wrap; }
    .badge-item {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 10px 18px;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.9rem;
    }

    /* Nút bấm */
    .btn-quick {
        margin-top: 40px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 15px 30px;
        background: #ffffff;
        color: #1e3c72;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 700;
        transition: 0.3s;
    }
    .btn-quick:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.2); }

    /* Icon trang trí mờ */
    .welcome-illustration i {
        font-size: 180px;
        color: rgba(255, 255, 255, 0.1);
    }

    @media (max-width: 992px) {
        .welcome-illustration { display: none; }
        .welcome-glass-card { padding: 40px; text-align: center; }
        .info-badges { justify-content: center; }
        .welcome-content h1 { font-size: 2.5rem; }
    }
</style>

<div class="dashboard-welcome-container">
    <div class="welcome-glass-card">
        <div class="welcome-content">
            <h2><i class="fas <?php echo $icon_chao; ?>"></i> <?php echo $cau_chao; ?></h2>
            <h1><?php echo htmlspecialchars($ten_nhan_vien); ?></h1>
            <p>Dữ liệu hệ thống đã sẵn sàng. Chúc bạn có một phiên làm việc hiệu quả tại VLUTE</p>
            
            <div class="info-badges">
                <div class="badge-item"><i class="fas fa-fingerprint"></i> ID: <?php echo htmlspecialchars($ma_nv); ?></div>
                <div class="badge-item"><i class="fas fa-shield-alt"></i> <?php echo $chuc_vu; ?></div>
                <div class="badge-item"><i class="far fa-clock"></i> <?php echo $gio_hien_tai; ?></div>
            </div>
        </div>
        <div class="welcome-illustration">
            <i class="fas fa-user-astronaut"></i>
        </div>
    </div>
</div>