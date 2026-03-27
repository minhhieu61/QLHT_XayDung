<link rel="stylesheet" href="css/manager_chitiet_duan.css">
<div class="project-detail-wrapper">
    <div class="project-detail-header">
        <div class="header-info">
            <span class="back-link"><a href="manager_dashboard.php?p=giamsat_duan"><i class="fas fa-arrow-left"></i> Quay lại</a></span>
            <h2>Cải tạo nhà học Khu A - VLUTE</h2>
            <p>Mã dự án: <strong>DA-2026-001</strong> | Ngày tạo: 15/03/2026</p>
        </div>
        <div class="header-status">
            <span class="badge badge-ongoing">Đang thi công</span>
        </div>
    </div>

    <div class="project-summary-cards">
        <div class="summary-card">
            <i class="fas fa-user-tie"></i>
            <div>
                <label>Người phụ trách</label>
                <span>Võ Minh Hiếu</span>
            </div>
        </div>
        <div class="summary-card">
            <i class="fas fa-building"></i>
            <div>
                <label>Đơn vị thầu</label>
                <span>Công ty XD Tiền Giang</span>
            </div>
        </div>
        <div class="summary-card">
            <i class="fas fa-dollar-sign"></i>
            <div>
                <label>Tổng dự toán</label>
                <span>1.500.000.000 VNĐ</span>
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
            <button class="tab-btn" onclick="openTab(event, 'vattu')">Vật tư & Thiết bị</button>
            <button class="tab-btn" onclick="openTab(event, 'kinh-phi')">Kinh phí & Hóa đơn</button>
        </div>

        <div class="tabs-content">
            <div id="tong-quan" class="tab-pane active">
                <h3>Mô tả dự án</h3>
                <p>Dự án tập trung vào việc cải tạo hệ thống điện, sơn sửa lại tường và thay mới thiết bị chiếu sáng tại nhà học Khu A.</p>
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
<script src="js/manager_chitiet_duan.js"></script>