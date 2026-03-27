<link rel="stylesheet" href="css/TrangThemDuAn.css">

<div class="duan-container"> 
    <div class="form-card shadow-sm" style="background: #fff; padding: 35px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <div class="form-header" style="border-left: 5px solid #000077; padding-left: 15px; margin-bottom: 30px;">
            <h2 style="color: #000077; font-weight: 800; font-size: 1.5rem; text-transform: uppercase;">
                <i class="fas fa-plus-circle"></i> KHỞI TẠO DỰ ÁN MỚI
            </h2>
            <p style="color: #666; margin-top: 5px;">Vui lòng điền đầy đủ thông tin để lưu vào hệ thống VLUTE CMS</p>
        </div>

        <form action="xuly_themduan.php" method="POST">
            <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group full-width" style="grid-column: span 2;">
                    <label style="display: block; font-weight: 700; margin-bottom: 8px;">Tên dự án</label>
                    <input type="text" name="ten_duan" placeholder="Tên công trình/dự án..." required 
                           style="width: 100%; padding: 12px; border: 1px solid #edf2f9; border-radius: 10px; background: #fcfdfe;">
                </div>

                <div class="form-group">
                    <label style="display: block; font-weight: 700; margin-bottom: 8px;">Vị trí</label>
                    <input type="text" name="vi_tri" placeholder="Địa điểm triển khai..." required
                           style="width: 100%; padding: 12px; border: 1px solid #edf2f9; border-radius: 10px; background: #fcfdfe;">
                </div>
                
                <div class="form-group">
                    <label style="display: block; font-weight: 700; margin-bottom: 8px;">Dự kiến hoàn thành</label>
                    <input type="text" name="du_kien_xong" placeholder="Ví dụ: Quý IV/2026" required
                           style="width: 100%; padding: 12px; border: 1px solid #edf2f9; border-radius: 10px; background: #fcfdfe;">
                </div>

                <div class="form-group">
                    <label style="display: block; font-weight: 700; margin-bottom: 8px;">Chủ đầu tư</label>
                    <input type="text" name="chu_dau_tu" placeholder="Cơ quan chủ quản..." required
                           style="width: 100%; padding: 12px; border: 1px solid #edf2f9; border-radius: 10px; background: #fcfdfe;">
                </div>

                <div class="form-group">
                    <label style="display: block; font-weight: 700; margin-bottom: 8px;">Chủ thầu</label>
                    <input type="text" name="chu_thau" placeholder="Đơn vị thi công..." required
                           style="width: 100%; padding: 12px; border: 1px solid #edf2f9; border-radius: 10px; background: #fcfdfe;">
                </div>

                <div class="form-group full-width" style="grid-column: span 2;">
                    <label style="display: block; font-weight: 700; margin-bottom: 8px;">Tổng vốn đầu tư (VNĐ)</label>
                    <input type="number" name="tong_von" placeholder="Nhập số tiền..." required
                           style="width: 100%; padding: 12px; border: 1px solid #edf2f9; border-radius: 10px; background: #fcfdfe;">
                </div>

                <div class="form-group full-width" style="grid-column: span 2;">
                    <label style="display: block; font-weight: 700; margin-bottom: 8px;">Mô tả dự án</label>
                    <textarea name="mo_ta" rows="4" placeholder="Tóm tắt nội dung thực hiện..."
                              style="width: 100%; padding: 12px; border: 1px solid #edf2f9; border-radius: 10px; background: #fcfdfe;"></textarea>
                </div>
            </div>

            <div class="form-footer" style="margin-top: 30px; display: flex; justify-content: flex-end; gap: 15px; border-top: 1px solid #eee; padding-top: 20px;">
                <a href="trangchu.php?p=duan" class="btn-cancel" 
                   style="padding: 12px 30px; border-radius: 10px; background: #f1f5f9; color: #475569; text-decoration: none; font-weight: 700;">HỦY BỎ</a>
                <button type="submit" class="btn-submit" 
                        style="padding: 12px 30px; border-radius: 10px; background: #000077; color: white; border: none; font-weight: 700; cursor: pointer;">
                    XÁC NHẬN THÊM
                </button>
            </div>
        </form>
    </div>
</div>