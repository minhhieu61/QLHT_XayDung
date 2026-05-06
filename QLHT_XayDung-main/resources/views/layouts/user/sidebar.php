<nav class="side-panel">
    <div class="brand">
        <img src="img/logo.jpg" alt="Logo" onerror="this.src='https://upload.wikimedia.org/wikipedia/vi/c/c7/Logo-vlute.png'">
        <h3>VLUTE CMS</h3>
    </div>

    <nav class="nav-menu">
        <a href="trangchu.php?p=dashboard" class="nav-link <?php echo ($p == 'dashboard') ? 'active' : ''; ?>">
            <i class="fas fa-home"></i> Tổng quan
        </a>
        <a href="trangchu.php?p=duan" class="nav-link <?php echo ($p == 'vattu') ? 'active' : ''; ?>">
            <i class="fas fa-boxes"></i> Danh sách dự án
        </a>
        <a href="trangchu.php?p=chuthau" class="nav-link">
            <i class="fas fa-project-diagram"></i> Danh sách chủ thầu
        </a>
        <a href="trangchu.php?p=dsns" class="nav-link">
            <i class="fas fa-project-diagram"></i> Danh sách nhân sự
        </a>
        <a href="trangchu.php?p=thongke" class="nav-link">
            <i class="fas fa-project-diagram"></i> Hồ sơ
        </a>
        <a href="trangchu.php?p=taikhoan" class="nav-link">
            <i class="fas fa-project-diagram"></i> Tài khoản
        </a>
    </nav>

    <div class="user-profile">
        <div class="avatar">
            <?php echo mb_substr($_SESSION['user'] ?? 'U', 0, 1, 'utf-8'); ?>
        </div>
        <div class="info">
            <span><?php echo $_SESSION['user'] ?? 'Người dùng'; ?></span>
            <small>Nhân viên</small>
        </div>
        <a href="dangxuat.php" class="logout-icon" title="Đăng xuất">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </div>
</nav>