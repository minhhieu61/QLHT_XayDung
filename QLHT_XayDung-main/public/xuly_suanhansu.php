<?php
include_once 'ketnoi.php';
/** @var mysqli $conn */ 

if (isset($_POST['btnUpdate'])) {
    $id = intval($_POST['id']);
    $ho_ten = mysqli_real_escape_string($conn, $_POST['ho_ten']);
    $nam_sinh = mysqli_real_escape_string($conn, $_POST['nam_sinh']);
    $chuc_vu = mysqli_real_escape_string($conn, $_POST['chuc_vu']);
    $chuyen_nganh = mysqli_real_escape_string($conn, $_POST['chuyen_nganh']);
    $don_vi = mysqli_real_escape_string($conn, $_POST['don_vi']);
    $so_dien_thoai = mysqli_real_escape_string($conn, $_POST['so_dien_thoai']);

    $sql = "UPDATE nhan_su SET 
            ho_ten = '$ho_ten', 
            nam_sinh = '$nam_sinh', 
            chuc_vu = '$chuc_vu', 
            chuyen_nganh = '$chuyen_nganh', 
            don_vi = '$don_vi', 
            so_dien_thoai = '$so_dien_thoai' 
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Cập nhật nhân sự thành công!'); window.location.href='trangchu.php?p=nhansu';</script>";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>