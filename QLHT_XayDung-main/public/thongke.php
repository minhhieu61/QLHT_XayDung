<!-- <?php
// Truy vấn dữ liệu từ MySQL (Thay tên bảng theo DB của bạn)
// 1. Tổng dự án
// $sql_duan = "SELECT COUNT(*) as total FROM duan";
// $res_duan = mysqli_query($conn, $sql_duan);
// $data_duan = mysqli_fetch_assoc($res_duan);

// // 2. Tổng nhân công
// $sql_nhancong = "SELECT COUNT(*) as total FROM nhancong";
// $res_nhancong = mysqli_query($conn, $sql_nhancong);
// $data_nhancong = mysqli_fetch_assoc($res_nhancong);

// // 3. Tổng vật tư tồn kho
// $sql_vattu = "SELECT SUM(soluong) as total FROM vattu";
// $res_vattu = mysqli_query($conn, $sql_vattu);
// $data_vattu = mysqli_fetch_assoc($res_vattu);

// // 4. Tổng kinh phí (định dạng tỷ đồng B hoặc triệu M)
// $sql_kinhphi = "SELECT SUM(giatri) as total FROM kinhphi";
// $res_kinhphi = mysqli_query($conn, $sql_kinhphi);
// $data_kinhphi = mysqli_fetch_assoc($res_kinhphi);
// $formatted_kp = number_format($data_kinhphi['total'] / 1000000000, 1) . 'B';
?> -->

<link rel="stylesheet" href="css/thongke.css">

<div class="thongke-container">
    <header class="vattu-header-top">
        <div class="header-title-ql">
            <h1><i class="fas fa-chart-line"></i> BÁO CÁO THỐNG KÊ</h1>
            <p>Dữ liệu tổng hợp toàn hệ thống tính đến tháng <?php echo date('m/Y'); ?></p>
        </div>
        <button class="btn-print" onclick="window.print()">
            <i class="fas fa-file-export"></i> Xuất báo cáo (In)
        </button>
    </header>

    <div class="stats-grid">
        <div class="stat-item blue">
            <div class="stat-icon"><i class="fas fa-project-diagram"></i></div>
            <div class="stat-info">
                <!-- <h3><?php echo $data_duan['total']; ?></h3> -->
                <p>Tổng dự án</p>
            </div>
        </div>

        <div class="stat-item green">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <!-- <h3><?php echo $data_nhancong['total']; ?></h3> -->
                <p>Nhân công</p>
            </div>
        </div>

        <div class="stat-item orange">
            <div class="stat-icon"><i class="fas fa-boxes"></i></div>
            <div class="stat-info">
                <!-- <h3><?php echo number_format($data_vattu['total']); ?></h3> -->
                <p>Vật tư trong kho</p>
            </div>
        </div>

        <div class="stat-item red">
            <div class="stat-icon"><i class="fas fa-wallet"></i></div>
            <div class="stat-info">
                <!-- <h3><?php echo $formatted_kp; ?></h3> -->
                <p>Kinh phí (VNĐ)</p>
            </div>
        </div>
    </div>
</div>