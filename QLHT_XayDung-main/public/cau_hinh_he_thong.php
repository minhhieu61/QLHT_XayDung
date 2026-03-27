<?php $current_page = 'config'; ?>
<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: dangnhap.php");
    exit();
}
include __DIR__ . '/../resources/views/layouts/admin/admin_header.php';
include __DIR__ . '/../resources/views/layouts/admin/admin_sidebar.php';
?>

<main class="content-area">
    <header class="main-header">
        <h1><i class="fas fa-cogs"></i> CẤU HÌNH HỆ THỐNG</h1>
        <p>Tùy chỉnh thông tin website, logo và trạng thái vận hành.</p>
    </header>

    <form action="process_config.php" method="POST" enctype="multipart/form-data">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
            
            <div style="background:#fff; padding:25px; border-radius:15px; box-shadow:0 4px 15px rgba(0,0,0,0.05);">
                <h3 style="margin-bottom:20px; border-bottom:2px solid #f1f1f1; padding-bottom:10px;">Thông tin chung</h3>
                
                <div style="margin-bottom:15px;">
                    <label><b>Tên Website:</b></label>
                    <input type="text" name="web_name" value="Hệ thống quản lý công trình" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px; margin-top:5px;">
                </div>

                <div style="margin-bottom:15px;">
                    <label><b>Số điện thoại hỗ trợ:</b></label>
                    <input type="text" name="web_phone" value="0270 3822141" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px; margin-top:5px;">
                </div>

                <div style="margin-bottom:15px;">
                    <label><b>Email thông báo:</b></label>
                    <input type="email" name="web_email" value="admin@vlute.edu.vn" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px; margin-top:5px;">
                </div>
            </div>

            <div style="background:#fff; padding:25px; border-radius:15px; box-shadow:0 4px 15px rgba(0,0,0,0.05);">
                <h3 style="margin-bottom:20px; border-bottom:2px solid #f1f1f1; padding-bottom:10px;">Logo & Giao diện</h3>
                
                <div style="margin-bottom:15px;">
                    <label><b>Thay đổi Logo:</b></label>
                    <input type="file" name="web_logo" style="margin-top:10px; display:block;">
                    <small style="color:#888;">Định dạng: PNG, JPG (Khuyên dùng 200x200px)</small>
                </div>

                <div style="margin-bottom:15px;">
                    <label><b>Màu chủ đạo hệ thống:</b></label>
                    <div style="display:flex; gap:10px; margin-top:10px;">
                        <input type="color" name="theme_color" value="#1a237e" style="height:40px; width:60px; border:none; cursor:pointer;">
                        <span style="color:#666; font-size:14px;">Chọn màu cho thanh Sidebar và nút bấm</span>
                    </div>
                </div>
            </div>

            <div style="background:#fff; padding:25px; border-radius:15px; box-shadow:0 4px 15px rgba(0,0,0,0.05); grid-column: span 2;">
                <h3 style="margin-bottom:20px; border-bottom:2px solid #f1f1f1; padding-bottom:10px;">Quản lý vận hành</h3>
                
                <div style="display:flex; justify-content:space-between; align-items:center; background:#fff9e6; padding:15px; border-radius:10px; border:1px solid #ffeeba;">
                    <div>
                        <strong style="color:#856404;"><i class="fas fa-tools"></i> Chế độ bảo trì (Maintenance Mode)</strong>
                        <p style="margin:5px 0 0 0; font-size:13px; color:#856404;">Khi bật, chỉ Admin mới truy cập được trang quản trị. Người dùng khác sẽ thấy thông báo bảo trì.</p>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="maintenance_mode">
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>

        <div style="margin-top:20px; text-align:right;">
            <button type="reset" style="padding:12px 25px; background:#eee; border:none; border-radius:8px; cursor:pointer; margin-right:10px;">Hủy bỏ</button>
            <button type="submit" class="btn-add-account" style="padding:12px 40px; font-weight:bold;">LƯU TẤT CẢ CÀI ĐẶT</button>
        </div>
    </form>
</main>

<style>
.switch { position: relative; display: inline-block; width: 60px; height: 30px; }
.switch input { opacity: 0; width: 0; height: 0; }
.slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 34px; }
.slider:before { position: absolute; content: ""; height: 22px; width: 22px; left: 4px; bottom: 4px; background-color: white; transition: .4s; border-radius: 50%; }
input:checked + .slider { background-color: #f1c40f; }
input:checked + .slider:before { transform: translateX(30px); }
.action-buttons {
    display: flex; /* Dàn hàng ngang */
    gap: 10px; /* Khoảng cách giữa các nút */
    justify-content: center; /* Căn giữa ô <td> */
    align-items: center; /* Căn giữa theo chiều dọc */
}

/* Style chung cho các nút icon nhỏ */
.btn-icon {
    border: none;
    background: none;
    cursor: pointer;
    font-size: 16px; /* Chỉnh icon to lên cho dễ nhấn */
    padding: 5px;
    transition: all 0.2s;
}

/* Đổi màu khi rê chuột vào */
.btn-download:hover { color: #3498db; transform: scale(1.1); } /* Xanh dương */
.btn-restore:hover { color: #9b59b6; transform: scale(1.1); }  /* Tím */
.btn-delete:hover { color: #e74c3c; transform: scale(1.1); }   /* Đỏ */
</style>

<?php include __DIR__ . '/../resources/views/layouts/admin/admin_footer.php'; ?>