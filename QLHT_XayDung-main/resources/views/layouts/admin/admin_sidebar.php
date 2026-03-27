<aside class="side-panel">
    <div class="brand">
        <img src="img/logo.jpg" alt="Logo" onerror="this.src='https://upload.wikimedia.org/wikipedia/vi/c/c7/Logo-vlute.png'">
        <h3>ADMIN PANEL</h3>
    </div>

    <nav class="nav-menu">
        <a href="admin_dashboard.php" class="nav-link <?php echo (!isset($current_page) || $current_page == 'dashboard') ? 'active' : ''; ?>">
            <i class="fas fa-users-cog"></i> Quản lý tài khoản
        </a>

        <a href="cau_hinh_he_thong.php" class="nav-link <?php echo (isset($current_page) && $current_page == 'config') ? 'active' : ''; ?>">
            <i class="fas fa-cogs"></i> Cấu hình hệ thống
        </a>

        <a href="sao_luu_du_lieu.php" class="nav-link <?php echo (isset($current_page) && $current_page == 'backup') ? 'active' : ''; ?>">
            <i class="fas fa-database"></i> Sao lưu dữ liệu
        </a>

        <a href="dangxuat.php" class="nav-link">
            <i class="fas fa-arrow-left"></i> Về trang chủ
        </a>
    </nav>

    <div class="user-profile">
        <div class="avatar"><?php echo mb_substr($_SESSION['user'] ?? 'A', 0, 1, 'utf-8'); ?></div>
        <div class="info">
            <span><?php echo $_SESSION['user'] ?? 'Admin'; ?></span>
            <small>Quản trị viên</small>
        </div>
        <a href="dangxuat.php" class="logout-icon" title="Đăng xuất">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </div>
</aside>