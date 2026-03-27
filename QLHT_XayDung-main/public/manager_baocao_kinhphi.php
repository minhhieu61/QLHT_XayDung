<link rel="stylesheet" href="css/manager_baocao_kinhphi.css">

<div class="finance-wrapper">
    <div class="finance-header">
        <div class="header-title">
            <h2><i class="fas fa-chart-pie"></i> Báo cáo Kinh phí & Giải ngân</h2>
            <p>Theo dõi dòng tiền và đối soát hóa đơn các công trình</p>
        </div>
        <div class="header-actions">
            <button class="btn-secondary"><i class="fas fa-filter"></i> Lọc ngày</button>
            <button class="btn-primary"><i class="fas fa-file-export"></i> Xuất Báo cáo PDF</button>
        </div>
    </div>

    <div class="finance-summary-grid">
        <div class="f-stat-card total">
            <div class="f-info">
                <label>Tổng dự toán hệ thống</label>
                <span class="f-value">5.200.000.000đ</span>
            </div>
            <i class="fas fa-vault"></i>
        </div>
        <div class="f-stat-card spent">
            <div class="f-info">
                <label>Thực tế đã chi</label>
                <span class="f-value">3.150.000.000đ</span>
            </div>
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div class="f-stat-card remaining">
            <div class="f-info">
                <label>Ngân sách còn lại</label>
                <span class="f-value">2.050.000.000đ</span>
            </div>
            <i class="fas fa-piggy-bank"></i>
        </div>
        <div class="f-stat-card percent">
            <div class="f-info">
                <label>Tỉ lệ giải ngân</label>
                <span class="f-value">60.5%</span>
            </div>
            <i class="fas fa-chart-line"></i>
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
                    <th>Tiến độ chi</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Cải tạo Nhà học Khu A</strong></td>
                    <td>1.500.000.000đ</td>
                    <td class="text-bold">1.200.000.000đ</td>
                    <td>300.000.000đ</td>
                    <td>
                        <div class="f-progress-bar">
                            <div class="f-progress-fill" style="width: 80%"></div>
                        </div>
                        <small>80%</small>
                    </td>
                    <td><span class="f-badge safe">An toàn</span></td>
                </tr>
                <tr class="danger-row">
                    <td><strong>Sửa chữa KTX VLUTE</strong></td>
                    <td>500.000.000đ</td>
                    <td class="text-bold">480.000.000đ</td>
                    <td class="text-danger">20.000.000đ</td>
                    <td>
                        <div class="f-progress-bar">
                            <div class="f-progress-fill warning" style="width: 96%"></div>
                        </div>
                        <small>96%</small>
                    </td>
                    <td><span class="f-badge danger">Sắp vượt định mức</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>