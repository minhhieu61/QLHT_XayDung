<link rel="stylesheet" href="css/manager_main_content.css">
<div class="dashboard-container">
    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="info">
                <label>Dự án đang chạy</label>
                <span class="number">08</span>
            </div>
            <i class="fas fa-tasks"></i>
        </div>
        <div class="stat-card red">
            <div class="info">
                <label>Trễ tiến độ</label>
                <span class="number">02</span>
            </div>
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="stat-card cyan">
            <div class="info">
                <label>Đã hoàn thành</label>
                <span class="number">15</span>
            </div>
            <i class="fas fa-clipboard-check"></i>
        </div>
        <div class="stat-card green">
            <div class="info">
                <label>Kinh phí đã chi</label>
                <span class="number">3.15B</span>
            </div>
            <i class="fas fa-money-bill-wave"></i>
        </div>
    </div>

    <div class="dashboard-row">
        <div class="dashboard-col main-col">
            <div class="card-box">
                <div class="card-header">
                    <h3>Dự án trọng điểm</h3>
                    <a href="manager_dashboard.php?p=giamsat_duan" class="btn-link">Xem tất cả</a>
                </div>
                <div class="project-mini-list">
                    <div class="mini-item">
                        <div class="p-name">Nhà học Khu A</div>
                        <div class="p-progress">
                            <div class="bar">
                                <div class="fill" style="width: 85%"></div>
                            </div>
                            <span>85%</span>
                        </div>
                    </div>
                    <div class="mini-item">
                        <div class="p-name">Hệ thống PCCC</div>
                        <div class="p-progress">
                            <div class="bar">
                                <div class="fill warning" style="width: 40%"></div>
                            </div>
                            <span>40%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-col side-col">
            <div class="card-box">
                <h3>Hoạt động gần đây</h3>
                <ul class="activity-timeline">
                    <li>
                        <span class="time">10:30</span>
                        <p><strong>Hồ sơ:</strong> vừa được lưu trữ</p>
                    </li>
                    <li>
                        <span class="time">09:15</span>
                        <p><strong>Võ Minh Hiếu:</strong> Vừa tạo 1 dự án mới</p>
                    </li>
                    <li>
                        <span class="time">Hôm qua</span>
                        <p>Dự án <strong>Sửa chữa điện</strong> đã hoàn thành</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>