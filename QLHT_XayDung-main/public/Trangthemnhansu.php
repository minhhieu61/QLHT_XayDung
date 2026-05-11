<link rel="stylesheet" href="css/danhsachnhansu.css">
<style>
    /* 1. Thiết lập Container tràn toàn màn hình */
    .duan-container {
        width: 100%;
        max-width: 100% !important; /* Phá bỏ giới hạn 900px */
        padding: 20px 40px;
        box-sizing: border-box;
    }

    /* 2. Header xanh tràn theo container */
    .header-top-ql {
        width: 100%;
        background: #1e3c72;
        padding: 25px 30px;
        border-radius: 12px;
        margin-bottom: 25px;
        color: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    /* 3. Form Card tối ưu cho màn hình rộng */
    .form-card-custom {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        padding: 40px;
        margin: 0 auto 40px; /* Bỏ margin âm nếu muốn giao diện phẳng, hoặc giữ nếu muốn đè header */
        width: 100%;
        position: relative;
        z-index: 10;
        box-sizing: border-box;
    }
    
    /* 4. Chia lưới 2 cột cho màn hình rộng */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr; /* Chia đôi không gian */
        gap: 30px;
        margin-bottom: 30px;
    }
    
    .form-group { display: flex; flex-direction: column; gap: 8px; }
    
    .form-group label {
        font-weight: 600;
        color: #1e3c72;
        font-size: 0.95rem;
    }
    
    .form-control {
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8fafc;
        width: 100%;
        box-sizing: border-box;
    }
    
    .form-control:focus {
        border-color: #1e3c72;
        box-shadow: 0 0 0 3px rgba(30, 60, 114, 0.1);
        background: #fff;
        outline: none;
    }
    
    /* Trường Chuyên ngành cho dài hết hàng */
    .full-width { grid-column: span 2; }
    
    .action-btns-form {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        border-top: 2px solid #f1f5f9;
        padding-top: 25px;
    }

    .btn-save-staff {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        border: none;
        padding: 14px 40px;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: 0.3s;
    }
    
    .btn-save-staff:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(30, 60, 114, 0.3);
    }
    
    .btn-cancel-staff {
        background: #f1f5f9;
        color: #64748b;
        padding: 14px 30px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        text-align: center;
        transition: 0.3s;
    }
    .btn-cancel-staff:hover { background: #e2e8f0; }
</style>

<div class="duan-container">
    <div class="header-top-ql">
        <div class="header-title-ql">
            <h1><i class="fas fa-user-plus"></i> TIẾP NHẬN NHÂN SỰ</h1>
            <p>Thiết lập hồ sơ cán bộ mới cho hệ thống quản lý VLUTE CMS</p>
        </div>
    </div>

    <div class="form-card-custom">
        <form action="xuly_themnhansu.php" method="POST">
            <div style="margin-bottom: 25px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;">
                <h3 style="color: #1e3c72; margin: 0; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-id-card"></i> Thông tin cán bộ chi tiết
                </h3>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label>Mã nhân viên (ID) *</label>
                    <input type="text" name="ma_nv" class="form-control" placeholder="Ví dụ: NS-202601" required>
                </div>
                
                <div class="form-group">
                    <label>Họ và Tên *</label>
                    <input type="text" name="ho_ten" class="form-control" placeholder="Nhập đầy đủ họ tên..." required>
                </div>
                
                <div class="form-group">
                    <label>Năm sinh</label>
                    <input type="number" name="nam_sinh" class="form-control" placeholder="1995" min="1950" max="2010">
                </div>
                
                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="text" name="so_dien_thoai" class="form-control" placeholder="0912345xxx">
                </div>
                
                <div class="form-group">
                    <label>Chức vụ</label>
                    <select name="chuc_vu" class="form-control">
                        <option value="Quản lý dự án">Quản lý dự án</option>
                        <option value="Kế toán trưởng">Kế toán trưởng</option>
                        <option value="Kỹ sư trưởng">Kỹ sư trưởng</option>
                        <option value="Cán bộ kỹ thuật">Cán bộ kỹ thuật</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Đơn vị công tác</label>
                    <input type="text" name="don_vi" class="form-control" placeholder="Phòng Kiến Trúc / Phòng Tài Chính...">
                </div>
                
                <div class="form-group full-width">
                    <label>Chuyên ngành đào tạo</label>
                    <input type="text" name="chuyen_nganh" class="form-control" placeholder="Kỹ thuật Xây dựng / Kế toán tổng hợp...">
                </div>
            </div>

            <div class="action-btns-form">
                <a href="trangchu.php?p=dsns" class="btn-cancel-staff">
                    <i class="fas fa-times"></i> Hủy bỏ
                </a>
                <button type="submit" name="btnSave" class="btn-save-staff">
                    <i class="fas fa-save"></i> Lưu hồ sơ nhân sự
                </button>
            </div>
        </form>
    </div>
</div>