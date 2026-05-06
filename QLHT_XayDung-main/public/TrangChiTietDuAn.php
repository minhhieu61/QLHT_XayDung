<?php
include 'ketnoi.php';
/** @var mysqli $conn */
$id = intval($_GET['id']);

if (isset($_POST['btnLuu'])) {
    $ma_da = mysqli_real_escape_string($conn, $_POST['ma_da']);
    $ten_du_an = mysqli_real_escape_string($conn, $_POST['ten_du_an']);
    $chu_dau_tu = mysqli_real_escape_string($conn, $_POST['chu_dau_tu']);
    $vi_tri = mysqli_real_escape_string($conn, $_POST['vi_tri']);

    $sql = "UPDATE duan SET ma_da='$ma_da', ten_du_an='$ten_du_an', chu_dau_tu='$chu_dau_tu', vi_tri='$vi_tri' WHERE id=$id";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Cập nhật thành công!'); window.location.href='trangchu.php?p=duan';</script>";
        exit;
    }
}

$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM duan WHERE id=$id"));
?>
<link rel="stylesheet" href="css/chitietduan.css">
<div class="duan-container">
    <form method="POST" class="form-grid">
        <div class="input-group"><label>Mã dự án</label><input type="text" name="ma_da" value="<?php echo $row['ma_da']; ?>"></div>
        <div class="input-group"><label>Tên dự án</label><input type="text" name="ten_du_an" value="<?php echo $row['ten_du_an']; ?>"></div>
        <div class="input-group"><label>Chủ đầu tư</label><input type="text" name="chu_dau_tu" value="<?php echo $row['chu_dau_tu']; ?>"></div>
        <div class="input-group"><label>Vị trí</label><input type="text" name="vi_tri" value="<?php echo $row['vi_tri']; ?>"></div>
        <div class="input-group"><label>Ngày tạo (Không thể sửa)</label><input type="text" value="<?php echo $row['ngay_tao']; ?>" disabled style="background:#eee;"></div>
        
        <div class="form-actions">
            <button type="submit" name="btnLuu" class="btn-save">Cập nhật</button>
            <a href="trangchu.php?p=duan" class="btn-cancel">Thoát</a>
        </div>
    </form>
</div>