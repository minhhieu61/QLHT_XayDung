<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once 'ketnoi.php';
/** @var mysqli $conn */ 

if (isset($_POST['btnUpload'])) {
    $ma_du_an = mysqli_real_escape_string($conn, $_POST['ma_du_an']);
    $loai_tai_lieu = mysqli_real_escape_string($conn, $_POST['loai_tai_lieu']);
    $file = $_FILES['file_upload'];

    if ($file['error'] !== UPLOAD_ERR_OK) { die("Lỗi tệp tin."); }

    $tmp_path = $file['tmp_name'];
    $ten_file = $file['name'];
    $noi_dung_raw = file_get_contents($tmp_path);

    // 1. Gọi AI (Timeout 5s để không làm treo trang)
    $ai_score = 0; $ai_status = "Normal";
    $ch = curl_init("http://localhost:8000/check-ai");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(["new_content" => $noi_dung_raw]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $response = curl_exec($ch);
    if (!curl_errno($ch)) {
        $res = json_decode($response, true);
        $ai_score = $res['ai_score'] ?? 0;
        $ai_status = $res['ai_status'] ?? "Normal";
    }
    curl_close($ch);

    // 2. Lưu file vào thư mục
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
    $ten_file_moi = time() . "_" . $ten_file;
    $target_file = $upload_dir . $ten_file_moi;

    if (move_uploaded_file($tmp_path, $target_file)) {
        // 3. Ghi CSDL
        $noi_dung_db = mysqli_real_escape_string($conn, $noi_dung_raw);
        $hash_val = hash('sha256', $noi_dung_raw);
        $size_val = round($file['size'] / 1024, 2) . " KB";
        $db_path = "uploads/" . $ten_file_moi;

        $sql = "INSERT INTO tai_lieu (ma_du_an, ten_tai_lieu, loai_tai_lieu, duong_dan, noi_dung_van_ban, hash_noi_dung, ai_status, ai_score, kich_thuoc) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssds", $ma_du_an, $ten_file, $loai_tai_lieu, $db_path, $noi_dung_db, $hash_val, $ai_status, $ai_score, $size_val);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Lưu thành công! AI: $ai_status ($ai_score%)'); window.location.href='trangchu.php?p=hoso';</script>";
        } else {
            unlink($target_file);
            die("Lỗi SQL: " . mysqli_stmt_error($stmt));
        }
    } else {
        die("Không thể lưu file vào thư mục uploads.");
    }
}else {
    header("Location: trangchu.php?p=hoso");
    exit();
}
?>