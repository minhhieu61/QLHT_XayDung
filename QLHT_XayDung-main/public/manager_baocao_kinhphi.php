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

// Tính tổng dự toán của toàn bộ dự án
$total_budget = 0;
$budget_res = $conn->query("SELECT SUM(tong_kinh_phi) AS total FROM duan");
if ($budget_res && $row = $budget_res->fetch_assoc()) {
    $total_budget = floatval($row['total']);
}

// Tính tổng số tiền thực tế đã chi trả dựa trên tất cả hóa đơn
$total_spent = 0;
$spent_res = $conn->query("SELECT SUM(so_tien) AS total FROM hoa_don");
if ($spent_res && $row = $spent_res->fetch_assoc()) {
    $total_spent = floatval($row['total']);
}

// Tính ngân sách còn lại
$total_remaining = $total_budget - $total_spent;

// TRUY VẤN CHI TIẾT KINH PHÍ TỪNG DỰ ÁN
$sql_list = "SELECT 
                d.id, 
                d.ten_du_an, 
                d.tong_kinh_phi, 
                IFNULL(SUM(h.so_tien), 0) AS da_chi
             FROM duan d
             LEFT JOIN hoa_don h ON d.id = h.id_du_an
             GROUP BY d.id
             ORDER BY d.id DESC";
$result_list = $conn->query($sql_list);
?>

<link rel="stylesheet" href="css/manager_baocao_kinhphi.css">

<div class="finance-wrapper">
    <div class="finance-header">
        <div class="header-title">
            <h2><i class="fas fa-chart-pie"></i> Báo cáo Kinh phí & Giải ngân</h2>
            <p>Theo dõi dòng tiền và đối soát hóa đơn các công trình</p>
        </div>
        <div class="header-actions">
            <!-- <button class="btn-secondary"><i class="fas fa-filter"></i> Lọc ngày</button> -->

            <a href="export_all_kinhphi.php" target="_blank" class="btn-primary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                <i class="fas fa-file-export"></i> Xuất Báo cáo PDF
            </a>
        </div>
    </div>

    <div class="finance-summary-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
        <div class="f-stat-card total">
            <div class="f-info">
                <label>Tổng dự toán hệ thống</label>
                <span class="f-value"><?php echo number_format($total_budget, 0, ',', '.'); ?>đ</span>
            </div>
            <i class="fas fa-vault"></i>
        </div>
        <div class="f-stat-card spent">
            <div class="f-info">
                <label>Thực tế đã chi</label>
                <span class="f-value"><?php echo number_format($total_spent, 0, ',', '.'); ?>đ</span>
            </div>
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div class="f-stat-card remaining">
            <div class="f-info">
                <label>Ngân sách còn lại</label>
                <span class="f-value"><?php echo number_format($total_remaining, 0, ',', '.'); ?>đ</span>
            </div>
            <i class="fas fa-piggy-bank"></i>
        </div>
    </div>

    <div class="finance-table-section">
        <div class="section-header">
            <h3>Chi tiết theo từng dự án</h3>
        </div>
        <table class="finance-table">
            <thead>
                <tr>
                    <th>Tên dự án</th>
                    <th>Tổng dự toán</th>
                    <th>Đã chi</th>
                    <th>Còn lại</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_list && $result_list->num_rows > 0):
                    while ($project = $result_list->fetch_assoc()):
                        $p_budget = floatval($project['tong_kinh_phi']);
                        $p_spent = floatval($project['da_chi']);
                        $p_remaining = $p_budget - $p_spent;
                        $p_percent = ($p_budget > 0) ? round(($p_spent / $p_budget) * 100, 1) : 0;

                        $rowClass = '';
                        $badgeClass = 'safe';
                        $badgeText = 'An toàn';

                        if ($p_percent >= 90) {
                            $rowClass = 'danger-row';
                            $badgeClass = 'danger';
                            $badgeText = 'Sắp vượt định mức';
                        } elseif ($p_percent >= 70) {
                            $badgeClass = 'warning';
                            $badgeText = 'Cần lưu ý';
                        }
                ?>
                        <tr class="<?php echo $rowClass; ?>">
                            <td><strong><?php echo htmlspecialchars($project['ten_du_an']); ?></strong></td>
                            <td><?php echo number_format($p_budget, 0, ',', '.'); ?>đ</td>
                            <td class="text-bold"><?php echo number_format($p_spent, 0, ',', '.'); ?>đ</td>
                            <td class="<?php echo ($p_percent >= 90) ? 'text-danger' : ''; ?>">
                                <?php echo number_format($p_remaining, 0, ',', '.'); ?>đ
                            </td>
                            <td><span class="f-badge <?php echo $badgeClass; ?>"><?php echo $badgeText; ?></span></td>
                        </tr>
                    <?php
                    endwhile;
                else:
                    ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px; color: #7f8c8d;">Chưa có dữ liệu dự án hợp lệ.</td>
                    </tr>
                <?php
                endif;
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>