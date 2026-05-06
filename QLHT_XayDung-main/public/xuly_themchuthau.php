<?php
include 'ketnoi.php';
/** @var mysqli $conn */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_ct = $_POST['ma_ct'];
    $ten_don_vi = $_POST['ten_don_vi'];
    $nguoi_dai_dien = $_POST['nguoi_dai_dien'];
    $so_dien_thoai = $_POST['so_dien_thoai'];
    $email = $_POST['email'];
    $tong_von = $_POST['tong_von'];
    $trang_thai = $_POST['trang_thai'];

    $sql = "INSERT INTO chuthau (ma_ct, ten_don_vi, nguoi_dai_dien, so_dien_thoai, email, tong_von, trang_thai) 
            VALUES ('$ma_ct', '$ten_don_vi', '$nguoi_dai_dien', '$so_dien_thoai', '$email', '$tong_von', '$trang_thai')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Thêm thành công!'); window.location.href='trangchu.php?p=danhsachchuthau';</script>";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>