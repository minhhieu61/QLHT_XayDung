<?php
session_start();

// 1. Bảo mật: Chỉ cho phép Manager
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'manager') {
    header("Location: dangnhap.php");
    exit();
}

// 2. Lấy tham số trang từ URL (Khớp với các href trong Sidebar)
$p = isset($_GET['p']) ? $_GET['p'] : 'dashboard';
$current_page = $p;
$page_title = "Khu vực Quản lý - VLUTE CMS";

// 3. Nhúng Giao diện khung (Layout)
include __DIR__ . '/../resources/views/layouts/manager/manager_header.php';
include __DIR__ . '/../resources/views/layouts/manager/manager_sidebar.php';
?>

<link rel="stylesheet" href="css/manager_dashboard.css">

<main class="content-area">
    <?php
    // ĐỒNG BỘ TÊN FILE THEO THAM SỐ $p
    switch ($p) {
        case 'dashboard':
            // Trang nội dung thống kê tổng quan
            include 'manager_main_content.php';
            break;

        case 'giamsat_duan':
            // Trang giám sát dự án
            include 'manager_giamsat_duan.php';
            break;

        case 'vattu_thietbi':
            // Trang kho vật tư
            include 'manager_vattu_thietbi.php';
            break;

        case 'doi_ngu':
            // Trang đội ngũ thi công
            include 'manager_doi_ngu.php';
            break;

        case 'baocao_kinhphi':
            // Trang tài chính
            include 'manager_baocao_kinhphi.php';
            break;
        case 'luutru_hoso':
            // Trang tài chính
            include 'manager_luutru_hoso.php';
            break;

        default:
            // Nếu tham số lạ, quay về dashboard
            include 'manager_main_content.php';
            break;
    }
    ?>
</main>

<?php
include __DIR__ . '/../resources/views/layouts/manager/manager_footer.php';
?>