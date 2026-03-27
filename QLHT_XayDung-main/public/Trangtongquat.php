<?php
// Dữ liệu giả lập (Sau này lấy từ Database hoặc Session sau khi Login)
$ten_nhan_vien = "Trần Minh Khải"; // Giả sử là bạn
$chuc_vu = "Nhân viên Phòng Quản trị"; 
$ngay_hien_tai = date('d/m/Y');
$gio_hien_tai = date('H:i');

// Câu chào cá nhân hóa dựa trên thời gian
$gio = date('H');
if ($gio < 12) {
    $cau_chao = "Buổi sáng tốt lành";
} elseif ($gio < 18) {
    $cau_chao = "Buổi chiều làm việc hiệu quả";
} else {
    $cau_chao = "Buổi tối vui vẻ";
}
?>

<link rel="stylesheet" href="css/tongquat.css">

<div class="welcome-screen-wrapper">
    <div class="background-image-cover"></div>
    
    <div class="welcome-card-modern">
        <div class="user-avatar-circle">
            <i class="fas fa-user-tie"></i>
        </div>
        
        <h1><?php echo $cau_chao; ?>, <?php echo $ten_nhan_vien; ?>! 👋</h1>
        <p>Chào mừng bạn đã đến với trang nhân viên VLUTE CMS. <br> 
        Vui lòng chọn các chức năng từ menu bên trái để bắt đầu công việc.</p>
        
        <div class="meta-info">
            <span title="Chức vụ hiện tại">
                <i class="fas fa-briefcase"></i> <?php echo $chuc_vu; ?>
            </span>
            <span title="Cập nhật">
                <i class="far fa-calendar-alt"></i> Ngày <?php echo $ngay_hien_tai; ?> | <i class="far fa-clock"></i> <?php echo $gio_hien_tai; ?>
            </span>
        </div>
    </div>
</div>