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

// 2. Lấy ID dự án từ URL định dạng an toàn
$project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 3. Truy vấn dữ liệu chi tiết của dự án
$sql_project = "SELECT ten_du_an, ma_da, ngay_tao, trang_thai, vi_tri, nguoi_phu_trach_cdt, id_nha_thau, chu_dau_tu FROM duan WHERE id = ?";
$stmt = $conn->prepare($sql_project);
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result_project = $stmt->get_result();

if ($result_project->num_rows > 0) {
    $project = $result_project->fetch_assoc();
} else {
    die("<div class='project-detail-wrapper'><h3>Không tìm thấy dự án yêu cầu hoặc ID không hợp lệ!</h3></div>");
}

// 4. Lấy danh sách phục vụ cho danh mục sổ xuống (Select Option) trong Popup
$users_result = $conn->query("SELECT DISTINCT nguoi_phu_trach_cdt FROM duan WHERE nguoi_phu_trach_cdt IS NOT NULL AND nguoi_phu_trach_cdt != ''");
$contractors_result = $conn->query("SELECT DISTINCT id_nha_thau FROM duan WHERE id_nha_thau IS NOT NULL AND id_nha_thau != ''");

// Kiểm tra xem dự án đã được phân công nhân sự hay chưa để đổi tên nút (Thêm / Sửa)
$is_assigned = (!empty($project['nguoi_phu_trach_cdt']) || !empty($project['id_nha_thau']));
?>

<link rel="stylesheet" href="css/manager_chitiet_duan.css">

<div class="project-detail-wrapper">
    <div class="project-detail-header">
        <div class="header-info">
            <span class="back-link">
                <a href="manager_dashboard.php?p=giamsat_duan"><i class="fas fa-arrow-left"></i> Quay lại</a>
            </span>
            <h2><?php echo htmlspecialchars($project['ten_du_an']); ?></h2>
            <p>Mã dự án: <strong><?php echo htmlspecialchars($project['ma_da']); ?></strong> | Ngày tạo: <?php echo date('d/m/Y', strtotime($project['ngay_tao'])); ?></p>
            <p style="margin-top: 5px; color: #7f8c8d;"><i class="fas fa-map-marker-alt"></i> Vị trí: <?php echo htmlspecialchars($project['vi_tri']); ?></p>
        </div>

        <div class="header-right-zone">
            <?php
            // Xử lý badge trạng thái sinh động dựa vào CSDL
            $statusClass = 'badge-ongoing';
            $statusText = htmlspecialchars($project['trang_thai']);
            if ($project['trang_thai'] == 'Trễ hạn' || $project['trang_thai'] == 'warning') $statusClass = 'badge-warning';
            if ($project['trang_thai'] == 'Hoàn thành' || $project['trang_thai'] == 'completed') $statusClass = 'badge-completed';
            ?>
            <span class="badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>

            <?php if ($is_assigned): ?>
                <button class="btn-open-popup btn-edit-assignment" onclick="toggleModal(true)">
                    <i class="fas fa-user-edit"></i> Sửa nhân sự / Thầu
                </button>
            <?php else: ?>
                <button class="btn-open-popup" onclick="toggleModal(true)">
                    <i class="fas fa-user-plus"></i> Chỉ định nhân sự / Thầu
                </button>
            <?php endif; ?>
        </div>
    </div>

    <div class="project-summary-cards">
        <div class="summary-card">
            <i class="fas fa-user-tie"></i>
            <div>
                <label>Người phụ trách (CĐT)</label>
                <span><?php echo !empty($project['nguoi_phu_trach_cdt']) ? htmlspecialchars($project['nguoi_phu_trach_cdt']) : 'Chưa phân công'; ?></span>
            </div>
        </div>
        <div class="summary-card">
            <i class="fas fa-building"></i>
            <div>
                <label>Nhà thầu (ID/Tên)</label>
                <span><?php echo !empty($project['id_nha_thau']) ? htmlspecialchars($project['id_nha_thau']) : 'Chưa chỉ định'; ?></span>
            </div>
        </div>
        <div class="summary-card">
            <i class="fas fa-university"></i>
            <div>
                <label>Chủ đầu tư</label>
                <span><?php echo !empty($project['chu_dau_tu']) ? htmlspecialchars($project['chu_dau_tu']) : 'VLUTE'; ?></span>
            </div>
        </div>
        <div class="summary-card deadline-card">
            <i class="fas fa-calendar-check"></i>
            <div>
                <label>Hoàn thành dự kiến</label>
                <span class="text-danger">30/06/2026</span>
            </div>
        </div>
    </div>

    <div class="tabs-container">
        <div class="tabs-header">
            <button class="tab-btn active" onclick="openTab(event, 'tong-quan')">Tổng quan</button>
            <!-- <button class="tab-btn" onclick="openTab(event, 'vattu')">Vật tư & Thiết bị</button> -->
            <button class="tab-btn" onclick="openTab(event, 'kinh-phi')">Kinh phí & Hóa đơn</button>
        </div>

        <div class="tabs-content">
            <div id="tong-quan" class="tab-pane active">
                <h3>Mô tả dự án</h3>
                <p>Dự án tập trung vào việc cải tạo hệ thống điện, sơn sửa lại tường và thay mới thiết bị chiếu sáng tại địa điểm được chỉ định.</p>
            </div>

            <div id="vattu" class="tab-pane">
                <h3>Danh sách vật tư sử dụng</h3>
                <p>Dữ liệu vật tư đang được liệt kê từ kho tổng...</p>
            </div>

            <div id="kinh-phi" class="tab-pane">
                <h3>Chi tiết tài chính</h3>
                <p>Thông báo các khoản chi thực tế và dự phòng...</p>
            </div>
        </div>
    </div>
