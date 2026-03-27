<?php
// Kiểm tra xem người dùng có đang xem một dự án cụ thể không
$project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($project_id > 0) {
    // TRƯỜNG HỢP 1: HIỂN THỊ CHI TIẾT DỰ ÁN (Có các Tabs: Vật tư, Kinh phí...)
    include 'manager_chitiet_duan.php';
} else {
    // TRƯỜNG HỢP 2: HIỂN THỊ DANH SÁCH CÁC Ô DỰ ÁN (Mặc định)
    include 'manager_list_duan.php';
}
