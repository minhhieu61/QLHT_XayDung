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

// ==========================================
// KHỐI LOGIC PHP XỬ LÝ LƯU DỮ LIỆU (ĐẦU TRANG)
// ==========================================

// A. Xử lý cập nhật Nhân sự, Nhà thầu, TỔNG KINH PHÍ & TRẠNG THÁI DỰ ÁN
if (isset($_POST['btn_submit_update'])) {
    $p_id = intval($_POST['project_id']);
    $npc = $_POST['nguoi_phu_trach_cdt'];
    $nt = intval($_POST['id_nha_thau']);
    $kp = floatval($_POST['tong_kinh_phi']);
    $tt = trim($_POST['trang_thai']); // Lấy trạng thái mới từ form

    // Thêm trường trang_thai vào câu lệnh UPDATE
    $sql_update = "UPDATE duan SET nguoi_phu_trach_cdt = ?, id_nha_thau = ?, tong_kinh_phi = ?, trang_thai = ? WHERE id = ?";
    $stmt_up = $conn->prepare($sql_update);
    $stmt_up->bind_param("siisi", $npc, $nt, $kp, $tt, $p_id);

    if ($stmt_up->execute()) {
        echo "<script>alert('Cập nhật thông tin phân công, kinh phí và trạng thái thành công!'); window.location.href='manager_dashboard.php?p=giamsat_duan&id=" . $p_id . "';</script>";
        exit;
    } else {
        echo "<script>alert('Lỗi hệ thống khi cập nhật: " . addslashes($stmt_up->error) . "');</script>";
    }
    $stmt_up->close();
}

// B. Xử lý cập nhật MÔ TẢ CHI TIẾT DỰ ÁN
if (isset($_POST['btn_submit_description'])) {
    $p_id = intval($_POST['project_id']);
    $mo_ta_moi = trim($_POST['mo_ta']);

    $sql_update_desc = "UPDATE duan SET mo_ta = ? WHERE id = ?";
    $stmt_desc = $conn->prepare($sql_update_desc);
    $stmt_desc->bind_param("si", $mo_ta_moi, $p_id);

    if ($stmt_desc->execute()) {
        echo "<script>alert('Cập nhật mô tả chi tiết dự án thành công!'); window.location.href='manager_dashboard.php?p=giamsat_duan&id=" . $p_id . "';</script>";
        exit;
    } else {
        echo "<script>alert('Lỗi hệ thống khi cập nhật mô tả: " . addslashes($stmt_desc->error) . "');</script>";
    }
    $stmt_desc->close();
}

// C. Xử lý thêm HÓA ĐƠN phát sinh mới
if (isset($_POST['btn_submit_invoice'])) {
    $p_id = intval($_POST['project_id']);
    $ten_chi_phi = trim($_POST['ten_chi_phi']);
    $so_tien = floatval($_POST['so_tien']);
    $ngay_thanh_toan = $_POST['ngay_thanh_toan'];
    $ghi_chu = trim($_POST['ghi_chu']);

    $sql_insert_inv = "INSERT INTO hoa_don (id_du_an, ten_chi_phi, so_tien, ngay_thanh_toan, ghi_chu) VALUES (?, ?, ?, ?, ?)";
    $stmt_inv_add = $conn->prepare($sql_insert_inv);
    $stmt_inv_add->bind_param("isdss", $p_id, $ten_chi_phi, $so_tien, $ngay_thanh_toan, $ghi_chu);

    if ($stmt_inv_add->execute()) {
        echo "<script>alert('Thêm hóa đơn chứng từ mới thành công!'); window.location.href='manager_dashboard.php?p=giamsat_duan&id=" . $p_id . "';</script>";
        exit;
    } else {
        echo "<script>alert('Lỗi hệ thống không thể thêm hóa đơn: " . addslashes($stmt_inv_add->error) . "');</script>";
    }
    $stmt_inv_add->close();
}

// 3. Truy vấn dữ liệu chi tiết của dự án
$sql_project = "SELECT d.*, c.ten_don_vi 
                FROM duan d 
                LEFT JOIN chuthau c ON d.id_nha_thau = c.id 
                WHERE d.id = ?";
$stmt = $conn->prepare($sql_project);
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result_project = $stmt->get_result();

if ($result_project->num_rows > 0) {
    $project = $result_project->fetch_assoc();
} else {
    die("<div class='project-detail-wrapper'><h3>Không tìm thấy dự án yêu cầu!</h3></div>");
}

