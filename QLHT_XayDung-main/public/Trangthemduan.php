<?php
include 'ketnoi.php';
/** @var mysqli $conn */
if (isset($_POST['btnLuu'])) {
    $ma_da = mysqli_real_escape_string($conn, $_POST['ma_da']);
    $ten_du_an = mysqli_real_escape_string($conn, $_POST['ten_du_an']);
    $chu_dau_tu = mysqli_real_escape_string($conn, $_POST['chu_dau_tu']);
    $vi_tri = mysqli_real_escape_string($conn, $_POST['vi_tri']);

    $sql = "INSERT INTO duan (ma_da, ten_du_an, chu_dau_tu, vi_tri) 
            VALUES ('$ma_da', '$ten_du_an', '$chu_dau_tu', '$vi_tri')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Thêm thành công!'); window.location.href='trangchu.php?p=duan';</script>";
        exit;
    }
}
?>
<link rel="stylesheet" href="css/TrangThemDuAn.css">
<div class="duan-container">
    <form method="POST" class="form-grid">
        <div class="input-group"><label>Mã dự án</label><input type="text" name="ma_da" required></div>
        <div class="input-group"><label>Tên dự án</label><input type="text" name="ten_du_an" required></div>
        <div class="input-group"><label>Chủ đầu tư</label><input type="text" name="chu_dau_tu" required></div>
        <div class="input-group"><label>Vị trí</label><input type="text" name="vi_tri" required></div>
        
        <div class="form-actions">
            <button type="submit" name="btnLuu" class="btn-save">Lưu dự án</button>
            <a href="trangchu.php?p=duan" class="btn-cancel">Thoát</a>
        </div>
    </form>
</div>