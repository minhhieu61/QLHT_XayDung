<?php
/** @var mysqli $conn */
include 'ketnoi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Bảo mật: ép kiểu về số nguyên

    $sql = "DELETE FROM duan WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Đã xóa dự án thành công!');
                window.location.href='trangchu.php?p=danhsachduan';
              </script>";
    } else {
        echo "<script>
                alert('Lỗi: Không thể xóa dự án này.');
                window.history.back();
              </script>";
    }
}
?>