// 3.1. Truy vấn danh sách các khoản chi phí/hóa đơn thuộc dự án này
$sql_invoices = "SELECT * FROM hoa_don WHERE id_du_an = ? ORDER BY ngay_thanh_toan DESC";
$stmt_inv = $conn->prepare($sql_invoices);
$stmt_inv->bind_param("i", $project_id);
$stmt_inv->execute();
$result_invoices = $stmt_inv->get_result();

// Tính toán tổng số tiền thực tế đã chi từ danh sách hóa đơn
$da_chi = 0;
$invoices_list = [];
while ($row = $result_invoices->fetch_assoc()) {
    $da_chi += $row['so_tien'];
    $invoices_list[] = $row;
}
$con_lai = $project['tong_kinh_phi'] - $da_chi;

// 4. Truy vấn danh sách chuẩn để đổ dữ liệu vào Popup
$users_result = $conn->query("SELECT DISTINCT ho_ten FROM nhan_su WHERE ho_ten IS NOT NULL AND ho_ten != ''");
$contractors_result = $conn->query("SELECT id, ten_don_vi FROM chuthau WHERE ten_don_vi IS NOT NULL AND ten_don_vi != ''");
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
            $statusClass = 'badge-ongoing';
            $statusText = htmlspecialchars($project['trang_thai'] ?: 'Đang thực hiện');
            if ($project['trang_thai'] == 'Trễ hạn' || $project['trang_thai'] == 'warning') $statusClass = 'badge-warning';
            if ($project['trang_thai'] == 'Hoàn thành' || $project['trang_thai'] == 'completed') $statusClass = 'badge-completed';
            ?>
            <span class="badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>

            <?php if ($is_assigned): ?>
                <button class="btn-open-popup btn-edit-assignment" onclick="toggleModal(true)">
                    <i class="fas fa-user-edit"></i> Sửa nhân sự / Thầu / Kinh phí / Trạng thái
                </button>
            <?php else: ?>
                <button class="btn-open-popup" onclick="toggleModal(true)">
                    <i class="fas fa-user-plus"></i> Chỉ định nhân sự / Thầu / Kinh phí / Trạng thái
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
                <label>Nhà thầu đảm nhiệm</label>
                <span><?php echo !empty($project['ten_don_vi']) ? htmlspecialchars($project['ten_don_vi']) : 'Chưa chỉ định'; ?></span>
            </div>
        </div>
        <div class="summary-card">
            <i class="fas fa-university"></i>
            <div>
                <label>Chủ đầu tư</label>
                <span><?php echo !empty($project['chu_dau_tu']) ? htmlspecialchars($project['chu_dau_tu']) : 'VLUTE'; ?></span>
            </div>
        </div>
        <div class="summary-card">
            <i class="fas fa-money-check-alt" style="color: #2980b9;"></i>
            <div>
                <label>Tổng ngân sách dự kiến</label>
                <span style="color: #2980b9; font-weight: bold;"><?php echo number_format($project['tong_kinh_phi'], 0, ',', '.'); ?> đ</span>
            </div>
        </div>
    </div>

    <div class="tabs-navigation" style="margin-bottom: 15px; display: flex; gap: 10px;">
        <button class="tab-btn active" onclick="openTab(event, 'tong-quan')">
            <i class="fas fa-file-alt"></i> Tổng quan & Mô tả
        </button>
        <button class="tab-btn" onclick="openTab(event, 'kinh-phi')">
            <i class="fas fa-wallet"></i> Quản lý kinh phí
        </button>
    </div>

    <div class="tabs-content">
        <div id="tong-quan" class="tab-pane active">
            <div class="tab-card-content">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <h3><i class="fas fa-file-alt"></i> Mô tả chi tiết dự án</h3>
                    <button type="button" onclick="toggleDescModal(true)" style="background: #2980b9; color: #fff; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 13px; font-weight: 500;">
                        <i class="fas fa-edit"></i> Chỉnh sửa mô tả
                    </button>
                </div>
                <div class="project-description-text" style="background: #fdfefe; padding: 15px; border: 1px solid #e5e8e8; border-radius: 6px;">
                    <?php
                    echo !empty($project['mo_ta'])
                        ? nl2br(htmlspecialchars($project['mo_ta']))
                        : '<em style="color:#95a5a6;">Chưa có mô tả chi tiết cho dự án này. Hãy bấm nút phía trên để cập nhật thông tin hệ thống.</em>';
                    ?>
                </div>
            </div>
        </div>

        <div id="kinh-phi" class="tab-pane">
            <div class="tab-card-content">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h3><i class="fas fa-wallet"></i> Quản lý tài chính dự án</h3>
                    <button type="button" onclick="toggleInvoiceModal(true)" style="background: #2ecc71; color: #fff; border: none; padding: 7px 14px; border-radius: 4px; cursor: pointer; font-size: 13px; font-weight: bold; display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-plus-circle"></i> Thêm hóa đơn mới
                    </button>
                </div>

                <div class="finance-summary-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                    <div style="background: #ebf5fb; padding: 15px; border-radius: 6px; border-left: 5px solid #3498db;">
                        <label style="display:block; font-size:12px; color:#566573;">Tổng ngân sách dự kiến</label>
                        <strong style="font-size:18px; color:#2980b9;"><?php echo number_format($project['tong_kinh_phi'], 0, ',', '.'); ?> đ</strong>
                    </div>
                    <div style="background: #fdf2e9; padding: 15px; border-radius: 6px; border-left: 5px solid #e67e22;">
                        <label style="display:block; font-size:12px; color:#566573;">Thực tế đã chi trả</label>
                        <strong style="font-size:18px; color:#d35400;"><?php echo number_format($da_chi, 0, ',', '.'); ?> đ</strong>
                    </div>
                    <div style="background: #e8f8f5; padding: 15px; border-radius: 6px; border-left: 5px solid #2ecc71;">
                        <label style="display:block; font-size:12px; color:#566573;">Ngân sách còn lại</label>
                        <strong style="font-size:18px; color:#27ae60;"><?php echo number_format($con_lai, 0, ',', '.'); ?> đ</strong>
                    </div>
                </div>

                <div class="table-responsive" style="margin-top: 15px;">
                    <table class="manager-table" style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="background-color: #f2f4f4; border-bottom: 2px solid #bdc3c7;">
                                <th style="padding: 10px;">STT</th>
                                <th style="padding: 10px;">Nội dung thanh toán / Hóa đơn</th>
                                <th style="padding: 10px;">Ngày chi</th>
                                <th style="padding: 10px; text-align: right;">Số tiền</th>
                                <th style="padding: 10px;">Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($invoices_list) > 0): ?>
                                <?php foreach ($invoices_list as $index => $inv): ?>
                                    <tr style="border-bottom: 1px solid #eaeded;">
                                        <td style="padding: 10px;"><?php echo $index + 1; ?></td>
                                        <td style="padding: 10px; font-weight: 500;"><?php echo htmlspecialchars($inv['ten_chi_phi']); ?></td>
                                        <td style="padding: 10px;"><?php echo date('d/m/Y', strtotime($inv['ngay_thanh_toan'])); ?></td>
                                        <td style="padding: 10px; text-align: right; color: #e74c3c; font-weight: bold;">
                                            -<?php echo number_format($inv['so_tien'], 0, ',', '.'); ?> đ
                                        </td>
                                        <td style="padding: 10px; font-size: 13px; color: #7f8c8d;"><?php echo htmlspecialchars($inv['ghi_chu']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="padding: 20px; text-align: center; color: #95a5a6;">
                                        <i class="fas fa-receipt" style="font-size: 24px; display:block; margin-bottom: 5px;"></i>
                                        Chưa có dữ liệu hóa đơn, chứng từ phát sinh cho dự án này.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PHÂN CÔNG (BỔ SUNG THÊM LỰA CHỌN TRẠNG THÁI DỰ ÁN) -->
<div class="modal-overlay" id="assignmentModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fas fa-user-edit"></i> <?php echo $is_assigned ? 'Cập nhật phân công, Kinh phí & Trạng thái' : 'Chỉ định nhân sự, Nhà thầu & Trạng thái'; ?></h3>
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
                        $users_result->data_seek(0);
                        while ($u = $users_result->fetch_assoc()) {
                            if ($u['ho_ten'] != 'Võ Minh Hiếu') {
                                $selected = ($project['nguoi_phu_trach_cdt'] == $u['ho_ten']) ? 'selected' : '';
                                echo "<option value='" . htmlspecialchars($u['ho_ten']) . "' $selected>" . htmlspecialchars($u['ho_ten']) . "</option>";
                            }
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="select_nhathau"><i class="fas fa-handshake"></i> Chọn Đơn vị / Nhà thầu:</label>
                <select name="id_nha_thau" id="select_nhathau" required>
                    <option value="">-- Chọn nhà thầu --</option>
                    <?php
                    if ($contractors_result) {
                        $contractors_result->data_seek(0);
                        while ($c = $contractors_result->fetch_assoc()) {
                            $selected = ($project['id_nha_thau'] == $c['id']) ? 'selected' : '';
                            echo "<option value='" . intval($c['id']) . "' $selected>" . htmlspecialchars($c['ten_don_vi']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <!-- PHẦN CHỈNH SỬA TRẠNG THÁI DỰ ÁN MỚI THÊM VÀO ĐÂY -->
            <div class="form-group" style="margin-top: 15px;">
                <label for="trang_thai"><i class="fas fa-tasks"></i> Trạng thái dự án:</label>
                <select name="trang_thai" id="trang_thai" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-weight: 500;" required>
                    <option value="Đang thực hiện" <?php echo ($project['trang_thai'] == 'Đang thực hiện' || $project['trang_thai'] == 'ongoing') ? 'selected' : ''; ?>>Đang thực hiện</option>
                    <option value="Trễ hạn" <?php echo ($project['trang_thai'] == 'Trễ hạn' || $project['trang_thai'] == 'warning') ? 'selected' : ''; ?>>Trễ hạn</option>
                    <option value="Hoàn thành" <?php echo ($project['trang_thai'] == 'Hoàn thành' || $project['trang_thai'] == 'completed') ? 'selected' : ''; ?>>Hoàn thành</option>
                </select>
            </div>

            <div class="form-group" style="margin-top: 15px;">
                <label for="tong_kinh_phi"><i class="fas fa-money-check-alt"></i> Tổng ngân sách dự toán (VNĐ):</label>
                <input type="number" name="tong_kinh_phi" id="tong_kinh_phi" value="<?php echo htmlspecialchars($project['tong_kinh_phi']); ?>" min="0" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-weight: bold; color: #2980b9;" required>
            </div>



            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="toggleModal(false)">Hủy bỏ</button>
                <button type="submit" name="btn_submit_update" class="btn-submit">Xác nhận cập nhật</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="descriptionModal">
    <div class="modal-box" style="max-width: 600px;">
        <div class="modal-header">
            <h3><i class="fas fa-edit"></i> Chỉnh sửa mô tả chi tiết</h3>
            <span class="close-modal" onclick="toggleDescModal(false)">&times;</span>
        </div>
        <form action="" method="POST">
            <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">

            <div class="form-group">
                <label style="font-weight: bold; margin-bottom: 8px; display: block;">Nội dung mô tả dự án:</label>
                <textarea name="mo_ta" rows="10" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-family: inherit; font-size: 14px; resize: vertical;" placeholder="Nhập quy mô công trình, tiến độ thi công, hạng mục chi tiết..."><?php echo htmlspecialchars($project['mo_ta'] ?? ''); ?></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="toggleDescModal(false)">Hủy bỏ</button>
                <button type="submit" name="btn_submit_description" class="btn-submit" style="background-color: #2980b9;">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="invoiceModal">
    <div class="modal-box" style="max-width: 500px;">
        <div class="modal-header">
            <h3><i class="fas fa-receipt"></i> Thêm hóa đơn phát sinh mới</h3>
            <span class="close-modal" onclick="toggleInvoiceModal(false)">&times;</span>
        </div>
        <form action="" method="POST">
            <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display:block; font-weight: 500; margin-bottom: 5px;"><i class="fas fa-shopping-cart"></i> Nội dung thanh toán / Tên chi phí:</label>
                <input type="text" name="ten_chi_phi" style="width:100%; padding: 8px; border: 1px solid #ccc; border-radius:4px;" placeholder="Ví dụ: Mua vật tư cát đá, Trả tiền nhân công đợt 1..." required>
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display:block; font-weight: 500; margin-bottom: 5px;"><i class="fas fa-money-bill-alt"></i> Số tiền thanh toán (VNĐ):</label>
                <input type="number" name="so_tien" min="1000" style="width:100%; padding: 8px; border: 1px solid #ccc; border-radius:4px;" placeholder="Nhập số tiền thực tế..." required>
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display:block; font-weight: 500; margin-bottom: 5px;"><i class="fas fa-calendar-alt"></i> Ngày thanh toán:</label>
                <input type="date" name="ngay_thanh_toan" value="<?php echo date('Y-m-d'); ?>" style="width:100%; padding: 8px; border: 1px solid #ccc; border-radius:4px;" required>
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display:block; font-weight: 500; margin-bottom: 5px;"><i class="fas fa-comment-alt"></i> Ghi chú:</label>
                <input type="text" name="ghi_chu" style="width:100%; padding: 8px; border: 1px solid #ccc; border-radius:4px;" placeholder="Đơn vị cung cấp, số xe chứng từ...">
            </div>

            <div class="modal-footer" style="text-align:right; border-top: 1px solid #eee; padding-top:15px; margin-top:15px;">
                <button type="button" class="btn-cancel" onclick="toggleInvoiceModal(false)">Hủy bỏ</button>
                <button type="submit" name="btn_submit_invoice" class="btn-submit" style="background-color: #2ecc71;">Xác nhận lưu</button>
            </div>
        </form>
    </div>
</div>

<?php $conn->close(); ?>

<script src="js/manager_chitiet_duan.js"></script>