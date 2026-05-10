<?php
session_start();

// 1. Kiểm tra xem đã đăng nhập chưa
if (!isset($_SESSION['role'])) {
    header("Location: dangnhap.php");
    exit();
}

// 2. RÀO CHẮN: Nếu là Admin hoặc Manager thì không được vào trangchu.php (của User)
if ($_SESSION['role'] === 'admin') {
    header("Location: admin_dashboard.php");
    exit();
} elseif ($_SESSION['role'] === 'manager') {
    header("Location: manager_dashboard.php");
    exit();
}

// Lấy tham số trang từ URL (ví dụ: trangchu.php?p=vattu)
// Nếu không có tham số p, mặc định sẽ hiện 'dashboard'
$p = isset($_GET['p']) ? $_GET['p'] : 'dashboard';

$page_title = "Hệ thống quản lý";
$current_page = $p; // Dùng biến này để Sidebar biết đang ở trang nào

// 2. Nhúng Header & Sidebar
include __DIR__ . '/../resources/views/layouts/user/header.php';
include __DIR__ . '/../resources/views/layouts/user/sidebar.php';
?>

<main class="content-area">
        <?php
            switch ($p) {
                case 'duan':
                    include 'Trangduan.php';
                    break;
                case 'chuthau':
                    include 'Trangchuthau.php';
                    break;
                case 'hoso':
                    include 'Tranghoso.php';
                    break;
                case 'taikhoan':
                    include 'taikhoan.php';
                    break;
                case 'themduan':
                    include 'Trangthemduan.php'; // Khi $p=themduan, trang này sẽ thay thế danh sách dự án
                    break;
                case 'chitietduan':
                    include 'TrangChiTietDuAn.php'; // Khi $p=themduan, trang này sẽ thay thế danh sách dự án
                    break;
                case 'dsns':
                    include 'TrangDSNhanSu.php';
                    break;
                case 'themnhansu':
                    include 'Trangthemnhansu.php';
                    break;
                case 'themhoso':
                    include 'Trangthemhoso.php';
                    break;
                case 'themchuthau':
                    include 'Trangthemchuthau.php';
                    break;
                case 'suachuthau':
                    include 'Trangsuachuthau.php';
                    break;
                case 'suanhansu':
                    include 'Trangsuanhansu.php'; // Trang vừa tạo ở trên
                    break;
                case 'dashboard':
                default:
                    include 'Trangtongquat.php';
                    break;
            }
        ?>
</main>

<?php
// 3. Nhúng Footer
include __DIR__ . '/../resources/views/layouts/user/footer.php';
?>