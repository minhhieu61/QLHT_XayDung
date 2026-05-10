<?php
// 1. Kết nối cơ sở dữ liệu
include_once 'ketnoi.php'; 

/** @var mysqli $conn */ 
if (!$conn) {
    die("Lỗi kết nối cơ sở dữ liệu. Vui lòng kiểm tra file ketnoi.php");
}

// 2. Truy vấn lấy danh sách tài liệu
$sql = "SELECT * FROM tai_lieu ORDER BY ngay_tai DESC";
$result = mysqli_query($conn, $sql);
?>

<link rel="stylesheet" href="css/tranghoso.css">

<div class="archive-wrapper">
    <div class="archive-header">
        <div class="header-title">
            <h2><i class="fas fa-folder-open"></i> Lưu trữ Hồ sơ & Tài liệu</h2>
            <p>Quản lý bản vẽ, hợp đồng và biên bản nghiệm thu tập trung</p>
        </div>
        <div class="header-actions">
            <a href="trangchu.php?p=themhoso" class="btn-primary" style="text-decoration: none;">
                <i class="fas fa-upload"></i> Tải tài liệu mới
            </a>
        </div>
    </div>

    <div class="archive-filter-bar">
        <div class="search-input">
            <i class="fas fa-search"></i>
            <input type="text" id="aiSearch" placeholder="Tìm tên hồ sơ, mã dự án hoặc kết quả AI...">
        </div>
    </div>

    <div class="file-list-section">
        <h3>Danh mục tài liệu hệ thống</h3>
        <table class="file-table" id="fileTable">
            <thead>
                <tr>
                    <th>Tên tài liệu</th>
                    <th>Trạng thái AI</th>
                    <th>Dự án</th>
                    <th>Ngày tải</th>
                    <th style="text-align: center;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) { 
                        // Cấu hình màu sắc Badge AI
                        $ai_color = '#28a745'; // Mặc định: Normal (Xanh)
                        if ($row['ai_status'] == 'Duplicate') $ai_color = '#dc3545'; // Đỏ
                        if ($row['ai_status'] == 'Warning') $ai_color = '#ffc107';   // Vàng
                ?>
                <tr>
                    <td>
                        <div class="file-info">
                            <i class="fas fa-file-pdf pdf-icon"></i>
                            <strong><?php echo htmlspecialchars($row['ten_tai_lieu']); ?></strong>
                        </div>
                    </td>
                    <td>
                        <span class="ai-badge" style="background: <?php echo $ai_color; ?>; color: #fff; padding: 4px 8px; border-radius: 12px; font-size: 12px;">
                            <i class="fas fa-robot"></i> <?php echo $row['ai_status']; ?> (<?php echo $row['ai_score']; ?>%)
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($row['ma_du_an'] ?? 'N/A'); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($row['ngay_tai'])); ?></td>
                    <td class="file-actions">
                        <a href="trangchu.php?p=xemchitiet&id=<?php echo $row['id']; ?>" class="btn-action btn-view" title="Xem chi tiết">
                            <i class="fas fa-eye"></i> Xem
                        </a>
                        <a href="<?php echo htmlspecialchars($row['duong_dan']); ?>" class="btn-action btn-download" download title="Tải về">
                            <i class="fas fa-download"></i>
                        </a>
                        <button class="btn-action btn-del" onclick="confirmDelete(<?php echo $row['id']; ?>)" title="Xóa">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php 
                    } 
                } else {
                    echo "<tr><td colspan='5' style='text-align:center;'>Chưa có hồ sơ nào được lưu trữ.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// Hàm xác nhận xóa
function confirmDelete(id) {
    if(confirm('Bạn có chắc muốn xóa tài liệu này? Kết quả AI liên quan cũng sẽ bị mất.')) {
        window.location.href = 'xuly_xoahoso.php?id=' + id;
    }
}

// Bộ lọc tìm kiếm nhanh (Live Search)
document.getElementById('aiSearch').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#fileTable tbody tr');
    
    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>