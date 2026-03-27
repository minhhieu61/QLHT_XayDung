<?php
// BƯỚC 1: ĐẶT TÊN TRANG ĐỂ SIDEBAR BIẾT ĐƯỜNG MÀ HIỆN MÀU XANH
$current_page = 'backup'; 

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: dangnhap.php");
    exit();
}

include __DIR__ . '/../resources/views/layouts/admin/admin_header.php';
include __DIR__ . '/../resources/views/layouts/admin/admin_sidebar.php';
?>

<style>
    /* Canh giữa các nút trong ô Thao tác */
    .action-buttons {
        display: flex;
        gap: 12px;
        justify-content: center;
        align-items: center;
    }

    /* Định dạng chung cho nút icon */
    .btn-icon {
        border: none;
        background: #f8f9fa; /* Nền xám nhạt cho chuyên nghiệp */
        padding: 8px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 14px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    /* Hiệu ứng màu sắc khi rê chuột (Hover) */
    .btn-download { color: #3498db; } /* Xanh dương */
    .btn-restore { color: #9b59b6; }  /* Tím */
    .btn-delete { color: #e74c3c; }   /* Đỏ */

    .btn-icon:hover {
        transform: translateY(-2px); /* Nhấc nút lên nhẹ */
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .btn-download:hover { background: #3498db; color: #fff; }
    .btn-restore:hover { background: #9b59b6; color: #fff; }
    .btn-delete:hover { background: #e74c3c; color: #fff; }
</style>

<main class="content-area">
    <header class="main-header">
        <h1><i class="fas fa-database"></i> SAO LƯU & KHÔI PHỤC</h1>
        <p>Quản lý an toàn dữ liệu hệ thống xây dựng.</p>
    </header>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-top: 20px;">
        
        <div style="background:#fff; padding:20px; border-radius:15px; box-shadow:0 4px 15px rgba(0,0,0,0.05);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h3 style="margin:0;">Lịch sử các bản sao lưu</h3>
                <button onclick="handleBackup()" class="btn-add-account" style="background:#2ecc71; border:none; padding:10px 20px; color:#fff; border-radius:8px; cursor:pointer;">
                    <i class="fas fa-plus"></i> SAO LƯU NGAY
                </button>
            </div>

            <table class="admin-table" style="width:100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa;">
                        <th style="padding:12px;">Ngày tạo</th>
                        <th>Dung lượng</th>
                        <th>Người thực hiện</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding:12px; text-align:center;">22/03/2026 08:15</td>
                        <td style="text-align:center;">3.2 MB</td>
                        <td style="text-align:center;">Admin_Hiếu</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-icon btn-download" title="Tải về"><i class="fas fa-download"></i></button>
                                <button class="btn-icon btn-restore" title="Khôi phục" onclick="return confirm('Khôi phục sẽ ghi đè dữ liệu hiện tại. Tiếp tục?')"><i class="fas fa-undo"></i></button>
                                <button class="btn-icon btn-delete" title="Xóa"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:12px; text-align:center;">15/03/2026 14:00</td>
                        <td style="text-align:center;">2.8 MB</td>
                        <td style="text-align:center;">Admin_Hiếu</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-icon btn-download" title="Tải về"><i class="fas fa-download"></i></button>
                                <button class="btn-icon btn-restore" title="Khôi phục" onclick="return confirm('Khôi phục sẽ ghi đè dữ liệu hiện tại. Tiếp tục?')"><i class="fas fa-undo"></i></button>
                                <button class="btn-icon btn-delete" title="Xóa"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="background:#fff; padding:20px; border-radius:15px; box-shadow:0 4px 15px rgba(0,0,0,0.05); text-align:center;">
            <h3 style="margin-bottom:25px;">Tình trạng bộ nhớ</h3>
            
            <div style="width:150px; height:150px; border-radius:50%; background: conic-gradient(#3498db 70%, #eee 0); margin: 0 auto; display:flex; align-items:center; justify-content:center; position:relative;">
                <div style="width:110px; height:110px; background:#fff; border-radius:50%; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                    <strong style="font-size:24px;">70%</strong>
                    <small style="color:#888;">Đã dùng</small>
                </div>
            </div>

            <div style="margin-top:30px; text-align:left; font-size:14px;">
                <p><i class="fas fa-circle" style="color:#3498db"></i> <b>Database:</b> 15.5 MB</p>
                <p><i class="fas fa-circle" style="color:#eee"></i> <b>Còn trống:</b> 6.5 MB</p>
                <hr style="border:0; border-top:1px solid #eee; margin:15px 0;">
                <p style="color:#e74c3c; font-weight:bold;"><i class="fas fa-exclamation-triangle"></i> Lưu ý: Nên dọn dẹp log cũ để tối ưu bộ nhớ.</p>
            </div>
        </div>
    </div>
</main>

<script>
function handleBackup() {
    if(confirm("Hệ thống sẽ tiến hành đóng băng database và xuất file SQL. Tiếp tục?")) {
        alert("Đang xử lý... Vui lòng không tắt trình duyệt!");
        setTimeout(() => { 
            alert("Sao lưu thành công! Bản sao lưu đã được thêm vào danh sách."); 
        }, 1500);
    }
}
</script>

<?php include __DIR__ . '/../resources/views/layouts/admin/admin_footer.php'; ?>