<?php
include_once 'ketnoi.php';
/** @var mysqli $conn */ 

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT * FROM nhan_su WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("<script>alert('Không tìm thấy nhân sự!'); window.location.href='trangchu.php?p=nhansu';</script>");
}
?>
<style>
    /* Container chứa 2 nút */
.form-actions {
    margin-top: 30px;
    display: flex;
    gap: 15px;
}

/* Định dạng chung cho nút */
.btn-submit, .btn-cancel {
    padding: 12px 25px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border: none;
    text-decoration: none;
}

/* Nút LƯU CẬP NHẬT (Màu xanh đậm Deep Blue) */
.btn-submit {
    background: linear-gradient(to right, #1e3c72, #2a5298);
    color: white;
    flex: 2; /* Nút này rộng hơn để nhấn mạnh */
}

.btn-submit:hover {
    opacity: 0.9;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(30, 60, 114, 0.3);
}

/* Nút HỦY BỎ (Màu đỏ nhạt hoặc xám) */
.btn-cancel {
    background-color: #f5f5f5;
    color: #666;
    flex: 1;
    border: 1px solid #ddd;
}

.btn-cancel:hover {
    background-color: #ffebee; /* Chuyển sang đỏ nhạt khi hover */
    color: #d32f2f;
    border-color: #ffcdd2;
}

/* Icon trong nút */
.btn-submit i, .btn-cancel i {
    font-size: 1.1rem;
}
</style>
<div class="archive-wrapper">
    <div class="archive-header" style="margin-bottom: 20px;">
        <div class="header-title">
            <h2><i class="fas fa-user-edit"></i> Chỉnh sửa nhân sự</h2>
            <p>Cập nhật thông tin cán bộ: <strong><?php echo $row['ho_ten']; ?></strong></p>
        </div>
    </div>

    <div style="max-width: 800px; margin: auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <form action="xuly_suanhansu.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="input-group">
                    <label style="display:block; margin-bottom:8px; font-weight:600;">Họ tên:</label>
                    <input type="text" name="ho_ten" value="<?php echo $row['ho_ten']; ?>" required
                           style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;">
                </div>

                <div class="input-group">
                    <label style="display:block; margin-bottom:8px; font-weight:600;">Năm sinh:</label>
                    <input type="number" name="nam_sinh" value="<?php echo $row['nam_sinh']; ?>"
                           style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;">
                </div>

                <div class="input-group">
                    <label style="display:block; margin-bottom:8px; font-weight:600;">Chức vụ:</label>
                    <input type="text" name="chuc_vu" value="<?php echo $row['chuc_vu']; ?>"
                           style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;">
                </div>

                <div class="input-group">
                    <label style="display:block; margin-bottom:8px; font-weight:600;">Chuyên ngành:</label>
                    <input type="text" name="chuyen_nganh" value="<?php echo $row['chuyen_nganh']; ?>"
                           style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;">
                </div>

                <div class="input-group">
                    <label style="display:block; margin-bottom:8px; font-weight:600;">Đơn vị:</label>
                    <input type="text" name="don_vi" value="<?php echo $row['don_vi']; ?>"
                           style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;">
                </div>
            </div>

            <div class="input-group" style="margin-top:20px;">
                <label style="display:block; margin-bottom:8px; font-weight:600;">Số điện thoại:</label>
                <input type="text" name="so_dien_thoai" value="<?php echo $row['so_dien_thoai']; ?>"
                       style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;">
            </div>

            <div style="margin-top: 30px; display: flex; gap: 15px;">
                <button type="submit" name="btnUpdate" class="btn-submit" >
                    <i class="fas fa-save"></i> Lưu cập nhật
                </button>
                <a href="trangchu.php?p=dsns" class="btn-cancel">
                    Hủy bỏ
                </a>
            </div>
        </form>
    </div>
</div>