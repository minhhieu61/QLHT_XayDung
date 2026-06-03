<?php
session_start();
// Nếu đã đăng nhập thì tự động đẩy vào trang chủ quản trị, không cho xem trang giới thiệu nữa
if (isset($_SESSION['user'])) {
    header("Location: trangchu.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản lý Công trình - VLUTE</title>
    <!-- Đảm bảo đường dẫn CSS đúng với thư mục của bạn -->
    <link rel="stylesheet" href="css/home.css">
</head>

<body>

    <header id="dau-trang">
        <div class="khung-dau-trang">
            <div class="logo-ben-trai">
                <img src="img/logo.jpg" alt="Logo VLUTE">
            </div>
            <div class="ten-truong-giua">
                <h1>TRƯỜNG ĐẠI HỌC SƯ PHẠM KỸ THUẬT VĨNH LONG</h1>
                <p class="mo-ta">Vinh Long University of Technology Education</p>
            </div>
            <div class="khoang-trong-phai"></div>
        </div>
    </header>

    <nav class="hop-menu">
        <div class="khung-dieu-huong">
            <div class="nhom-trai">
                <!-- Sửa lại link về chính trang home.php -->
                <!-- <a href="home.php" class="nut nut-trang-chu">Trang Chủ</a> -->
            </div>
            <div class="nhom-phai">
                <a href="dangnhap.php" class="nut nut-dang-nhap">Đăng Nhập</a>
                <a href="dangky.php" class="nut nut-dang-ky">Đăng Ký</a>
            </div>
        </div>
    </nav>

    <section class="banner-chinh">
        <div class="anh-nen-duy-nhat">
            <img src="img/anhtruong31.jpg" alt="VLUTE Campus" onerror="this.src='https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=1350&q=80'">
        </div>

        <div class="lop-phu-nen">
            <div class="van-ban-banner">
                <!-- Cập nhật tiêu đề chính -->
                <h2>HỆ THỐNG QUẢN LÝ CÔNG TRÌNH XÂY DỰNG</h2>
                <p>Giải pháp tối ưu cho công tác theo dõi tiến độ và quản lý dự án nhà trường</p>
                <a href="dangnhap.php" class="nut-hanh-dong">Bắt đầu ngay</a>
            </div>
        </div>
    </section>

    <main class="noi-dung-thong-tin">
        <div class="the-thong-tin">
            <span class="bieu-tuong">🏗️</span>
            <h3>Dự Án Xây Dựng</h3>
            <p>Theo dõi danh sách các công trình đang thi công và đã hoàn thành tại VLUTE.</p>
        </div>
        <div class="the-thong-tin">
            <span class="bieu-tuong">📊</span>
            <h3>Tiến Độ & Giám Sát</h3>
            <p>Cập nhật trạng thái thực hiện, thời gian bắt đầu công trình.</p>
        </div>
        <div class="the-thong-tin">
            <span class="bieu-tuong">👷</span>
            <h3>Nhân Lực & Vật Tư</h3>
            <p>Quản lý từng công trình xây dựng cụ thể.</p>
        </div>
    </main>

    <footer id="chan-trang">
        <p><strong>&copy; 2026 TRƯỜNG ĐẠI HỌC SƯ PHẠM KỸ THUẬT VĨNH LONG</strong></p>
        <p>Sáng tạo - Trách nhiệm - Thích ứng</p>
    </footer>

</body>

</html>