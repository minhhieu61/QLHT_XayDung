<?php
include_once 'ketnoi.php';
/** @var mysqli $conn */ 

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT * FROM chuthau WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("<script>alert('Không tìm thấy chủ thầu!'); window.location.href='trangchu.php?p=chuthau';</script>");
}
?>

<link rel="stylesheet" href="css/danhsachnhansu.css"> <style>
    .form-card-custom {
        background: #fff; border-radius: 15px; padding: 40px;
        margin: -30px auto 40px; max-width: 900px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08); position: relative; z-index: 10;
    }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
    .form-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 15px; }
    .form-control {
        padding: 12px; border: 1px solid #ddd; border-radius: 8px;
        background: #f8fafc; outline: none; transition: 0.3s;
    }
    .form-control:focus { border-color: #1e3c72; box-shadow: 0 0 0 3px rgba(30, 60, 114, 0.1); }
    .full-width { grid-column: span 2; }
    .btn-save {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white; border: none; padding: 14px 30px; border-radius: 8px;
        font-weight: 700; cursor: pointer; transition: 0.3s;
    }
    .btn-save:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(30, 60, 114, 0.3); }
</style>

<div class="duan-container">
    <div class="header-top-ql">
        <div class="header-title-ql">
            <h1><i class="fas fa-edit"></i> CẬP NHẬT THÔNG TIN CHỦ THẦU</h1>
            <p>Chỉnh sửa thông tin đơn vị thầu: <strong><?php echo $row['ten_don_vi']; ?></strong></p>
        </div>
    </div>

    <div class="form-card-custom">
        <form action="xuly_suachuthau.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            
            <div class="form-grid">
                <div class="form-group">
                    <label>Mã chủ thầu (Mã CT)</label>
                    <input type="text" name="ma_ct" class="form-control" value="<?php echo $row['ma_ct']; ?>" readonly style="background: #e9ecef;">
                </div>
                
                <div class="form-group">
                    <label>Tên đơn vị thầu</label>
                    <input type="text" name="ten_don_vi" class="form-control" value="<?php echo $row['ten_don_vi']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Người đại diện</label>
                    <input type="text" name="nguoi_dai_dien" class="form-control" value="<?php echo $row['nguoi_dai_dien']; ?>">
                </div>

                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="text" name="so_dien_thoai" class="form-control" value="<?php echo $row['so_dien_thoai']; ?>">
                </div>

                <div class="form-group">
                    <label>Email liên hệ</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>">
                </div>

                <div class="form-group">
                    <label>Tổng vốn đầu tư (VNĐ)</label>
                    <input type="number" name="tong_von" class="form-control" value="<?php echo (int)$row['tong_von']; ?>">
                </div>

                <div class="form-group full-width">
                    <label>Trạng thái hợp tác</label>
                    <select name="trang_thai" class="form-control">
                        <option value="Đang hợp tác" <?php if($row['trang_thai'] == 'Đang hợp tác') echo 'selected'; ?>>Đang hợp tác</option>
                        <option value="Đang trống" <?php if($row['trang_thai'] == 'Đang trống') echo 'selected'; ?>>Đang trống</option>
                        <option value="Ngừng hợp tác" <?php if($row['trang_thai'] == 'Ngừng hợp tác') echo 'selected'; ?>>Ngừng hợp tác</option>
                    </select>
                </div>
            </div>

            <div style="display: flex; gap: 15px; justify-content: flex-end; margin-top: 25px; border-top: 1px solid #eee; padding-top: 20px;">
                <a href="trangchu.php?p=chuthau" style="text-decoration:none; color: #666; padding: 14px 20px;">Hủy bỏ</a>
                <button type="submit" name="btnUpdate" class="btn-save">
                    <i class="fas fa-save"></i> CẬP NHẬT DỮ LIỆU
                </button>
            </div>
        </form>
    </div>
</div>