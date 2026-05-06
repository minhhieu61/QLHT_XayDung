<?php
include 'ketnoi.php';
/** @var mysqli $conn */ // Dòng này giúp VS Code nhận diện biến $conn
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['btnUpdate'])) {
    $user_id = $_POST['user_id'];
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $new_password = $_POST['new_password'];

    // 1. Cập nhật Họ tên trước
    $sql = "UPDATE accounts SET fullname = '$fullname' WHERE id = '$user_id'";
    
    if (mysqli_query($conn, $sql)) {
        // 2. Nếu người dùng có nhập mật khẩu mới thì mới cập nhật mật khẩu
        if (!empty($new_password)) {
            // Mã hóa mật khẩu theo chuẩn Bcrypt (giống trong ảnh CSDL của bạn)
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            $sql_pass = "UPDATE accounts SET password = '$hashed_password' WHERE id = '$user_id'";
            mysqli_query($conn, $sql_pass);
        }

        // Thông báo thành công và quay lại trang cũ
        echo "<script>
                alert('Cập nhật thông tin thành công!');
                window.location.href = 'trangchu.php?page=taikhoan'; 
              </script>";
    } else {
        echo "Lỗi cập nhật: " . mysqli_error($conn);
    }
} else {
    // Nếu truy cập trực tiếp file này mà không nhấn nút thì đẩy về trang chủ
    header("Location: trangchu.php");
    exit();
}
?>