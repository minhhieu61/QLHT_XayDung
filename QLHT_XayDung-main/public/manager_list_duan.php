<link rel="stylesheet" href="css/manager_list_duan.css">
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
</div>