<?php
// 1. Kết nối cơ sở dữ liệu (đảm bảo file ketnoi.php nằm chung cấp hoặc điều chỉnh đường dẫn)
include_once 'ketnoi.php';

/** @var mysqli $conn */
if (!$conn) {
    die("Lỗi kết nối cơ sở dữ liệu. Vui lòng kiểm tra file ketnoi.php");
}

// ==========================================
// TRUY VẤN DỮ LIỆU ĐỘNG CHO STATS GRID
// ==========================================

// 1. Dự án đang chạy (Trạng thái khác Hoàn thành và chưa bị quá hạn)
$sql_running = "SELECT COUNT(*) AS total FROM duan WHERE trang_thai = 'Đang chạy' OR trang_thai = 'Đang thực hiện' OR trang_thai IS NULL";
$res_running = mysqli_query($conn, $sql_running);
$total_running = ($res_running) ? mysqli_fetch_assoc($res_running)['total'] : 0;

// 2. Dự án tạm dừng (Lọc chính xác theo trạng thái tạm dừng trong CSDL)
$sql_paused = "SELECT COUNT(*) AS total FROM duan WHERE trang_thai = 'Tạm dừng'";
$res_paused = mysqli_query($conn, $sql_paused);
$total_paused = ($res_paused) ? mysqli_fetch_assoc($res_paused)['total'] : 0;

// 3. Dự án đã hoàn thành
$sql_completed = "SELECT COUNT(*) AS total FROM duan WHERE trang_thai = 'Hoàn thành'";
$res_completed = mysqli_query($conn, $sql_completed);
$total_completed = ($res_completed) ? mysqli_fetch_assoc($res_completed)['total'] : 0;

// 4. Kinh phí đã chi và hàm định dạng rút gọn (Ví dụ: 3150000000 -> 3.15B)
$sql_budget = "SELECT SUM(tong_kinh_phi) AS total_budget FROM duan";
$res_budget = mysqli_query($conn, $sql_budget);
$raw_budget = ($res_budget) ? mysqli_fetch_assoc($res_budget)['total_budget'] : 0;

// Hàm định dạng số tiền thành dạng chuỗi rút gọn dễ nhìn (B: Tỷ, M: Triệu)
function formatBudget($value)
{
    if (!$value || $value == 0) return "0đ";
    if ($value >= 1000000000) {
        return round($value / 1000000000, 2) . 'B';
    } elseif ($value >= 1000000) {
        return round($value / 1000000, 1) . 'M';
    }
    return number_format($value) . 'đ';
}
$display_budget = formatBudget($raw_budget);


// ==========================================
// TRUY VẤN DANH SÁCH DỰ ÁN TRỌNG ĐIỂM
// ==========================================
// Lấy ra 4 dự án mới nhất hoặc có kinh phí lớn nhất để hiển thị trực quan
$sql_projects = "SELECT ten_du_an, ma_da FROM duan ORDER BY id DESC LIMIT 4";
$result_projects = mysqli_query($conn, $sql_projects);


// ==========================================
// TRUY VẤN HOẠT ĐỘNG GẦN ĐÂY (TỪ BẢNG NHẬT KÝ ĐÃ TẠO Ở CÁCH 1)
// ==========================================
$sql_activities = "SELECT thoi_gian, noi_dung FROM nhat_ky ORDER BY thoi_gian DESC LIMIT 5";
$result_activities = mysqli_query($conn, $sql_activities);

// Hàm hiển thị thời gian tinh gọn cho Timeline
function formatActivityTime($datetime_str)
{
    $time_stamp = strtotime($datetime_str);
    $date_activity = date('Y-m-d', $time_stamp);
    $date_today = date('Y-m-d');
    $date_yesterday = date('Y-m-d', strtotime('-1 day'));

    if ($date_activity === $date_today) {
        return date('H:i', $time_stamp);
    } elseif ($date_activity === $date_yesterday) {
        return 'Hôm qua';
    }
    return date('d/m', $time_stamp);
}
?>

<link rel="stylesheet" href="css/manager_main_content.css">
<div class="dashboard-container">

    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="info">
                <label>Dự án đang chạy</label>
                <span class="number"><?php echo str_pad($total_running, 2, "0", STR_PAD_LEFT); ?></span>
            </div>
            <i class="fas fa-tasks"></i>
        </div>
        <div class="stat-card red">
            <div class="info">
                <label>Tạm dừng</label>
                <span class="number"><?php echo str_pad($total_paused, 2, "0", STR_PAD_LEFT); ?></span>
            </div>
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="stat-card cyan">
            <div class="info">
                <label>Đã hoàn thành</label>
                <span class="number"><?php echo str_pad($total_completed, 2, "0", STR_PAD_LEFT); ?></span>
            </div>
            <i class="fas fa-clipboard-check"></i>
        </div>
        <div class="stat-card green">
            <div class="info">
                <label>Kinh phí đã chi</label>
                <span class="number"><?php echo $display_budget; ?></span>
            </div>
            <i class="fas fa-money-bill-wave"></i>
        </div>
    </div>

    <div class="dashboard-row">
        <div class="dashboard-col main-col">
            <div class="card-box">
                <div class="card-header">
                    <h3>Dự án gần đây</h3>
                    <a href="manager_dashboard.php?p=giamsat_duan" class="btn-link">Xem tất cả</a>
                </div>
                <div class="project-mini-list">
                    <?php
                    if ($result_projects && mysqli_num_rows($result_projects) > 0):
                        while ($proj = mysqli_fetch_assoc($result_projects)):
                    ?>
                            <div class="mini-item" style="cursor: pointer; padding: 15px 10px;" onclick="window.location.href='manager_dashboard.php?p=giamsat_duan&search=<?php echo urlencode($proj['ma_da'] ?? ''); ?>'">
                                <div class="p-name" style="font-weight: 500; color: #2c3e50;"><i class="fas fa-folder" style="color: #3498db; margin-right: 10px;"></i><?php echo htmlspecialchars($proj['ten_du_an']); ?></div>
                            </div>
                        <?php
                        endwhile;
                    else:
                        ?>
                        <p style="color: #95a5a6; font-style: italic; padding: 15px 0;">Hệ thống chưa có dữ liệu dự án nào được khởi tạo.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="dashboard-col side-col">
            <div class="card-box">
                <h3>Hoạt động gần đây</h3>
                <ul class="activity-timeline">
                    <?php
                    if ($result_activities && mysqli_num_rows($result_activities) > 0):
                        while ($act = mysqli_fetch_assoc($result_activities)):
                    ?>
                            <li>
                                <span class="time"><?php echo formatActivityTime($act['thoi_gian']); ?></span>
                                <p><?php echo $act['noi_dung']; ?></p>
                            </li>
                        <?php
                        endwhile;
                    else:
                        ?>
                        <li style="border-left: none; padding-left: 0;">
                            <p style="color: #95a5a6; font-style: italic;">Chưa ghi nhận hoạt động nào trong hệ thống.</p>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>