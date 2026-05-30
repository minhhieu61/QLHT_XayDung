<aside class="side-panel">
    <div class="brand">
        <img src="img/logo.jpg  " alt="Logo">
        <h3>VLUTE CMS</h3>
    </div>

    <nav class="nav-menu">
        <!-- Nhóm: Tổng quan -->
        <a href="manager_dashboard.php?p=dashboard" class="nav-link <?php echo ($current_page == 'dashboard') ? 'active' : ''; ?>">
            <i class="fas fa-chart-line"></i> Bảng điều khiển
        </a>

        <!-- Nhóm: Phê duyệt (Chức năng quan trọng nhất của Manager) -->
        <!-- <a href="manager_dashboard.php?p=duyet_yeu_cau" class="nav-link <?php echo ($current_page == 'duyet_yeu_cau') ? 'active' : ''; ?>">
            <i class="fas fa-check-double"></i> Duyệt yêu cầu
            <span class="badge-count">3</span>
        </a> -->

        <!-- Nhóm: Giám sát dự án -->
        <a href="manager_dashboard.php?p=giamsat_duan" class="nav-link <?php echo ($current_page == 'giamsat_duan') ? 'active' : ''; ?>">
            <i class="fas fa-project-diagram"></i> Giám sát dự án
        </a>

        <!-- Nhóm: Quản lý nguồn lực -->
        <!-- <a href="manager_dashboard.php?p=vattu_thietbi" class="nav-link <?php echo ($current_page == 'vattu_thietbi') ? 'active' : ''; ?>">
            <i class="fas fa-boxes"></i> Kho vật tư & Thiết bị
        </a>

        <a href="manager_dashboard.php?p=doi_ngu" class="nav-link <?php echo ($current_page == 'doi_ngu') ? 'active' : ''; ?>">
            <i class="fas fa-users-cog"></i> Đội ngũ thi công
        </a> -->

        <!-- Nhóm: Tài chính & Báo cáo -->
        <a href="manager_dashboard.php?p=baocao_kinhphi" class="nav-link <?php echo ($current_page == 'baocao_kinhphi') ? 'active' : ''; ?>">
            <i class="fas fa-file-invoice-dollar"></i> Báo cáo kinh phí
        </a><!-- Nhóm: Lưu trữ hồ sơ -->
        <a href="manager_dashboard.php?p=luutru_hoso" class="nav-link <?php echo ($current_page == 'luutru_hoso') ? 'active' : ''; ?>">
            <i class="fas fa-archive"></i> Lưu trữ hồ sơ
        </a>
    </nav>

    <!-- Thông tin người dùng (Đã đồng bộ CSS với trangchu) -->
    <div class="user-profile">
        <div class="avatar">
            <?php echo strtoupper(substr($_SESSION['user'], 0, 1)); ?>
        </div>
        <div class="info">
            <span><?php echo htmlspecialchars($_SESSION['user']); ?></span>
            <small class="role-manager">QUẢN LÝ</small>
        </div>
        <a href="dangxuat.php" class="logout-icon" title="Đăng xuất">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </div>
</aside>