<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'ketnoi.php';
/** @var mysqli $conn */ 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_du_an = mysqli_real_escape_string($conn, $_POST['ma_du_an']);
    $loai_tai_lieu = mysqli_real_escape_string($conn, $_POST['loai_tai_lieu']);
    $file = $_FILES['file_upload'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        $tmp_path = $file['tmp_name'];
        $ten_file = $file['name'];
        $noi_dung_raw = file_get_contents($tmp_path);
        
        // --- BƯỚC 1: KIỂM TRA MÃ HASH (ĐỂ ĐẠT 100% NẾU FILE GIỐNG HỆT) ---
        $hash_moi = hash('sha256', $noi_dung_raw);
        $ai_score = 0;
        $ai_status = "Normal";

        $check_hash = mysqli_query($conn, "SELECT id FROM tai_lieu WHERE hash_noi_dung = '$hash_moi' LIMIT 1");
        
        if (mysqli_num_rows($check_hash) > 0) {
            // Nếu mã Hash khớp, chắc chắn là 100% trùng lặp
            $ai_score = 100;
            $ai_status = "Duplicate";
        } else {
            // Nếu Hash không khớp, mới gọi AI để kiểm tra ngữ nghĩa (Semantic)
            $apiUrl = "http://localhost:8000/check-ai";
            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(["new_content" => $noi_dung_raw]));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $response = curl_exec($ch);
            
            if (!curl_errno($ch)) {
                $res = json_decode($response, true);
                $ai_score = $res['ai_score'] ?? 0;
                $ai_status = $res['ai_status'] ?? "Normal";
            }
            curl_close($ch);
        }

        // --- BƯỚC 2: LƯU FILE VẬT LÝ ---
        $upload_dir = __DIR__ . "/uploads/";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $ten_file_moi = time() . "_" . $ten_file;
        $target_file = $upload_dir . $ten_file_moi;

        if (move_uploaded_file($tmp_path, $target_file)) {
            // --- BƯỚC 3: LƯU VÀO CSDL ---
            $noi_dung_db = mysqli_real_escape_string($conn, $noi_dung_raw);
            $size_val = round($file['size'] / 1024, 2) . " KB";
            $db_path = "uploads/" . $ten_file_moi;

            $sql = "INSERT INTO tai_lieu (ma_du_an, ten_tai_lieu, loai_tai_lieu, duong_dan, noi_dung_van_ban, hash_noi_dung, ai_status, ai_score, kich_thuoc) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssssssss", 
                $ma_du_an, $ten_file, $loai_tai_lieu, $db_path, $noi_dung_db, $hash_moi, $ai_status, $ai_score, $size_val
            );
            
            if (mysqli_stmt_execute($stmt)) {
            // Thay vì echo, ta lưu kết quả vào SESSION và quay về trang hồ sơ
            $_SESSION['upload_msg'] = "Tải lên thành công! Tỉ lệ trùng lặp: $ai_score%";
            $_SESSION['upload_type'] = ($ai_score > 85) ? "danger" : (($ai_score > 50) ? "warning" : "success");
            
            header("Location: trangchu.php?p=hoso");
            exit();
        } else {
            $_SESSION['upload_msg'] = "Lỗi CSDL: " . mysqli_stmt_error($stmt);
            $_SESSION['upload_type'] = "danger";
            header("Location: trangchu.php?p=hoso");
            exit();
        }
        }
    }
}
else {
    // Nếu không phải POST, đẩy về trang chủ
    header("Location: trangchu.php?p=hoso");
}
?>