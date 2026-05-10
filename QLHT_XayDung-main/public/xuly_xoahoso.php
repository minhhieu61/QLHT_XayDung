<?php
session_start();
include_once 'ketnoi.php';
/** @var mysqli $conn */ 

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // 1. Lấy đường dẫn file để xóa file vật lý
    $sql_get = "SELECT duong_dan FROM tai_lieu WHERE id = $id";
    $res_get = mysqli_query($conn, $sql_get);
    $row = mysqli_fetch_assoc($res_get);

    if ($row) {
        $file_path = __DIR__ . "/" . $row['duong_dan'];
        if (file_exists($file_path)) {
            unlink($file_path); // Xóa file khỏi ổ đĩa
        }
    }

    // 2. Xóa dữ liệu trong CSDL
    $sql_del = "DELETE FROM tai_lieu WHERE id = $id";
    if (mysqli_query($conn, $sql_del)) {
        $_SESSION['msg'] = "Đã xóa hồ sơ thành công!";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['msg'] = "Lỗi khi xóa dữ liệu.";
        $_SESSION['msg_type'] = "danger";
    }
}

header("Location: trangchu.php?p=hoso");
exit();
?>