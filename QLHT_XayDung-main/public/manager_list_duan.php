<!-- <link rel="stylesheet" href="css/manager_list_duan.css">
<div class="project-list-container">
    <div class="list-header">
        <h2><i class="fas fa-project-diagram"></i> GIÁM SÁT DỰ ÁN</h2>

        <div class="filter-box">
            <div class="search-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Tìm tên dự án, chủ thầu...">
            </div>

            <select class="status-select" id="statusFilter">
                <option value="all">Tất cả trạng thái</option>
                <option value="ongoing">Đang thi công</option>
                <option value="warning">Trễ hạn</option>
                <option value="completed">Hoàn thành</option>
            </select>
        </div>
    </div>

    <div class="project-grid" id="projectGrid">
        <a href="manager_dashboard.php?p=giamsat_duan&id=1" class="project-card" data-status="ongoing">
            <div class="card-header">
                <span class="category">Hạ tầng</span>
                <span class="status-badge ongoing">Đang làm</span>
            </div>
            <h3>Cải tạo nhà học Khu A</h3>
            <div class="card-info">
                <span><i class="fas fa-user-tie"></i> Võ Minh Hiếu</span>
                <span><i class="fas fa-calendar-alt"></i> Deadline: 30/06/2026</span>
            </div>
            <div class="progress-container">
                <div class="progress-text"><span>Tiến độ</span><span>70%</span></div>
                <div class="progress-bar">
                    <div class="fill" style="width: 70%;"></div>
                </div>
            </div>
        </a>

    </div>
</div> -->
<?php
// 1. Cấu hình kết nối Cơ sở dữ liệu bằng MySQLi
$host = 'localhost';
$username = 'root'; // Thay đổi nếu bạn dùng user khác
$password = '';     // Thay đổi nếu bạn có cài password cho MySQL
$dbname = 'qlht_xaydung_vlute';

// Khởi tạo kết nối
$conn = new mysqli($host, $username, $password, $dbname);

// Kiểm tra kết nối có lỗi không
if ($conn->connect_error) {
    die("Lỗi kết nối cơ sở dữ liệu: " . $conn->connect_error);
}

// Cấu hình hiển thị tiếng Việt chuẩn UTF-8
$conn->set_charset("utf8");

// 2. Truy vấn lấy danh sách dự án
$sql = "SELECT id, ten_du_an, nguoi_phu_trach_cdt, vi_tri, trang_thai FROM duan ORDER BY id DESC";
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
                <option value="ongoing">Đang thi công</option>
                <option value="warning">Trễ hạn</option>
                <option value="completed">Hoàn thành</option>
            </select>
        </div>
    </div>

    <div class="project-grid" id="projectGrid">
        <?php
        // Kiểm tra xem có dòng dữ liệu nào trả về không
        if ($result && $result->num_rows > 0):
            // Duyệt qua từng dòng dữ liệu bằng vòng lặp while
            while ($row = $result->fetch_assoc()):

                // Xử lý Class và Text hiển thị cho Badge Trạng thái dựa trên CSDL
                $statusClass = 'ongoing';
                $statusText = 'Đang làm';
                $dataStatus = 'ongoing';

                if ($row['trang_thai'] == 'warning' || $row['trang_thai'] == 'Trễ hạn') {
                    $statusClass = 'warning';
                    $statusText = 'Trễ hạn';
                    $dataStatus = 'warning';
                } elseif ($row['trang_thai'] == 'completed' || $row['trang_thai'] == 'Hoàn thành') {
                    $statusClass = 'completed';
                    $statusText = 'Hoàn thành';
                    $dataStatus = 'completed';
                }
        ?>
                <a href="manager_dashboard.php?p=giamsat_duan&id=<?php echo $row['id']; ?>" class="project-card" data-status="<?php echo $dataStatus; ?>">
                    <div class="card-header">
                        <!-- <span class="category">Hạ tầng</span> -->
                        <span class="status-badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                    </div>
                    <h3><?php echo htmlspecialchars($row['ten_du_an']); ?></h3>

                    <div class="card-info">
                        <span><i class="fas fa-user-tie"></i> <?php echo htmlspecialchars($row['nguoi_phu_trach_cdt']); ?></span>
                        <span><i class="fas fa-map-marker-alt"></i> Vị trí: <?php echo htmlspecialchars($row['vi_tri']); ?></span>
                    </div>

                    <!-- <div class="progress-container">
                        <div class="progress-text"><span>Tiến độ</span><span>70%</span></div>
                        <div class="progress-bar">
                            <div class="fill" style="width: 70%;"></div>
                        </div>
                    </div> -->
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
        // Đóng kết nối sau khi xử lý xong để giải phóng tài nguyên tài nguyên RAM
        $conn->close();
        ?>
    </div>
</div>

<script src="js/giamsat_duan.js"></script>