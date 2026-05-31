<?php
// 1. Cấu hình kết nối Cơ sở dữ liệu bằng MySQLi
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'qlht_xaydung_vlute';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Lỗi kết nối cơ sở dữ liệu: " . $conn->connect_error);
}
$conn->set_charset("utf8");

// 2. SỬA LẠI SQL: Lấy thẳng cột nguoi_phu_trach_cdt vì nó đang lưu dạng chữ (Text)
$sql = "SELECT id, ten_du_an, vi_tri, trang_thai, nguoi_phu_trach_cdt 
        FROM duan 
        ORDER BY id DESC";
$result = $conn->query($sql);
?>

<link rel="stylesheet" href="css/manager_list_duan.css">
<div class="project-list-container">
    <div class="list-header">
        <h2><i class="fas fa-project-diagram"></i> GIÁM SÁT DỰ ÁN</h2>

        <div class="filter-box">
            <div class="search-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Tìm tên dự án, người phụ trách...">
            </div>

            <select class="status-select" id="statusFilter">
                <option value="all">Tất cả trạng thái</option>
                <option value="ongoing">Đang thực hiện</option>
                <option value="paused">Tạm dừng</option>
                <option value="completed">Hoàn thành</option>
            </select>
        </div>
    </div>

    <div class="project-grid" id="projectGrid">
        <?php
        if ($result && $result->num_rows > 0):
            while ($row = $result->fetch_assoc()):

                // Mặc định ban đầu
                $statusClass = 'ongoing';
                $statusText = 'Đang thực hiện';
                $dataStatus = 'ongoing';

                // Kiểm tra điều kiện chuẩn theo 3 trạng thái của bạn
                if ($row['trang_thai'] == 'Tạm dừng' || $row['trang_thai'] == 'paused') {
                    $statusClass = 'warning';
                    $statusText = 'Tạm dừng';
                    $dataStatus = 'paused';
                } elseif ($row['trang_thai'] == 'Hoàn thành' || $row['trang_thai'] == 'completed') {
                    $statusClass = 'completed';
                    $statusText = 'Hoàn thành';
                    $dataStatus = 'completed';
                }

                // SỬA DÒNG NÀY: Đọc trực tiếp biến từ bảng duan
                $phuTrachText = !empty($row['nguoi_phu_trach_cdt']) ? $row['nguoi_phu_trach_cdt'] : 'Chưa phân công';
        ?>
                <a href="manager_dashboard.php?p=giamsat_duan&id=<?php echo $row['id']; ?>"
                    class="project-card"
                    data-status="<?php echo $dataStatus; ?>"
                    data-search-keyword="<?php echo mb_strtolower($row['ten_du_an'] . ' ' . $phuTrachText, 'UTF-8'); ?>">

                    <div class="card-header">
                        <span class="status-badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                    </div>
                    <h3><?php echo htmlspecialchars($row['ten_du_an']); ?></h3>

                    <div class="card-info">
                        <span><i class="fas fa-user-tie"></i> <?php echo htmlspecialchars($phuTrachText); ?></span>
                        <span><i class="fas fa-map-marker-alt"></i> Vị trí: <?php echo htmlspecialchars($row['vi_tri']); ?></span>
                    </div>
                </a>
            <?php
            endwhile;
        else:
            ?>
            <div class="no-data" style="grid-column: 1/-1; text-align: center; padding: 30px; color: #64748b;">
                <i class="fas fa-folder-open" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                Chưa có dữ liệu dự án nào trong hệ thống.
            </div>
        <?php
        endif;
        $conn->close();
        ?>

        <div id="noResults" class="no-data" style="display: none; grid-column: 1/-1; text-align: center; padding: 30px; color: #64748b;">
            <i class="fas fa-search-minus" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
            Không tìm thấy dự án nào phù hợp với bộ lọc hiện tại.
        </div>
    </div>
</div>

<script src="js/manager_list_duan.js"></script>