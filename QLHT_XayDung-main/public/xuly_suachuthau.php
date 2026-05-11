<?php
include_once 'ketnoi.php';
/** @var mysqli $conn */ 

if (isset($_POST['btnUpdate'])) {
    $id = intval($_POST['id']);
    $ten_don_vi = mysqli_real_escape_string($conn, $_POST['ten_don_vi']);
    $nguoi_dai_dien = mysqli_real_escape_string($conn, $_POST['nguoi_dai_dien']);
    $so_dien_thoai = mysqli_real_escape_string($conn, $_POST['so_dien_thoai']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $tong_von = $_POST['tong_von'];
    $trang_thai = $_POST['trang_thai'];

    $sql = "UPDATE chuthau SET 
            ten_don_vi = '$ten_don_vi', 
            nguoi_dai_dien = '$nguoi_dai_dien', 
            so_dien_thoai = '$so_dien_thoai', 
            email = '$email', 
            tong_von = '$tong_von', 
            trang_thai = '$trang_thai' 
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Cập nhật thông tin chủ thầu thành công!'); window.location.href='trangchu.php?p=chuthau';</script>";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>