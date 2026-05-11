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
        echo "<script>alert('Khởi tạo dự án thành công!'); window.location.href='trangchu.php?p=duan';</script>";
        exit;
    }
}
?>

<style>
    /* 1. Thiết lập Container tràn màn hình */
    .duan-full-container {
        width: 100%;
        padding: 20px 30px;
        box-sizing: border-box;
    }

    /* 2. Header xanh Deep Blue */
    .header-top-ql {
        background: #1e3c72;
        padding: 25px 30px;
        border-radius: 12px;
        margin-bottom: 25px;
        color: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .header-title-ql h1 {
        margin: 0;
        font-size: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        text-transform: uppercase;
    }

    /* 3. Form Grid Layout (Toàn màn hình) */
    .form-card {
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        display: grid;
        grid-template-columns: 1fr 1fr; /* Chia 2 cột */
        gap: 25px;
    }

    .input-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    /* Ô nhập liệu dài tràn 2 cột (cho Tên và Vị trí) */
    .full-row {
        grid-column: span 2;
    }

    .input-group label {
        font-weight: 600;
        color: #1e3c72;
        font-size: 0.95rem;
    }

    .input-group input {
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
        background: #f8fbff;
        transition: 0.3s;
    }

    .input-group input:focus {
        border-color: #1e3c72;
        background: white;
        outline: none;
        box-shadow: 0 0 0 4px rgba(30, 60, 114, 0.1);
    }

    /* 4. Nút bấm */
    .form-actions {
        grid-column: span 2;
        display: flex;
        gap: 15px;
        margin-top: 20px;
        padding-top: 25px;
        border-top: 1px solid #eee;
    }

    .btn-save {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        border: none;
        padding: 15px 40px;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(30, 60, 114, 0.3);
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #64748b;
        padding: 15px 30px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        text-align: center;
        transition: 0.3s;
    }
</style>

<div class="duan-full-container">
    <div class="header-top-ql">
        <div class="header-title-ql">
            <h1><i class="fas fa-folder-plus"></i> KHỞI TẠO DỰ ÁN MỚI</h1>
            <p style="margin: 8px 0 0 0; opacity: 0.9;">Thiết lập thông tin quy hoạch và dự án xây dựng cho hệ thống quản trị VLUTE CMS</p>
        </div>
    </div>

    <form method="POST" class="form-card">
        <div class="input-group">
            <label>Mã dự án (ID) *</label>
            <input type="text" name="ma_da" placeholder="Ví dụ: DA-2026-001" required>
        </div>

        <div class="input-group">
            <label>Chủ đầu tư *</label>
            <input type="text" name="chu_dau_tu" placeholder="Tên công ty / Đơn vị chủ quản..." required>
        </div>

        <div class="input-group full-row">
            <label>Tên dự án *</label>
            <input type="text" name="ten_du_an" placeholder="Nhập tên đầy đủ của dự án..." required>
        </div>

        <div class="input-group full-row">
            <label>Vị trí triển khai / Địa điểm xây dựng *</label>
            <input type="text" name="vi_tri" placeholder="Địa chỉ chi tiết nơi thi công..." required>
        </div>
        
        <div class="form-actions">
            <button type="submit" name="btnLuu" class="btn-save">
                <i class="fas fa-save"></i> LƯU DỰ ÁN VÀO HỆ THỐNG
            </button>
            <a href="trangchu.php?p=duan" class="btn-cancel">
                HỦY BỎ
            </a>
        </div>
    </form>
</div>