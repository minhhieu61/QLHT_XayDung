<?php
// 1. Nhúng thư viện Dompdf (Đường dẫn đi ngược ra ngoài thư mục public như đã sửa thành công)
require_once 'libs/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// 2. Kết nối Cơ sở dữ liệu 
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'qlht_xaydung_vlute';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Lỗi kết nối cơ sở dữ liệu: " . $conn->connect_error);
}
$conn->set_charset("utf8");

// 3. Khối xử lý tính toán số liệu tổng quan hệ thống
$total_budget = 0;
$budget_res = $conn->query("SELECT SUM(tong_kinh_phi) AS total FROM duan");
if ($budget_res && $row = $budget_res->fetch_assoc()) {
    $total_budget = floatval($row['total']);
}

$total_spent = 0;
$spent_res = $conn->query("SELECT SUM(so_tien) AS total FROM hoa_don");
if ($spent_res && $row = $spent_res->fetch_assoc()) {
    $total_spent = floatval($row['total']);
}
$total_remaining = $total_budget - $total_spent;

// 4. Lấy danh sách chi tiết của từng dự án
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

$table_rows = '';
$stt = 1;

if ($result_list && $result_list->num_rows > 0) {
    while ($project = $result_list->fetch_assoc()) {
        $p_budget = floatval($project['tong_kinh_phi']);
        $p_spent = floatval($project['da_chi']);
        $p_remaining = $p_budget - $p_spent;
        $p_percent = ($p_budget > 0) ? ($p_spent / $p_budget) * 100 : 0;

        $badgeText = 'An toàn';
        $badgeStyle = 'color: #27ae60; font-weight: bold;';

        if ($p_percent >= 90) {
            $badgeText = 'Vượt định mức';
            $badgeStyle = 'color: #c0392b; font-weight: bold;';
        } elseif ($p_percent >= 70) {
            $badgeText = 'Cần lưu ý';
            $badgeStyle = 'color: #d35400; font-weight: bold;';
        }

        // ĐÃ LOẠI BỎ Ô TIẾN ĐỘ TỶ LỆ TRONG VÒNG LẶP TRUY XUẤT
        $table_rows .= '
        <tr>
            <td style="text-align: center;">' . $stt++ . '</td>
            <td><strong>' . htmlspecialchars($project['ten_du_an']) . '</strong></td>
            <td style="text-align: right;">' . number_format($p_budget, 0, ',', '.') . 'đ</td>
            <td style="text-align: right; color: #2980b9;">' . number_format($p_spent, 0, ',', '.') . 'đ</td>
            <td style="text-align: right;">' . number_format($p_remaining, 0, ',', '.') . 'đ</td>
            <td style="text-align: center; ' . $badgeStyle . '">' . $badgeText . '</td>
        </tr>';
    }
} else {
    $table_rows = '<tr><td colspan="6" style="text-align:center; color:#7f8c8d;">Chưa có dữ liệu dự án hợp lệ.</td></tr>';
}

// 5. Thiết kế giao diện HTML đổ dữ liệu (Đã cấu hình lại % width các cột cho vừa khít khổ giấy A4)
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: "DejaVu Sans", sans-serif; font-size: 11px; color: #333; line-height: 1.4; }
        .header-container { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #34495e; padding-bottom: 10px; }
        .header-container h2 { margin: 0; text-transform: uppercase; color: #2c3e50; font-size: 16px; }
        .header-container p { margin: 4px 0 0 0; color: #7f8c8d; font-size: 11px; }
        
        .summary-box { width: 100%; margin-bottom: 25px; border-collapse: collapse; }
        .summary-box td { width: 33.33%; padding: 12px; border: 1px solid #bdc3c7; text-align: center; }
        .bg-blue { background-color: #ebf5fb; color: #2980b9; }
        .bg-orange { background-color: #fdf2e9; color: #d35400; }
        .bg-green { background-color: #e8f8f5; color: #27ae60; }
        .summary-box label { font-size: 10px; display: block; margin-bottom: 4px; color: #566573; text-transform: uppercase; }
        
        .report-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .report-table th { background-color: #34495e; color: #ffffff; border: 1px solid #34495e; padding: 8px; font-size: 10px; text-transform: uppercase; }
        .report-table td { border: 1px solid #bdc3c7; padding: 7px; vertical-align: middle; }
        
        .footer-zone { width: 100%; margin-top: 40px; }
        .footer-zone td { border: none; font-size: 11px; }
    </style>
</head>
<body>

    <div class="header-container">
        <h2>BÁO CÁO KINH PHÍ VÀ TIẾN ĐỘ GIẢI NGÂN TỔNG HỢP</h2>
        <p>Hệ thống Quản lý hạ tầng & Xây dựng VLUTE</p>
    </div>

    <table class="summary-box">
        <tr>
            <td class="bg-blue">
                <label>Tổng dự toán hệ thống</label>
                <strong>' . number_format($total_budget, 0, ',', '.') . ' đ</strong>
            </td>
            <td class="bg-orange">
                <label>Thực tế đã chi trả</label>
                <strong>' . number_format($total_spent, 0, ',', '.') . ' đ</strong>
            </td>
            <td class="bg-green">
                <label>Ngân sách hệ thống còn lại</label>
                <strong>' . number_format($total_remaining, 0, ',', '.') . ' đ</strong>
            </td>
        </tr>
    </table>

    <h3 style="font-size: 13px; color: #2c3e50; margin-bottom: 8px;">Chi tiết ngân sách phân bổ theo từng hạng mục dự án</h3>
    
    <table class="report-table">
        <thead>
            <tr>
                <th style="width: 6%;">STT</th>
                <th style="width: 38%; text-align: left;">Tên dự án công trình</th>
                <th style="width: 15%; text-align: right;">Tổng dự toán</th>
                <th style="width: 14%; text-align: right;">Đã giải ngân</th>
                <th style="width: 14%; text-align: right;">Nguồn vốn còn lại</th>
                <th style="width: 13%;">Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            ' . $table_rows . '
        </tbody>
    </table>

    <table class="footer-zone">
        <tr>
            <td style="width: 60%;"></td>
            <td style="text-align: center;">
                <p><i>Vĩnh Long, Ngày ' . date('d') . ' tháng ' . date('m') . ' năm ' . date('Y') . '</i></p>
                <p><strong>Người lập báo cáo tổng hợp</strong></p>
                <br><br><br><br>
                <p style="font-weight: bold;">Ban Quản Lý Tài Chính Kế Toán</p>
            </td>
        </tr>
    </table>

</body>
</html>
';

// 6. Cấu hình Dompdf và xuất file
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$date_string = date('d_m_Y');
$dompdf->stream("Bao_cao_tong_hop_kinh_phi_{$date_string}.pdf", array("Attachment" => false));

$conn->close();
