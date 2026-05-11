<?php
include_once 'ketnoi.php';
/** @var mysqli $conn */ 

if (isset($_POST['btnSave'])) {
    // Lấy và làm sạch dữ liệu
    $ma_nv = mysqli_real_escape_string($conn, $_POST['ma_nv']);
    $ho_ten = mysqli_real_escape_string($conn, $_POST['ho_ten']);
    $nam_sinh = intval($_POST['nam_sinh']);
    $chuc_vu = mysqli_real_escape_string($conn, $_POST['chuc_vu']);
    $chuyen_nganh = mysqli_real_escape_string($conn, $_POST['chuyen_nganh']);
    $don_vi = mysqli_real_escape_string($conn, $_POST['don_vi']);
    $so_dien_thoai = mysqli_real_escape_string($conn, $_POST['so_dien_thoai']);

    // Kiểm tra trùng mã nhân viên
    $check_sql = "SELECT id FROM nhan_su WHERE ma_nv = '$ma_nv'";
    $check_res = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_res) > 0) {
        echo "<script>alert('Lỗi: Mã nhân viên này đã tồn tại trên hệ thống!'); window.history.back();</script>";
        exit();
    }

    // Thực hiện lưu
    $sql = "INSERT INTO nhan_su (ma_nv, ho_ten, nam_sinh, chuc_vu, chuyen_nganh, don_vi, so_dien_thoai) 
            VALUES ('$ma_nv', '$ho_ten', '$nam_sinh', '$chuc_vu', '$chuyen_nganh', '$don_vi', '$so_dien_thoai')";

    if (mysqli_query($conn, $sql)) {
        echo "window.location.href='trangchu.php?p=dsns';</script>";
    } else {
        echo "Lỗi CSDL: " . mysqli_error($conn);
    }
}
?>