</div>

<div class="modal-overlay" id="assignmentModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fas fa-user-edit"></i> <?php echo $is_assigned ? 'Cập nhật phân công' : 'Chỉ định nhân sự & Nhà thầu'; ?></h3>
            <span class="close-modal" onclick="toggleModal(false)">&times;</span>
        </div>
        <form action="" method="POST">
            <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">

            <div class="form-group">
                <label for="select_phutrach"><i class="fas fa-user-shield"></i> Chọn người phụ trách (CĐT):</label>
                <select name="nguoi_phu_trach_cdt" id="select_phutrach" required>
                    <option value="">-- Chọn nhân sự --</option>
                    <option value="Võ Minh Hiếu" <?php echo ($project['nguoi_phu_trach_cdt'] == 'Võ Minh Hiếu') ? 'selected' : ''; ?>>Võ Minh Hiếu</option>
                    <?php
                    if ($users_result) {
                        while ($u = $users_result->fetch_assoc()) {
                            if ($u['nguoi_phu_trach_cdt'] != 'Võ Minh Hiếu') {
                                $selected = ($project['nguoi_phu_trach_cdt'] == $u['nguoi_phu_trach_cdt']) ? 'selected' : '';
                                echo "<option value='" . htmlspecialchars($u['nguoi_phu_trach_cdt']) . "' $selected>" . htmlspecialchars($u['nguoi_phu_trach_cdt']) . "</option>";
                            }
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="select_nhathau"><i class="fas fa-handshake"></i> Chọn Đơn vị / ID Nhà thầu:</label>
                <select name="id_nha_thau" id="select_nhathau" required>
                    <option value="">-- Chọn nhà thầu --</option>
                    <option value="Công ty XD Tiền Giang" <?php echo ($project['id_nha_thau'] == 'Công ty XD Tiền Giang') ? 'selected' : ''; ?>>Công ty XD Tiền Giang</option>
                    <?php
                    if ($contractors_result) {
                        while ($c = $contractors_result->fetch_assoc()) {
                            if ($c['id_nha_thau'] != 'Công ty XD Tiền Giang') {
                                $selected = ($project['id_nha_thau'] == $c['id_nha_thau']) ? 'selected' : '';
                                echo "<option value='" . htmlspecialchars($c['id_nha_thau']) . "' $selected>" . htmlspecialchars($c['id_nha_thau']) . "</option>";
                            }
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="toggleModal(false)">Hủy bỏ</button>
                <button type="submit" name="btn_submit_update" class="btn-submit">Xác nhận cập nhật</button>
            </div>
        </form>
    </div>
</div>

<?php
// 5. Logic xử lý lưu dữ liệu (Gửi POST về chính trang hiện tại)
if (isset($_POST['btn_submit_update'])) {
    $p_id = intval($_POST['project_id']);
    $npc = $_POST['nguoi_phu_trach_cdt'];
    $nt = $_POST['id_nha_thau'];

    $sql_update = "UPDATE duan SET nguoi_phu_trach_cdt = ?, id_nha_thau = ? WHERE id = ?";
    $stmt_up = $conn->prepare($sql_update);
    $stmt_up->bind_param("ssi", $npc, $nt, $p_id);

    if ($stmt_up->execute()) {
        echo "<script>alert('Cập nhật thông tin phân công thành công!'); window.location.href='manager_dashboard.php?p=giamsat_duan&id=" . $p_id . "';</script>";
    } else {
        echo "<script>alert('Lỗi hệ thống! Vui lòng thử lại.');</script>";
    }
    $stmt_up->close();
}
$conn->close();
?>

<script src="js/manager_chitiet_duan.js"></script>

<script>
    // Hàm thực hiện đóng và mở Popup mềm mại thông qua Class CSS
    function toggleModal(show) {
        const modal = document.getElementById('assignmentModal');
        if (show) {
            modal.classList.add('open');
        } else {
            modal.classList.remove('open');
        }
    }
</script>